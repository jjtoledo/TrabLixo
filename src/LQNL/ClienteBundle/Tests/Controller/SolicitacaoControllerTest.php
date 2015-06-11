<?php

namespace LQNL\ClienteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \LQNL\ClienteBundle\Controller\SolicitacaoController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SolicitacaoControllerTest extends WebTestCase {

    /**
     * @var SolicitacaoController
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = static::createClient();
//        $this->object = new SolicitacaoController;
    }

    /*
      public function testCompleteScenario() {
      // Create a new client to browse the application
      $client = static::createClient();

      // Create a new entry in the database
      $crawler = $client->request('GET', '/solicitacao/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /solicitacao/");
      $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

      // Fill in the form and submit it
      $form = $crawler->selectButton('Create')->form(array(
      'lqnl_clientebundle_solicitacao[field_name]'  => 'Test',
      // ... other fields to fill
      ));

      $client->submit($form);
      $crawler = $client->followRedirect();

      // Check data in the show view
      $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

      // Edit the entity
      $crawler = $client->click($crawler->selectLink('Edit')->link());

      $form = $crawler->selectButton('Update')->form(array(
      'lqnl_clientebundle_solicitacao[field_name]'  => 'Foo',
      // ... other fields to fill
      ));

      $client->submit($form);
      $crawler = $client->followRedirect();

      // Check the element contains an attribute with value equals "Foo"
      $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

      // Delete the entity
      $client->submit($crawler->selectButton('Delete')->form());
      $crawler = $client->followRedirect();

      // Check the entity has been delete on the list
      $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
     * 
     * 
      }
     */

    public function testShowAction() {
        $controller = new Controller;
        $controller->setContainer($this->object->getContainer());
        
        $solicitacaoController = new SolicitacaoController;
        $solicitacaoController->setContainer($this->object->getContainer());
        
        $em = $controller->getDoctrine()->getManager();
        $solicitacao = $em->getRepository('ClienteBundle:Solicitacao')->find(1);
        $this->assertEquals(
                $solicitacao
                , $solicitacaoController->showAction(1)
        );
    }

    public function testShowAction2() {
        $solicitacaoController = new SolicitacaoController;
        $solicitacaoController->setContainer($this->object->getContainer());
        $this->assertEquals(
                null
                , $solicitacaoController->showAction(2)
        );
    }
    
    public function testShowAction3() {
        $controller = new Controller;
        $controller->setContainer($this->object->getContainer());
        
        $solicitacaoController = new SolicitacaoController;
        $solicitacaoController->setContainer($this->object->getContainer());
        
        $em = $controller->getDoctrine()->getManager();
        $solicitacao = $em->getRepository('ClienteBundle:Solicitacao')->find(1);
        $this->assertEquals(
                $solicitacao
                , $solicitacaoController->showAction(2)
        );
    }

}
