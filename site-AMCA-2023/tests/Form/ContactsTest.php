<?php

namespace App\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactsTest extends WebTestCase
{
    public function testNewContactForm(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact/nouveau-message');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Contact');

        // Récupérer le formulaire
        $submitButton = $crawler->selectButton('Soumettre ma demande');
        $form = $submitButton->form();

        // Champs avec des données incorrectes
        $form['contacts[contactName]'] = 'John Doe';
        $form['contacts[contactMail]'] = 'john.doe@test.com';
        $form['contacts[contactMessage]'] = 'Test';
        $form['contacts[agreeTerms]'] = true;

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier le statut HTTP après la soumission du formulaire
        $this->assertResponseStatusCodeSame(200);

        $client->followRedirect();

        // Vérifier la présence du message de succès
        $this->assertSelectorTextContains(
            'div.alert.alert-success.mt-4',
            'Votre demande a été envoyée avec succès !'
        );
    }
}
