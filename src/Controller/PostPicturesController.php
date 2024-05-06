<?php

namespace App\Controller;

use App\Entity\PostPictures;
use App\Form\PostPicturesType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostPicturesRepository;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/photo-post')]
class PostPicturesController extends AbstractController
{

    #[Route('/nouveau', name: 'app_post_pictures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $postPicture = new PostPictures();
        $form = $this->createForm(PostPicturesType::class, $postPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('postPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $postPicture->setPostPicture($newFilename);
            }
            $entityManager->persist($postPicture);
            $entityManager->flush();

            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_pictures/new.html.twig', [
            'post_picture' => $postPicture,
            'form' => $form,
        ]);
    }

    // Function to remove the old file
    private function removeOldFile(PostPictures $postPicture)
    {
        $oldFilePath = $this->getParameter('images_directory') . $postPicture->getPostPicture();

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
    }

    #[Route('/{id}/modifier', name: 'app_post_pictures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PresentationsRepository $presentationsRepository, PostPictures $postPicture, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PostPicturesType::class, $postPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('postPicture')->getData();
            if ($imageFile) {
                // Remove the old file
                $this->removeOldFile($postPicture);

                // Process the new file
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $postPicture->setPostPicture($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_pictures/edit.html.twig', [
            'post_picture' => $postPicture,
            'form' => $form,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_post_pictures_delete', methods: ['POST'])]
    public function delete(Request $request, PostPictures $postPicture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $postPicture->getId(), $request->request->get('_token'))) {
            // Remove the file before removing the entity
            $this->removeOldFile($postPicture);

            $entityManager->remove($postPicture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
    }
}
