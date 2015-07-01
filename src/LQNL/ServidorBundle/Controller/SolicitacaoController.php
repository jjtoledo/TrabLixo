<?php

namespace LQNL\ServidorBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LQNL\ServidorBundle\Entity\Solicitacao;

/**
 * Solicitacao controller.
 *
 */
class SolicitacaoController extends Controller
{

    /**
     * Lists all Solicitacao entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Solicitacao')->findAll();

        return $this->render('ServidorBundle:Solicitacao:index.html.twig', array(
            'usuario' =>  $this->getUser(),
            'entities' => $entities,
        ));
    }
    /**
     * Lists all Solicitacao pendentes(status = em aberto) entities.
     *
     */
    public function pendentesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Solicitacao')->findBy(array('status'=>'Em Aberto'));

        return $this->render('ServidorBundle:Solicitacao:pendentes.html.twig', array(
            'usuario' =>  $this->getUser(),
            'entities' => $entities,
        ));
    }
    public function ematendimentoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Solicitacao')->findBy(array('status'=>'Em Atendimento'));

        return $this->render('ServidorBundle:Solicitacao:emAtendimento.html.twig', array(
            'usuario' =>  $this->getUser(),
            'entities' => $entities,
        ));
    }
    public function concluidasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Solicitacao')->findBy(array('status'=>'Concluída'));

        return $this->render('ServidorBundle:Solicitacao:concluidas.html.twig', array(
            'usuario' =>  $this->getUser(),
            'entities' => $entities,
        ));
    }
    public function canceladasAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServidorBundle:Solicitacao')->findBy(array('status'=>'Cancelada'));

        return $this->render('ServidorBundle:Solicitacao:canceladas.html.twig', array(
            'usuario' =>  $this->getUser(),
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Solicitacao entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServidorBundle:Solicitacao')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitacao entity.');
        }

        return $this->render('ServidorBundle:Solicitacao:show.html.twig', array(
            'usuario' => $this->getUser(),
            'entity'      => $entity,
        ));
    }
}
