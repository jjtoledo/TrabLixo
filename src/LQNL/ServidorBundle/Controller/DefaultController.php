<?php

namespace LQNL\ServidorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ServidorBundle:Default:index.html.twig', array('name' => $name));
    }
}
