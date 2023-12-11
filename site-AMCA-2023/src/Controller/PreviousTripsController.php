<?php

namespace App\Controller;

use App\Service\PictureService;
use App\Entity\TripPictures;
use App\Entity\PreviousTrips;
use App\Form\PreviousTripsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PreviousTripsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/previous_trips')]
class PreviousTripsController extends AbstractController
{
    #[Route('/', name: 'app_previous_trips_index', methods: ['GET'])]
    public function index(PreviousTripsRepository $previousTripsRepository): Response
    {
        return $this->render('previous_trips/index.html.twig', [
            'previous_trips' => $previousTripsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_previous_trips_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {
        $previousTrip = new PreviousTrips();
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion des fichiers uploadés
            $tripPictures = $form->get('pictures')->getData();
            
            foreach ($tripPictures as $tripPicture) {
                $newTripPicture = new TripPictures();
                $newTripPicture->setPicture($this->uploadPicture($tripPicture, $pictureService));
                $previousTrip->addPicture($newTripPicture);
            }

            $entityManager->persist($previousTrip);
            $entityManager->flush();

            return $this->redirectToRoute('app_previous_trips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('previous_trips/new.html.twig', [
            'previous_trip' => $previousTrip,
            'form' => $form,
        ]);
    }

    private function uploadPicture(UploadedFile $file, PictureService $pictureService)
    {
        return $pictureService->add($file);
    }

    #[Route('/{id}/edit', name: 'app_previous_trips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PreviousTrips $previousTrip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_previous_trips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('previous_trips/edit.html.twig', [
            'previous_trip' => $previousTrip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_previous_trips_delete', methods: ['POST'])]
    public function delete(Request $request, PreviousTrips $previousTrip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$previousTrip->getId(), $request->request->get('_token'))) {
            $entityManager->remove($previousTrip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_previous_trips_index', [], Response::HTTP_SEE_OTHER);
    }
}
