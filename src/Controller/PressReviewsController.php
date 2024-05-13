<?php

namespace App\Controller;

use App\Entity\PressReviews;
use App\Form\PressReviewsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PressReviewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
#[Route('/presse')]
class PressReviewsController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_press_reviews_index', methods: ['GET'])]
    public function index(PressReviewsRepository $pressReviewsRepository): Response
    {
        $pressReviews = $pressReviewsRepository->findBy([], ['pressReviewDate' => 'DESC']);

        return $this->render('press_reviews/index.html.twig', [
            'press_reviews' => $pressReviews,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_press_reviews_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $pressReview = new PressReviews();
        $form = $this->createForm(PressReviewsType::class, $pressReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('pressReviewPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $pressReview->setPressReviewPicture($newFilename);
            }
            $entityManager->persist($pressReview);
            $entityManager->flush();

            return $this->redirectToRoute('app_press_reviews_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('press_reviews/new.html.twig', [
            'press_review' => $pressReview,
            'form' => $form,
        ]);
    }

    // Function to remove the old file
    private function removeOldFile(PressReviews $pressReview)
    {
        $oldFilePath = $this->getParameter('images_directory') . '/' . $pressReview->getPressReviewPicture();

        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_press_reviews_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PressReviews $pressReview, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PressReviewsType::class, $pressReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('pressReviewPicture')->getData();
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

                $pressReview->setPressReviewPicture($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_press_reviews_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('press_reviews/edit.html.twig', [
            'press_review' => $pressReview,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_press_reviews_delete', methods: ['POST'])]
    public function delete(Request $request, PressReviews $pressReview, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pressReview->getId(), $request->request->get('_token'))) {
            // Remove the file before removing the entity
            $this->removeOldFile($pressReview);

            $entityManager->remove($pressReview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_press_reviews_index', [], Response::HTTP_SEE_OTHER);
    }
}
