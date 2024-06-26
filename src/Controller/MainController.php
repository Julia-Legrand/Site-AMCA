<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PostsRepository;
use App\Repository\ThemesRepository;
use App\Repository\GalleryRepository;
use App\Repository\CommentsRepository;
use App\Repository\MeetingsRepository;
use App\Repository\PurposesRepository;
use App\Repository\OtherClubRepository;
use App\Repository\MemoryDutyRepository;
use App\Repository\FutureTripsRepository;
use App\Repository\MembershipsRepository;
use App\Repository\PostPicturesRepository;
use App\Repository\PressReviewsRepository;
use App\Repository\TripPicturesRepository;
use App\Repository\PresentationsRepository;
use App\Repository\PreviousTripsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PresentationsRepository $presentationsRepository, PurposesRepository $purposesRepository, PreviousTripsRepository $previousTripsRepository, TripPicturesRepository $tripPicturesRepository, OtherClubRepository $otherClubRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
            'previous_trips' => $previousTripsRepository->findAll(),
            'trip_pictures' => $tripPicturesRepository->findAll(),
            'other_clubs' => $otherClubRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function admin(PresentationsRepository $presentationsRepository, MeetingsRepository $meetingsRepository, PurposesRepository $purposesRepository, MembershipsRepository $membershipsRepository, PreviousTripsRepository $previousTripsRepository, TripPicturesRepository $tripPicturesRepository, FutureTripsRepository $futureTripsRepository, UserRepository $userRepository, MemoryDutyRepository $memoryDutyRepository, GalleryRepository $galleryRepository, PressReviewsRepository $pressReviewsRepository, OtherClubRepository $otherClubRepository): Response
    {
        return $this->render('main/admin.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'meetings' => $meetingsRepository->findAll(),
            'purposes' => $purposesRepository->findAll(),
            'memberships' => $membershipsRepository->findAll(),
            'previous_trips' => $previousTripsRepository->findAll(),
            'trip_pictures' => $tripPicturesRepository->findAll(),
            'futureTrips' => $futureTripsRepository->findAll(),
            'users' => $userRepository->findAll(),
            'memory_duties' => $memoryDutyRepository->findAll(),
            'galleries' => $galleryRepository->findAll(),
            'press_reviews' => $pressReviewsRepository->findAll(),
            'other_clubs' => $otherClubRepository->findAll(),
        ]);
    }

    #[Route('/vie-association', name: 'asso')]
    public function asso(PresentationsRepository $presentationsRepository, MeetingsRepository $meetingsRepository, FutureTripsRepository $futureTripsRepository, MemoryDutyRepository $memoryDutyRepository, GalleryRepository $galleryRepository): Response
    {
        return $this->render('main/asso.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'meetings' => $meetingsRepository->findAll(),
            'futureTrips' => $futureTripsRepository->findAll(),
            'memory_duties' => $memoryDutyRepository->findAll(),
            'galleries' => $galleryRepository->findAll(),
        ]);
    }

    #[Route('/revue-de-presse', name: 'pressReview')]
    public function pressReview(PresentationsRepository $presentationsRepository, PressReviewsRepository $pressReviewsRepository): Response
    {
        $pressReviews = $pressReviewsRepository->findBy([], ['pressReviewDate' => 'DESC']);

        return $this->render('main/press.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'press_reviews' => $pressReviews,
        ]);
    }


    #[Route('/devenir-membre', name: 'membership')]
    public function membership(PresentationsRepository $presentationsRepository, MembershipsRepository $membershipsRepository): Response
    {
        return $this->render('main/membership.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
            'memberships' => $membershipsRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/forum', name: 'forum')]
    public function forum(PresentationsRepository $presentationsRepository, ThemesRepository $themesRepository, PostsRepository $postsRepository, PostPicturesRepository $postPicturesRepository, CommentsRepository $commentsRepository): Response
    {
        // Check if the user has the status set to true (validated)
        if ($this->getUser()->getStatus() === 'Validé') {
            return $this->render('main/forum.html.twig', [
                'presentations' => $presentationsRepository->findAll(),
                'themes' => $themesRepository->findAll(),
                'posts' => $postsRepository->findAll(),
                'post_pictures' => $postPicturesRepository->findAll(),
                'comments' => $commentsRepository->findAll(),
            ]);
        } else {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission d\'accéder au forum.');
        }
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
