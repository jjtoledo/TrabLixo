<?php

namespace LQNL\AutenticacaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller {

    public function faleconoscoAction() {
        return $this->render('AutenticacaoBundle:Publico:contato.html.twig', array(
                    'data' => new \DateTime,
                        // ...
        ));
    }

    public function mensagemAction($tipoMensagem) {
        switch ($tipoMensagem) {
            case 1:
                $mensagem[] = "Sua Senha foi alterada com sucesso!";
                $mensagem[] = "Dentro de alguns minutos você receberá um e-mail com uma nova senha.";
                break;
            case 2:
                $mensagem[] = "Sua mensagem foi enviada com sucesso!";
                $mensagem[] = "Dentro de alguns minutos você receberá um e-mail confirmando o recebimento da mensagem pelos administradores.";
                $mensagem[] = "Aguarde a resposta do seu contato através do e-mail informado.";
                break;
        }
        return $this->render('AutenticacaoBundle:Publico:mensagem.html.twig', array(
                    'mensagem' => $mensagem,
                    'data' => new \DateTime,
                        // ...
        ));
    }

    public function faleconoscoRequisicaoAction(Request $request) {
        $nome = $request->get('nome');
        $email = $request->get('email');
        $assunto = $request->get('assunto');
        $mensagem = $request->get('mensagem');

        $messageCliente = \Swift_Message::newInstance()
                ->setSubject('Lixo Que Não é Lixo')
                ->setFrom('testeletiva@gmail.com', 'LQNL - Fale Conosco')
                ->setTo($email)
                ->setBody($this->renderView('::emailTemplate.html.twig', array(
                    'titulo' => 'Fale Conosco',
                    'mensagem' => 'Sua mensagem foi enviada com sucesso! Os administradores irão receber e responder através do e-mail informado.',
                )), 'text/html');
        $this->get('mailer')->send($messageCliente);

        $messageSuporte = \Swift_Message::newInstance()
                ->setSubject('Fale Conosco LQNL - ' . $assunto)
                ->setFrom($email, $nome)
                ->setTo('testeletiva@gmail.com')
                ->setBody($this->renderView('::emailTemplate.html.twig', array(
                    'titulo' => 'Fale Conosco',
                    'mensagem' => $mensagem,
                )), 'text/html');
        $this->get('mailer')->send($messageSuporte);

        return $this->redirect($this->generateUrl('mensagem', array('tipoMensagem' => 2)));
    }

}
