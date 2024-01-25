<?php

namespace App\Controller;

use App\Entity\TripPictures;
use App\Entity\PreviousTrips;
use App\Form\PreviousTripsType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/précédente-sortie')]
class PreviousTripsController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/nouveau', name: 'app_previous_trips_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {
        $previousTrip = new PreviousTrips();
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $tripPictures = $form->get('pictures')->getData();

            foreach ($tripPictures as $tripPicture) {
                $newTripPicture = new TripPictures();
                $newTripPicture->setTripPicture($this->uploadPicture($tripPicture, $pictureService));
                $previousTrip->addTripPicture($newTripPicture);
            }

            $entityManager->persist($previousTrip);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_previous_trips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PreviousTrips $previousTrip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PreviousTripsType::class, $previousTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('previous_trips/edit.html.twig', [
            'previous_trip' => $previousTrip,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_previous_trips_delete', methods: ['POST'])]
    public function delete(Request $request, PreviousTrips $previousTrip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $previousTrip->getId(), $request->request->get('_token'))) {
            $entityManager->remove($previousTrip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
