<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginPageLoads()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }

    public function testLogoutPageLoads()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Connexion');
    }
}