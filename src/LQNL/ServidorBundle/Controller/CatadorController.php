<?php

namespace LQNL\ServidorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use LQNL\ServidorBundle\Entity\Catador;
use LQNL\ServidorBundle\Form\CatadorType;

/**
 * Catador controller.
 *
 */
class CatadorController extends Controller {

    /**
     * Lists all Catador entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Catador')->findAll();

        return $this->render('ServidorBundle:Catador:index.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Catador entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Catador();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('catadores_show', array('id' => $entity->getId())));
        }

        return $this->render('ServidorBundle:Catador:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Catador entity.
     *
     * @param Catador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Catador $entity) {
        setlocale(LC_TIME, "pt_BR");
        $form = $this->createForm(new CatadorType(), $entity, array(
            'action' => $this->generateUrl('catadores_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Catador entity.
     *
     */
    public function newAction() {
        $entity = new Catador();
        $form = $this->createCreateForm($entity);
        return $this->render('ServidorBundle:Catador:new.html.twig', array(
                    'usuario' => $this->getUser(),
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Catador entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Catador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Catador:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Catador entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Catador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catador entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServidorBundle:Catador:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Catador entity.
     *
     * @param Catador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Catador $entity) {
        $form = $this->createForm(new CatadorType(), $entity, array(
            'action' => $this->generateUrl('catadores_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Catador entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Catador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Catador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('catadores_edit', array('id' => $id)));
        }

        return $this->render('ServidorBundle:Catador:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Catador entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServidorBundle:Catador')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Catador entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('catadores'));
    }

    /**
     * Creates a form to delete a Catador entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('catadores_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
