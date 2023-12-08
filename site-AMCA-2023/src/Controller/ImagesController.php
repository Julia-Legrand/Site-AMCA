<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/images')]
class ImagesController extends AbstractController
{
    #[Route('/', name: 'app_images_index', methods: ['GET'])]
    public function index(ImagesRepository $imagesRepository): Response
    {
        return $this->render('images/index.html.twig', [
            'images' => $imagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $image->setImage($newFilename);
            }

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('images/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Images $image, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();
        
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
        
                $image->setImage($newFilename);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('images/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_images_delete', methods: ['POST'])]
    public function delete(Request $request, Images $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
