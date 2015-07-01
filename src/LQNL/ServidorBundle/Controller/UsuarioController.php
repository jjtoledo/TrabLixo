<?php

namespace LQNL\ServidorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LQNL\AutenticacaoBundle\Entity\Usuario;
use LQNL\AutenticacaoBundle\Entity\Endereco;
use LQNL\AutenticacaoBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Usuario')->findBy(array('tipo'=>2));

        return $this->render('ServidorBundle:Usuario:index.html.twig', array(
            'usuario' => $this->getUser(),
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

        $entity->setTipo(2);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('login'));
        }

        return $this->redirect($this->generateUrl('administradores_new', array('id' => $entity->getId())));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('administradores_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServidorBundle:Usuario:new.html.twig', array(
            'usuario' => $this->getUser(),
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Usuario:show.html.twig', array(
            'usuario'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('administradores_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('administradores_edit', array('id' => $id)));
        }

        return $this->render('ServidorBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServidorBundle:Usuario')->find($id);

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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administradores_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
