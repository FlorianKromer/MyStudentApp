<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthentificationTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
        $this->client->followRedirects()
        ;
    }

    public function testAdminDashboard()
    {
        // $this->logIn();
        $crawler = $this->client->request('GET', '/admin');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('EasyAdmin', $crawler->filter('a.logo')->first()->text());
    }
}
