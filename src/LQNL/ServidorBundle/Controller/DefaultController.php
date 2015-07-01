<?php

namespace LQNL\ServidorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homeAdminAction()
    {
        return $this->render('ServidorBundle:Default:homeAdmin.html.twig', array(
            'usuario' => $this->getUser()));
    }
}
