<?php

namespace App\Controller;

use App\Entity\Meetings;
use App\Form\MeetingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/réunion')]
class MeetingsController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_meetings_edit', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meetings/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form,
        ]);
    }
}
