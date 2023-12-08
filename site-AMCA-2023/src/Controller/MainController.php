<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\UserRepository;
use App\Repository\PostsRepository;
use App\Repository\ImagesRepository;
use App\Repository\ThemesRepository;
use App\Repository\CommentsRepository;
use App\Repository\ContactsRepository;
use App\Repository\MeetingsRepository;
use App\Repository\PurposesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FutureTripsRepository;
use App\Repository\MembershipsRepository;
use App\Repository\PresentationsRepository;
use App\Repository\PreviousTripsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PresentationsRepository $presentationsRepository, PurposesRepository $purposesRepository, PreviousTripsRepository $previousTripsRepository, ImagesRepository $imagesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
            'previous_trips' => $previousTripsRepository->findAll(),
            'images' => $imagesRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function admin(PresentationsRepository $presentationsRepository, MeetingsRepository $meetingsRepository, PurposesRepository $purposesRepository, MembershipsRepository $membershipsRepository, ContactsRepository $contactsRepository, PreviousTripsRepository $previousTripsRepository, ImagesRepository $imagesRepository, FutureTripsRepository $futureTripsRepository, UserRepository $userRepository, ThemesRepository $themesRepository, PostsRepository $postsRepository, CommentsRepository $commentsRepository): Response
    {
        return $this->render('main/admin.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'meetings' => $meetingsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
            'memberships' => $membershipsRepository->findAll(),
            'contacts' => $contactsRepository->findAll(),
            'previous_trips' => $previousTripsRepository->findAll(),
            'images' => $imagesRepository->findAll(),
            'future_trips' => $futureTripsRepository->findAll(),
            'users' => $userRepository->findAll(),
            'themes' => $themesRepository->findAll(),
            'posts' => $postsRepository->findAll(),
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    #[Route('/vie-association', name: 'asso')]
    public function asso(MeetingsRepository $meetingsRepository, FutureTripsRepository $futureTripsRepository): Response
    {
        return $this->render('main/asso.html.twig', [
            'meetings' => $meetingsRepository->findAll(),
            'future_trips' => $futureTripsRepository->findAll(),
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
    public function forum(ThemesRepository $themesRepository, PostsRepository $postsRepository, CommentsRepository $commentsRepository): Response
    {
        return $this->render('main/forum.html.twig', [
            'themes' => $themesRepository->findAll(),
            'posts' => $postsRepository->findAll(),
            'comments' => $commentsRepository->findAll(),
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
