<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Entity\PostPictures;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/discussion')]
class PostsController extends AbstractController
{

    #[Route('/nouveau', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PresentationsRepository $presentationsRepository, PictureService $pictureService): Response
    {
        $post = new Posts();

        // Set the connected user as the author of the post
        $user = $this->getUser();
        $post->setUser($user);

        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $postPictures = $form->get('postPicture')->getData();

            foreach ($postPictures as $postPicture) {
                $newPostPicture = new PostPictures();
                $newPostPicture->setPostPicture($this->uploadPostPicture($postPicture, $pictureService));
                $post->addPostPicture($newPostPicture);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    private function uploadPostPicture(UploadedFile $file, PictureService $pictureService)
    {
        return $pictureService->addPostPicture($file);
    }

    #[Route('/{id}/modifier', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager, PresentationsRepository $presentationsRepository, PictureService $pictureService): Response
    {
        // Get the connected user
        $user = $this->getUser();

        // Check if the user is the administrator or the author of the post
        if (!$this->isGranted('ROLE_ADMIN') && $post->getUser() !== $user) {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission de modifier ce post.');
        }

        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $postPictures = $form->get('postPicture')->getData();

            foreach ($postPictures as $postPicture) {
                $newPostPicture = new PostPictures();
                $newPostPicture->setPostPicture($this->uploadPostPicture($postPicture, $pictureService));
                $post->addPostPicture($newPostPicture);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        // Get the connected user
        $user = $this->getUser();

        // Check if the user is the administrator or the author of the post
        if (!$this->isGranted('ROLE_ADMIN') && $post->getUser() !== $user) {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission de supprimer ce post.');
        }

        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
    }
}
