<?php

namespace App\Controller;

use App\Entity\PreviousTrips;
use App\Form\PreviousTripsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PreviousTripsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/previous/trips')]
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
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $previousTrip = new PreviousTrips();
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('previousTripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $previousTrip->setPreviousTripPicture($newFilename);
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

    #[Route('/{id}/edit', name: 'app_previous_trips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PreviousTrips $previousTrip, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('previousTripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $previousTrip->setPreviousTripPicture($newFilename);
            }

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
