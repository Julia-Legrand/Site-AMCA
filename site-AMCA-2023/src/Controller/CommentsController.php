<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\PostsRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commentaires')]
class CommentsController extends AbstractController
{
    #[Route('/', name: 'app_comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository, PostsRepository $postsRepository, PresentationsRepository $presentationsRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
            'posts' => $postsRepository->findAll(),
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/nouveau/{postId}', name: 'app_comments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PostsRepository $postsRepository, $postId, PresentationsRepository $presentationsRepository): Response
    {
        $post = $postsRepository->find($postId);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $comment = new Comments();
        $comment->setPost($post);

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'post' => $post,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }


    #[Route('/{id}/modifier/{postId}', name: 'app_comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment, EntityManagerInterface $entityManager, PostsRepository $postsRepository, $postId, PresentationsRepository $presentationsRepository): Response
    {
        $user = $this->getUser();

        // Check if the user is the administrator or the author of the comment
        if (!$this->isGranted('ROLE_ADMIN') && $comment->getUser() !== $user) {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission de modifier ce commentaire.');
        }

        $post = $postsRepository->find($postId);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('forum', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'post' => $post,
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        // Check if the user is the administrator or the author of the comment
        if (!$this->isGranted('ROLE_ADMIN') && $comment->getUser() !== $user) {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission de supprimer ce commentaire.');
        }

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
