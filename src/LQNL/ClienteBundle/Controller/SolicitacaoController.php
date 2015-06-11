<?php

namespace LQNL\ClienteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LQNL\ClienteBundle\Entity\Solicitacao;
use LQNL\ClienteBundle\Entity\Disponibilidade;
use LQNL\ClienteBundle\Form\SolicitacaoType;

/**
 * Solicitacao controller.
 *
 */
class SolicitacaoController extends Controller {

    /**
     * Lists all Solicitacao entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $entities = $em->getRepository('ClienteBundle:Solicitacao')->findBy(array('usuario' => $user));

        return $this->render('ClienteBundle:Solicitacao:index.html.twig', array(
                    'usuario' => $user,
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Solicitacao entity.
     *
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ClienteBundle:Usuario')->find($this->getUser()->getId());
        $status = "Em Aberto";
        $dataabertura = new \DateTime;
        $disponibilidades = $this->validaDisponibilidade($request->get('disp1'), $request->get('disp2'), $request->get('disp3'), $request);
        if ($disponibilidades) {
            $i = 0;
            foreach ($disponibilidades as $disponibilidade) {
                $em->persist($disponibilidade);
                $em->flush();
                $i++;
            }

            $disp = $entity = $em->getRepository('ClienteBundle:Disponibilidade')->findBy(array(), array('id' => 'DESC'));

            $entity = new Solicitacao();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            $entity->setUsuario($user);
            $entity->setStatus($status);
            $entity->setData($dataabertura);

            if ($i > 2) {
                $entity->setDisponibilidade3($disp[2]);
                $entity->setDisponibilidade2($disp[1]);
            } elseif ($i > 1) {
                $entity->setDisponibilidade2($disp[1]);
            }
            $entity->setDisponibilidade1($disp[0]);

            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('solicitacao'));
            }
        }
        $entity = new Solicitacao();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        return $this->render('ClienteBundle:Solicitacao:new.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'erroDisp' => 'A data da disponibilidade deve ser a partir do próximo dia útil.'
        ));
    }

    /**
     * Creates a form to create a Solicitacao entity.
     *
     * @param Solicitacao $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Solicitacao $entity) {
        $form = $this->createForm(new SolicitacaoType(), $entity, array(
            'action' => $this->generateUrl('solicitacao_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Solicitacao entity.
     *
     */
    public function newAction() {
        $entity = new Solicitacao();
        $form = $this->createCreateForm($entity);
        $usuario = $this->getUser();
        return $this->render('ClienteBundle:Solicitacao:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'usuario' => $usuario,
        ));
    }

    /**
     * Finds and displays a Solicitacao entity.
     *
     */
//    public function showAction($id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//
//        return $this->render('ClienteBundle:Solicitacao:show.html.twig', array(
//                    'entity' => $entity,
//                    'delete_form' => $deleteForm->
//                            createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing Solicitacao entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClienteBundle:Solicitacao:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Solicitacao entity.
     *
     * @param Solicitacao $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Solicitacao $entity) {
        $form = $this->createForm(new SolicitacaoType(), $entity, array(
            'action' => $this->generateUrl('solicitacao_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label'
            => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Solicitacao entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('solicitacao_edit', array('id' => $id)));
        }

        return $this->render('ClienteBundle:Solicitacao:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Solicitacao entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitacao entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('solicitacao'));
    }

    /**
     * Creates a form to delete a Solicitacao entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('solicitacao_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }


    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $solicitacao = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

        if (!$solicitacao) {
            return null;
        }

        return $solicitacao;
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function validaDisponibilidade($disp1, $disp2 = null, $disp3 = null, $request) {
        $disponibilidade1 = new Disponibilidade ();
        $disponibilidade2 = new Disponibilidade();
        $disponibilidade3 = new Disponibilidade();
        if ($this->validateDate($disp1, "d/m/Y")) {
            if ($this->validateDate($disp2, "d/m/Y")) {
                if ($this->validateDate($disp3, "d/m/Y")) {
                    $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                    $data2 = \DateTime::createFromFormat("d/m/Y", $disp2);
                    $data3 = \DateTime::createFromFormat("d/m/Y", $disp3);
                    $dataAtual = new \DateTime;
                    if ($data1 > $dataAtual and $data2 > $dataAtual and $data3 > $dataAtual) {
                        $disponibilidade1->setDia($data1);
                        $disponibilidade1->setTurno($request->get('turno1'));
                        $disponibilidade2->setDia($data2);
                        $disponibilidade2->setTurno($request->get('turno2'));
                        $disponibilidade3->setDia($data3);
                        $disponibilidade3->setTurno($request->get('turno3'));
                        return array($disponibilidade1, $disponibilidade2, $disponibilidade3);
                    } else {
                        return false;
                    }
                } else {
                    $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                    $data2 = \DateTime::createFromFormat("d/m/Y", $disp2);
                    $dataAtual = new \DateTime;
                    if ($data1 > $dataAtual and $data2 > $dataAtual) {
                        $disponibilidade1->setDia($data1);
                        $disponibilidade1->setTurno($request->get('turno1'));
                        $disponibilidade2->setDia($data2);
                        $disponibilidade2->setTurno($request->get('turno2'));
                        return array($disponibilidade1, $disponibilidade2);
                    } else {
                        return false;
                    }
                }
            } elseif ($this->validateDate($disp3, "d/m/Y")) {
                $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                $data3 = \DateTime::createFromFormat("d/m/Y", $disp3);
                $dataAtual = new \DateTime;
                if ($data1 > $dataAtual and $data3 > $dataAtual) {
                    $disponibilidade1->setDia($data1);
                    $disponibilidade1->setTurno($request->get('turno1'));
                    $disponibilidade3->setDia($data3);
                    $disponibilidade3->setTurno($request->get('turno3'));

                    return array($disponibilidade1, $disponibilidade3);
                } else {
                    return false;
                }
            }
            $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
            $dataAtual = \DateTime::createFromFormat("d/m/Y", $disp1);
            if ($data1 > $dataAtual) {
                $disponibilidade1->setDia($data1);

                $disponibilidade1->setTurno($request->get('turno1'));
                return array($disponibilidade1);
            } else {
                return false;
            }
        }
    }

}
