<?php

namespace App\Controller;

use App\Entity\TripPictures;
use App\Form\TripPicturesType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TripPicturesRepository;
use App\Repository\PreviousTripsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/photos-sorties')]
class TripPicturesController extends AbstractController
{
    #[Route('/', name: 'app_trip_pictures_index', methods: ['GET'])]
    public function index(TripPicturesRepository $tripPicturesRepository, PreviousTripsRepository $previousTripsRepository): Response
    {
        return $this->render('trip_pictures/index.html.twig', [
            'tripPictures' => $tripPicturesRepository->findAll(),
            'previous_trips' => $previousTripsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trip_pictures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $tripPicture = new TripPictures();
        $form = $this->createForm(TripPicturesType::class, $tripPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('tripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $tripPicture->setTripPicture($newFilename);
            }
            $entityManager->persist($tripPicture);
            $entityManager->flush();

            return $this->redirectToRoute('app_trip_pictures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip_pictures/new.html.twig', [
            'tripPicture' => $tripPicture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trip_pictures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TripPictures $tripPicture, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(TripPicturesType::class, $tripPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('tripPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $tripPicture->setTripPicture($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_trip_pictures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip_pictures/edit.html.twig', [
            'tripPicture' => $tripPicture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trip_pictures_delete', methods: ['POST'])]
    public function delete(Request $request, TripPictures $tripPicture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tripPicture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tripPicture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trip_pictures_index', [], Response::HTTP_SEE_OTHER);
    }
}
