<?php

namespace LQNL\AutenticacaoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LQNL\AutenticacaoBundle\Entity\Usuario;
use LQNL\AutenticacaoBundle\Entity\Endereco;
use LQNL\AutenticacaoBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller {

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AutenticacaoBundle:Usuario')->findAll();

        return $this->render('AutenticacaoBundle:Usuario:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $endereco = new Endereco();
        $endereco->setCep($request->get('cep'));
        $endereco->setRua($request->get('rua'));
        $endereco->setNumero($request->get('numero'));
        $endereco->setBairro($request->get('bairro'));
        $endereco->setCidade($request->get('cidade'));
        $endereco->setUf($request->get('uf'));
        $endereco->setComplemento($request->get('complemento'));


        $em->persist($endereco);
        $em->flush();

        $novoEndereco = $em->getRepository('AutenticacaoBundle:Endereco')->findOneBy(array('cep' => $endereco->getCep(), 'rua' => $endereco->getRua(), 'bairro' => $endereco->getBairro(), 'cidade' => $endereco->getCidade(), 'uf' => $endereco->getUf(), 'complemento' => $endereco->getComplemento()));
        $entity->setEndereco($novoEndereco);

        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        $encodedPass = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());

        $entity->setPassword($encodedPass);

        $entity->setTipo(1);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->redirect($this->generateUrl('novo_usuario', array('id' => $entity->getId())));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
//    public function createAction(Request $request) {
//        $entity = new Usuario();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//        
//        $password = md5($entity->getPassword());
//        $entity->setPassword($password);
//
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $entity->getId())));
//        }
//
//        return $this->render('AutenticacaoBundle:Usuario:new.html.twig', array(
//                    'entity' => $entity,
//                    'form' => $form->createView(),
//        ));
//    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity) {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction() {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);

        return $this->render('AutenticacaoBundle:Usuario:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AutenticacaoBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AutenticacaoBundle:Usuario:show.html.twig', array(
                    'usuario' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AutenticacaoBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $endereco = $em->getRepository('AutenticacaoBundle:Endereco')->find($entity->getEndereco());

        return $this->render('AutenticacaoBundle:Usuario:edit.html.twig', array(
                    'usuario' => $entity,
                    'endereco' => $endereco,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AutenticacaoBundle:Usuario')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        $encodedPass = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());

        $entity->setPassword($encodedPass);

        if ($editForm->isValid()) {
            $endereco = $em->getRepository('AutenticacaoBundle:Endereco')->find($entity->getEndereco()->getId());
            $endereco->setCep($request->get('cep'));
            $endereco->setRua($request->get('rua'));
            $endereco->setNumero($request->get('numero'));
            $endereco->setBairro($request->get('bairro'));
            $endereco->setCidade($request->get('cidade'));
            $endereco->setUf($request->get('uf'));
            $endereco->setComplemento($request->get('complemento'));
            $em->flush();

            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $id)));
        }

        return $this->render('AutenticacaoBundle:Usuario:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AutenticacaoBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('logout'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuarios_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Creates a form to edit a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Usuario $entity) {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Recuperar Senha
     *
     */
    public function recuperarsenhaAction() {
        return $this->render('AutenticacaoBundle:Usuario:recuperarSenha.html.twig', array(
                    'error' => '',
        ));
    }

    /**
     * Recuperar Senha
     * 
     * @param Request $request
     *
     */
    public function recuperarandosenhaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AutenticacaoBundle:Usuario')->findOneBy(array('username' => $request->get('_username')));
        if ($entity) {
//            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
//            $encodedPass = $encoder->encodePassword($entity->getTelefone(), $entity->getSalt());
//            $entity->setPassword($encodedPass);
            $novaSenha = base64_encode(rand(0, 1000));
            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $encodedPass = $encoder->encodePassword($novaSenha, $entity->getSalt());
            $entity->setPassword($encodedPass);
            $em->flush();
            $messageCliente = \Swift_Message::newInstance()
                    ->setSubject('Recuperar Senha - LQNL')
                    ->setFrom('testeletiva@gmail.com', 'LQNL - Recuperar Senha')
                    ->setTo($request->get('_username'))
                    ->setBody($this->renderView('::emailTemplate.html.twig', array(
                        'titulo' => 'Recuperar Senha',
                        'mensagem' => 'Nova senha: ' . $novaSenha,
                    )), 'text/html');
            $this->get('mailer')->send($messageCliente);

            return $this->redirect($this->generateUrl('mensagem', array('tipoMensagem' => 1)));
        }
        return $this->render('AutenticacaoBundle:Usuario:recuperarSenha.html.twig', array(
                    'error' => 'E-mail não cadastrado no sistema, tente novamente!'
        ));
    }

}
