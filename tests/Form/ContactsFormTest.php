<?php

namespace App\Tests\Form;

use App\Entity\Contacts;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactsFormTest extends KernelTestCase
{
    public function testContactForm()
    {
        $contact = (new Contacts)
            ->setContactName('John Doe')
            ->setContactMail('john.doe@example.com')
            ->setContactMessage('Test message')
            ->setCreatedAt(new \DateTimeImmutable());

        self::bootKernel();
        $container = static::getContainer();
        $validator = $container->get('validator');
        $errors = $validator->validate($contact);

        $this->assertCount(0, $errors);
    }

    public function testInvalidContactForm()
    {
        $contact = (new Contacts)
            ->setContactName('') // Empty name
            ->setContactMail('john.doe@example') // Invalid mail address
            ->setContactMessage('') // Empty message
            ->setCreatedAt(new \DateTimeImmutable());

        self::bootKernel();
        $container = static::getContainer();
        $validator = $container->get('validator');
        $errors = $validator->validate($contact);

        $this->assertGreaterThan(0, count($errors));
    }
}
