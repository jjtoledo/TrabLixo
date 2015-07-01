<?php

namespace LQNL\ServidorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LQNL\ServidorBundle\Entity\Recolhimento;
use LQNL\ServidorBundle\Form\RecolhimentoType;

/**
 * Recolhimento controller.
 *
 */
class RecolhimentoController extends Controller {

    /**
     * Lists all Recolhimento entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Recolhimento')->findAll();

        return $this->render('ServidorBundle:Recolhimento:index.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entities' => $entities,
        ));
    }

    /**
     * Lists all Recolhimento entities.
     *
     */
    public function recolhidosHojeAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Recolhimento')->findAll();
        $recolhidosHoje = "";
        foreach ($entities as $recolhimento) {
            if ($recolhimento->getData()->format('d/m/Y') == (new \DateTime)->format('d/m/Y'))
                $recolhidosHoje[] = $recolhimento;
        }

        return $this->render('ServidorBundle:Recolhimento:hoje.html.twig', array(
                    'data' => new \DateTime,
                    'usuario' => $this->getUser(),
                    'entities' => $recolhidosHoje,
        ));
    }

    /**
     * Creates a new Recolhimento entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Recolhimento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($entity->getEletronico() == 0)
            $entity->setEletronico(0);
        if ($entity->getMetal() == 0)
            $entity->setMetal(0);
        if ($entity->getOutros() == 0)
            $entity->setOutros(0);
        if ($entity->getPapel() == 0)
            $entity->setPapel(0);
        if ($entity->getPlastico() == 0)
            $entity->setPlastico(0);
        if ($entity->getVidro() == 0)
            $entity->setVidro(0);
        $entity->setTotal($entity->getMetal() + $entity->getEletronico() + $entity->getOutros() + $entity->getPapel() + $entity->getPlastico() + $entity->getVidro());
        $entity->setData(new \DateTime);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('recolhimentos_show', array('id' => $entity->getId())));
        }

        return $this->render('ServidorBundle:Recolhimento:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Recolhimento entity.
     *
     * @param Recolhimento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Recolhimento $entity) {
        $form = $this->createForm(new RecolhimentoType(), $entity, array(
            'action' => $this->generateUrl('recolhimentos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Recolhimento entity.
     *
     */
    public function newAction() {
        $entity = new Recolhimento();
        $form = $this->createCreateForm($entity);

        return $this->render('ServidorBundle:Recolhimento:new.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Recolhimento entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Recolhimento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Recolhimento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Recolhimento:show.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Recolhimento entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Recolhimento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Recolhimento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Recolhimento:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Recolhimento entity.
     *
     * @param Recolhimento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Recolhimento $entity) {
        $form = $this->createForm(new RecolhimentoType(), $entity, array(
            'action' => $this->generateUrl('recolhimentos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Recolhimento entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Recolhimento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Recolhimento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('recolhimentos_edit', array('id' => $id)));
        }

        return $this->render('ServidorBundle:Recolhimento:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Recolhimento entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServidorBundle:Recolhimento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Recolhimento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('recolhimentos'));
    }

    /**
     * Creates a form to delete a Recolhimento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('recolhimentos_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
