<?php

namespace App\Controller;

use App\Entity\Presentations;
use App\Form\PresentationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/presentations')]
class PresentationsController extends AbstractController
{
    #[Route('/', name: 'app_presentations_index', methods: ['GET'])]
    public function index(PresentationsRepository $presentationsRepository): Response
    {
        return $this->render('presentations/index.html.twig', [
            'presentations' => $presentationsRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: 'app_presentations_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    // {
    //     $presentation = new Presentations();
    //     $form = $this->createForm(PresentationsType::class, $presentation);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Handling files uploading
    //         $imageFile = $form->get('presentationPicture')->getData();
    //         if ($imageFile) {
    //             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

    //             $imageFile->move(
    //                 $this->getParameter('images_directory'),
    //                 $newFilename
    //             );

    //             $presentation->setPresentationPicture($newFilename);
    //         }
    //         $imageFile = $form->get('logo')->getData();
    //         if ($imageFile) {
    //             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

    //             $imageFile->move(
    //                 $this->getParameter('images_directory'),
    //                 $newFilename
    //             );

    //             $presentation->setLogo($newFilename);
    //         }
    //         $imageFile = $form->get('statutesDoc')->getData();
    //         if ($imageFile) {
    //             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

    //             $imageFile->move(
    //                 $this->getParameter('images_directory'),
    //                 $newFilename
    //             );

    //             $presentation->setStatutesDoc($newFilename);
    //         }
    //         $imageFile = $form->get('internalRulesDoc')->getData();
    //         if ($imageFile) {
    //             $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
    //             $safeFilename = $slugger->slug($originalFilename);
    //             $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

    //             $imageFile->move(
    //                 $this->getParameter('images_directory'),
    //                 $newFilename
    //             );

    //             $presentation->setInternalRulesDoc($newFilename);
    //         }

    //         $entityManager->persist($presentation);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_presentations_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('presentations/new.html.twig', [
    //         'presentation' => $presentation,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_presentations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presentations $presentation, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PresentationsType::class, $presentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('presentationPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $presentation->setPresentationPicture($newFilename);
            }
            $imageFile = $form->get('logo')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $presentation->setLogo($newFilename);
            }
            $imageFile = $form->get('statutesDoc')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $presentation->setStatutesDoc($newFilename);
            }
            $imageFile = $form->get('internalRulesDoc')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $presentation->setInternalRulesDoc($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('presentations/edit.html.twig', [
            'presentation' => $presentation,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_presentations_delete', methods: ['POST'])]
    // public function delete(Request $request, Presentations $presentation, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $presentation->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($presentation);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_presentations_index', [], Response::HTTP_SEE_OTHER);
    // }
}
