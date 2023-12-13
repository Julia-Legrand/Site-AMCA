<?php

namespace App\Controller;

use App\Entity\Meetings;
use App\Form\MeetingsType;
use App\Repository\MeetingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/réunions')]
class MeetingsController extends AbstractController
{
    #[Route('/', name: 'app_meetings_index', methods: ['GET'])]
    public function index(MeetingsRepository $meetingsRepository): Response
    {
        return $this->render('meetings/index.html.twig', [
            'meetings' => $meetingsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_meetings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $meeting = new Meetings();
        $form = $this->createForm(MeetingsType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $meeting->setMeetingLon($form->get('meetingLon')->getData());
            $meeting->setMeetingLat($form->get('meetingLat')->getData());

            // Handling files uploading
            $imageFile = $form->get('meetingPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $meeting->setMeetingPicture($newFilename);
            }

            $entityManager->persist($meeting);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_meetings_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('meetings/new.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meetings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meetings $meeting, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MeetingsType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling latitude and longitude values
            $meeting->setMeetingLon($form->get('meetingLon')->getData());
            $meeting->setMeetingLat($form->get('meetingLat')->getData());

            // Handling files uploading
            $imageFile = $form->get('meetingPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $meeting->setMeetingPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_meetings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meetings/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meetings_delete', methods: ['POST'])]
    public function delete(Request $request, Meetings $meeting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meeting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($meeting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meetings_index', [], Response::HTTP_SEE_OTHER);
    }
}
