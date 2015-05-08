<?php

namespace LQNL\AutenticacaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use LQNL\AutenticacaoBundle\Entity\Usuario;

class LoginController extends Controller {

    public function loginAction() {
        $user = $this->getUser();
        if ($user) {
            return $this->redirect($this->generateUrl('home'));
        }
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('AutenticacaoBundle:Login:login.html.twig', array(
                    'data' => new \DateTime,
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                        // ...
        ));
    }

    public function homeAction() {
        $user = $this->getUser();
        if (in_array("ROLE_USER", $user->getRoles())) {
            return $this->render('AutenticacaoBundle:Login:home.html.twig', array(
                        'usuario' => $user,
            ));
        }
        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            return $this->render('AutenticacaoBundle:Login:home.html.twig', array(
                        'usuario' => $user,
            ));
        }
    }
    
    public function testeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AutenticacaoBundle:Usuario')->findOneBy(array('username'=>$request->get('username')));
        
        $encoder = $this->get('security.encoder_factory')->getEncoder(new Usuario());
        $encodedPass = $encoder->encodePassword($request->get('_password'), null);
        
        echo 'Username:   ' . $request->get('_username');
        echo 'Password digitado:   ' . $encodedPass;
        echo '<br/> <br/> Password bd:   ' . $usuario->getPassword();
        
        exit(0);
    }

}
