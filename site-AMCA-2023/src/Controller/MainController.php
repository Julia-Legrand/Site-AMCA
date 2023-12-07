<?php

namespace App\Controller;

use App\Repository\MeetingsRepository;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PresentationsRepository $presentationsRepository, MeetingsRepository $meetingsRepository,PurposesRepository $purposesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'meetings' => $meetingsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function admin(PresentationsRepository $presentationsRepository, MeetingsRepository $meetingsRepository, PurposesRepository $purposesRepository, MembershipsRepository $membershipsRepository): Response
    {
        return $this->render('main/admin.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'meetings' => $meetingsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
            'memberships' => $membershipsRepository->findAll(),
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
    public function membership(MembershipsRepository $membershipsRepository): Response
    {
        return $this->render('main/membership.html.twig', [
            'memberships' => $membershipsRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/forum', name: 'forum')]
    public function forum(): Response
    {
        return $this->render('main/forum.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EntityManagerInterface $entityManager,): Response
    {
        $contacts = new Contacts();
        $form = $this->createForm(ContactsType::class, $contacts);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contacts);
            $entityManager->flush();

            return $this->redirectToRoute('contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('main/contact.html.twig', [
            'contacts' => $contacts,
            'form' => $form,
        ]);
    }

    #[Route('/politique-de-confidentialite', name: 'confid')]
    public function confid(): Response
    {
        return $this->render('main/confid.html.twig');
    }

    #[Route('/mentions-legales', name: 'legals')]
    public function legals(): Response
    {
        return $this->render('main/legals.html.twig');
    }
}
