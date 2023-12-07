<?php

namespace App\Controller;

use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PresentationsRepository $presentationsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'admin')]
    public function admin(PresentationsRepository $presentationsRepository): Response
    {
        return $this->render('main/admin.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/vie-association', name: 'asso')]
    public function asso(): Response
    {
        return $this->render('main/asso.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/devenir-membre', name: 'membership')]
    public function membership(): Response
    {
        return $this->render('main/membership.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/forum', name: 'forum')]
    public function forum(): Response
    {
        return $this->render('main/forum.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'confid')]
    public function confid(): Response
    {
        return $this->render('main/confid.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/mentions-legales', name: 'legals')]
    public function legals(): Response
    {
        return $this->render('main/legals.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
