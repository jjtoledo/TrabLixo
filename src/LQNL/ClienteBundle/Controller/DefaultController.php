<?php

namespace LQNL\ClienteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ClienteBundle:Default:index.html.twig', array('name' => $name));
    }
}
