<?php

namespace App\Controller;

use App\Entity\FutureTrips;
use App\Form\FutureTripsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FutureTripsRepository;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/futures-sorties')]
class FutureTripsController extends AbstractController
{
    #[Route('/', name: 'app_future_trips_index', methods: ['GET'])]
    public function index(FutureTripsRepository $futureTripsRepository): Response
    {
        return $this->render('future_trips/index.html.twig', [
            'futureTrips' => $futureTripsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_future_trips_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $futureTrip = new FutureTrips();
        $form = $this->createForm(FutureTripsType::class, $futureTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $futureTrip->setFutureTripLon($form->get('futureTripLon')->getData());
            $futureTrip->setFutureTripLat($form->get('futureTripLat')->getData());

            // Handling files uploading
            $imageFile = $form->get('futureTripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $futureTrip->setFutureTripPicture($newFilename);
            }
            $entityManager->persist($futureTrip);
            $entityManager->flush();

            return $this->redirectToRoute('app_future_trips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('future_trips/new.html.twig', [
            'futureTrip' => $futureTrip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_future_trips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FutureTrips $futureTrip, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FutureTripsType::class, $futureTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $futureTrip->setFutureTripLon($form->get('futureTripLon')->getData());
            $futureTrip->setFutureTripLat($form->get('futureTripLat')->getData());

            // Handling files uploading
            $imageFile = $form->get('futureTripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $futureTrip->setFutureTripPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_future_trips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('future_trips/edit.html.twig', [
            'futureTrip' => $futureTrip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_future_trips_show', methods: ['GET'])]
    public function show(FutureTrips $futureTrip, PresentationsRepository $presentationsRepository): Response
    {
        return $this->render('future_trips/show.html.twig', [
            'futureTrip' => $futureTrip,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_future_trips_delete', methods: ['POST'])]
    public function delete(Request $request, FutureTrips $futureTrip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$futureTrip->getId(), $request->request->get('_token'))) {
            $entityManager->remove($futureTrip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_future_trips_index', [], Response::HTTP_SEE_OTHER);
    }
}
