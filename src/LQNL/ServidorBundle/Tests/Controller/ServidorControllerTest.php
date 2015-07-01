<?php

namespace LQNL\ServidorBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServidorControllerTest extends WebTestCase
{
    public function testListaradmins()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adminitradores');
    }

    public function testNewadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administradores/novo');
    }

    public function testNewcatador()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/catadores/novo');
    }

    public function testListarcatadores()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/catadores');
    }

}
