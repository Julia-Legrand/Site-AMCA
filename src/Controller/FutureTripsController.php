<?php

namespace App\Controller;

use App\Entity\FutureTrips;
use App\Form\FutureTripsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/future-sortie')]
class FutureTripsController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/nouveau', name: 'app_future_trips_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $futureTrip = new FutureTrips();
        $form = $this->createForm(FutureTripsType::class, $futureTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $futureTrip->setFutureTripLon($form->get('futureTripLon')->getData());
            $futureTrip->setFutureTripLat($form->get('futureTripLat')->getData());

            // Handling files uploading for picture
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

            // Handling file uploading for presentation sheet
            $presentationSheetFile = $form->get('presentationSheet')->getData();
            if ($presentationSheetFile) {
                $originalFilename = pathinfo($presentationSheetFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $presentationSheetFile->guessExtension();

                $presentationSheetFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $futureTrip->setPresentationSheet($newFilename);
            }

            $entityManager->persist($futureTrip);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('future_trips/new.html.twig', [
            'futureTrip' => $futureTrip,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_future_trips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FutureTrips $futureTrip, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(FutureTripsType::class, $futureTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $futureTrip->setFutureTripLon($form->get('futureTripLon')->getData());
            $futureTrip->setFutureTripLat($form->get('futureTripLat')->getData());

            // Handling files uploading for picture
            $imageFile = $form->get('futureTripPicture')->getData();
            if ($imageFile) {
                // Remove the old file
                $this->removeOldFile($futureTrip->getFutureTripPicture());

                // Process the new file
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $futureTrip->setFutureTripPicture($newFilename);
            }

            // Handling files uploading for presentation sheet
            $presentationSheetFile = $form->get('presentationSheet')->getData();
            if ($presentationSheetFile) {
                // Remove the old file
                $this->removeOldFile($futureTrip->getPresentationSheet());

                // Process the new file
                $originalFilename = pathinfo($presentationSheetFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $presentationSheetFile->guessExtension();

                $presentationSheetFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $futureTrip->setPresentationSheet($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_future_trips_delete', methods: ['POST'])]
    public function delete(Request $request, FutureTrips $futureTrip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $futureTrip->getId(), $request->request->get('_token'))) {
            // Remove the old files before removing the entity
            $this->removeOldFile($futureTrip->getFutureTripPicture());

            // Check if presentation sheet exists before trying to remove it
            $presentationSheet = $futureTrip->getPresentationSheet();
            if ($presentationSheet !== null) {
                $this->removeOldFile($presentationSheet);
            }

            $entityManager->remove($futureTrip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }

    // Function to remove the old file
    private function removeOldFile(?string $filename): void
    {
        if ($filename !== null) {
            $filePath = $this->getParameter('images_directory') . '/' . $filename;

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    // #[IsGranted('ROLE_USER')]
    // #[Route('/inscription/{id}', name: 'app_future_trips_subscribe', methods: ['POST'])]
    // public function subscribe(Request $request, FutureTrips $futureTrip, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('subscribe' . $futureTrip->getId(), $request->request->get('_token'))) {
    //         if (!$this->getUser()->isStatus()) {
    //             $this->addFlash('error', 'Votre compte n\'est pas encore actif, veuillez contacter l\'administrateur du site');
    //             return $this->redirectToRoute('app_future_trips_show', ['id' => $futureTrip->getId()], Response::HTTP_SEE_OTHER);
    //         }

    //         $numberOfPlaces = $futureTrip->getNumberOfPlaces();
    //         $countSubscribedUsers = count($futureTrip->getUsers());

    //         if ($countSubscribedUsers >= $numberOfPlaces) {
    //             $this->addFlash('error', 'Le nombre maximal d\'inscriptions a été atteint');
    //             return $this->redirectToRoute('app_future_trips_show', ['id' => $futureTrip->getId()], Response::HTTP_SEE_OTHER);
    //         }

    //         $user = $this->getUser();
    //         $subscribedUsers = $futureTrip->getUsers();

    //         if ($subscribedUsers->contains($user)) {
    //             $this->addFlash('info', 'Vous êtes déjà inscrit à cette sortie');
    //             return $this->redirectToRoute('app_future_trips_show', ['id' => $futureTrip->getId()], Response::HTTP_SEE_OTHER);
    //         }

    //         $futureTrip->addUser($user);

    //         $entityManager->flush();
    //         $this->addFlash('success', 'Inscription validée avec succès !');
    //         return $this->redirectToRoute('app_future_trips_show', ['id' => $futureTrip->getId()], Response::HTTP_SEE_OTHER);
    //     }
    // }
}
