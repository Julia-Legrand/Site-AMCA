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
    }

    public function testNewContactFormValid()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact/nouveau-message');

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['contacts[contactName]'] = 'John Doe';
        $form['contacts[contactMail]'] = 'john.doe@example.com';
        $form['contacts[contactMessage]'] = 'Ceci est un message de test.';
        $form['contacts[agreeTerms]'] = true;

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/')); // Assuming a successful redirect
    }

    public function testNewContactFormInvalid()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact/nouveau-message');

        $form = $crawler->selectButton('Enregistrer')->form();

        // Do not fill in required fields

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK); // Form submission should not redirect
    }
}
