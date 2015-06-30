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
        $disponibilidades = $this->validaDisponibilidade($user, $request);
        if ($disponibilidades) {
            $i = 0;
            $user = $em->getRepository('ClienteBundle:Usuario')->find($this->getUser()->getId());
            foreach ($disponibilidades as $disponibilidade) {
                $em->persist($disponibilidade);
                $em->flush();
                $i++;
            }

            $disp = $entity = $em->getRepository('ClienteBundle:Disponibilidade')->findBy(array('responsavel' => $user->getId()), array('id' => 'DESC'));

            $entity = new Solicitacao();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            $entity->setUsuario($user);
            $entity->setStatus($status);
            $entity->setData($dataabertura);

            if ($i > 2) {
                $entity->setDisponibilidade3($disp[0]);
                $entity->setDisponibilidade2($disp[1]);
                $entity->setDisponibilidade1($disp[2]);
            } elseif ($i > 1) {
                $entity->setDisponibilidade2($disp[0]);
                $entity->setDisponibilidade1($disp[1]);
            } elseif ($i == 1) {
                $entity->setDisponibilidade1($disp[0]);
            }

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
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClienteBundle:Solicitacao:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'usuario' => $this->getUser()
        ));
    }

    /**
     * Displays a form to edit an existing Solicitacao entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);
        //$disponibilidade3 = $em->getRepository('ClienteBundle:Disponibilidade')->find($entity->getDisponibilidade3()->getId());
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClienteBundle:Solicitacao:edit.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
//                    'disponibilidade1' => $disponibilidade1,
//                    'disponibilidade2' => $disponibilidade2,
                        //        'disponibilidade3' => $disponibilidade3,
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
        $user = $em->getRepository('ClienteBundle:Usuario')->find($this->getUser()->getId());
        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }
        $disponibilidades = $this->validaDisponibilidade($user, $request);
        if ($disponibilidades) {
            $i = 0;
            foreach ($disponibilidades as $disponibilidade) {
                switch ($i) {
                    case 0:
                        $dispAux1 = $em->getRepository('ClienteBundle:Disponibilidade')->find($entity->getDisponibilidade1()->getId());
                        $dispAux1->setDia($disponibilidade->getDia());
                        $dispAux1->setTurno($disponibilidade->getTurno());
                        break;
                    case 1:
                        $dispAux2 = $em->getRepository('ClienteBundle:Disponibilidade')->find($entity->getDisponibilidade2()->getId());
                        $dispAux2->setDia($disponibilidade->getDia());
                        $dispAux2->setTurno($disponibilidade->getTurno());
                        break;
                    case 2:
                        $dispAux3 = $em->getRepository('ClienteBundle:Disponibilidade')->find($entity->getDisponibilidade3()->getId());
                        $dispAux3->setDia($disponibilidade->getDia());
                        $dispAux3->setTurno($disponibilidade->getTurno());
                        break;
                }
                $i++;
            }
            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('solicitacao_show', array('id' => $id)));
            }

            return $this->render('ClienteBundle:Solicitacao:edit.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
            ));
        }
    }

    /**
     * Cancelar a Solicitacao entity.
     *
     */
    public function cancelarAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ClienteBundle:Solicitacao')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        $entity->setStatus("Cancelada");
        $em->flush();

        return $this->redirect($this->generateUrl('solicitacao'));
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

//
//    public function showAction($id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $solicitacao = $em->getRepository('ClienteBundle:Solicitacao')->find($id);
//
//        if (!$solicitacao) {
//            return null;
//        }
//
//        return $solicitacao;
//    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {

        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function validaDisponibilidade($user, $request) {
        $disp1 = $request->get('disp1');
        $disp2 = $request->get('disp2');
        $disp3 = $request->get('disp3');
        $disponibilidade1 = new Disponibilidade ();
        $disponibilidade2 = new Disponibilidade();
        $disponibilidade3 = new Disponibilidade();
        if ($this->validateDate($disp1, "d/m/Y")) {
            if ($this->validateDate($disp2, "d/m/Y")) {
                if ($this->validateDate($disp3, "d/m/Y")) {
                    $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                    $data2 = \DateTime::createFromFormat("d/m/Y", $disp2);
                    $data3 = \DateTime::createFromFormat("d/m/Y", $disp3);
                    $disponibilidade1->setDia($data1);
                    $disponibilidade1->setTurno($request->get('turno1'));
                    $disponibilidade1->setResponsavel($user);
                    $disponibilidade2->setDia($data2);
                    $disponibilidade2->setTurno($request->get('turno2'));
                    $disponibilidade2->setResponsavel($user);
                    $disponibilidade3->setDia($data3);
                    $disponibilidade3->setTurno($request->get('turno3'));
                    $disponibilidade3->setResponsavel($user);
                    return array($disponibilidade1, $disponibilidade2, $disponibilidade3);
                } else {
                    $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                    $data2 = \DateTime::createFromFormat("d/m/Y", $disp2);
                    $disponibilidade1->setDia($data1);
                    $disponibilidade1->setTurno($request->get('turno1'));
                    $disponibilidade1->setResponsavel($user);
                    $disponibilidade2->setDia($data2);
                    $disponibilidade2->setTurno($request->get('turno2'));
                    $disponibilidade2->setResponsavel($user);
                    return array($disponibilidade1, $disponibilidade2);
                }
            } elseif ($this->validateDate($disp3, "d/m/Y")) {
                $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
                $data3 = \DateTime::createFromFormat("d/m/Y", $disp3);
                $disponibilidade1->setDia($data1);
                $disponibilidade1->setTurno($request->get('turno1'));
                $disponibilidade1->setResponsavel($user);
                $disponibilidade3->setDia($data3);
                $disponibilidade3->setTurno($request->get('turno3'));
                $disponibilidade3->setResponsavel($user);

                return array($disponibilidade1, $disponibilidade3);
            }
            $data1 = \DateTime::createFromFormat("d/m/Y", $disp1);
            $disponibilidade1->setDia($data1);
            $disponibilidade1->setTurno($request->get('turno1'));
            $disponibilidade1->setResponsavel($user);
            return array($disponibilidade1);
        }
        return false;
    }

}
