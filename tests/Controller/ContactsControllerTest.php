<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactsControllerTest extends WebTestCase
{
    public function testNewContactPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact/nouveau-message');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorExists('form');
    }
}
