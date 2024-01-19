<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('hello@test.com')
            ->to('example@test.com')
            ->subject('heelo world')
            ->text('Sending email for testing')
            ->html('<h1> Le html fonctionne ? </h1>');

        // dd($mailer);

        dd($mailer->send($email));

        return $this->render('mail/index.html.twig', [
            'controller_name' => 'MailController',
        ]);
    }
}
