<?php

namespace App\Controller;

use App\Entity\OtherClub;
use App\Form\OtherClubType;
use App\Repository\OtherClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
#[Route('/club-jumele')]
class OtherClubController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/nouveau', name: 'app_other_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $otherClub = new OtherClub();
        $form = $this->createForm(OtherClubType::class, $otherClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('otherClubPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $otherClub->setOtherClubPicture($newFilename);
            }
            $entityManager->persist($otherClub);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('other_club/new.html.twig', [
            'other_club' => $otherClub,
            'form' => $form,
        ]);
    }

    // Function to remove the old file
    private function removeOldFile(OtherClub $otherClub)
    {
        $oldFilePath = $this->getParameter('images_directory') . '/' . $otherClub->getOtherClubPicture();

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_other_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OtherClub $otherClub, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(OtherClubType::class, $otherClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('otherClubPicture')->getData();
            if ($imageFile) {
                // Remove the old file
                $this->removeOldFile($pressReview);

                // Process the new file
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $otherClub->setOtherClubPicture($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('other_club/edit.html.twig', [
            'other_club' => $otherClub,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_other_club_delete', methods: ['POST'])]
    public function delete(Request $request, OtherClub $otherClub, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $otherClub->getId(), $request->request->get('_token'))) {
            // Remove the file before removing the entity
            $this->removeOldFile($otherClub);

            $entityManager->remove($otherClub);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
