<?php

namespace App\Controller;

use App\Entity\MemoryDuty;
use App\Form\MemoryDutyType;
use App\Repository\MemoryDutyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/devoir-memoire')]
class MemoryDutyController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_memory_duty_index', methods: ['GET'])]
    public function index(MemoryDutyRepository $memoryDutyRepository): Response
    {
        return $this->render('memory_duty/index.html.twig', [
            'memory_duties' => $memoryDutyRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/nouveau', name: 'app_memory_duty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $memoryDuty = new MemoryDuty();
        $form = $this->createForm(MemoryDutyType::class, $memoryDuty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('memoryPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $memoryDuty->setMemoryPicture($newFilename);
            }
            $entityManager->persist($memoryDuty);
            $entityManager->flush();

            return $this->redirectToRoute('app_memory_duty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memory_duty/new.html.twig', [
            'memoryDuty' => $memoryDuty,
            'form' => $form,
        ]);
    }

    // Function to remove the old file
    private function removeOldFile(string $filename): void
    {
        $filePath = $this->getParameter('images_directory') . '/' . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_memory_duty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MemoryDuty $memoryDuty, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MemoryDutyType::class, $memoryDuty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling files uploading
            $imageFile = $form->get('memoryPicture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $memoryDuty->setMemoryPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_memory_duty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memory_duty/edit.html.twig', [
            'memoryDuty' => $memoryDuty,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_memory_duty_delete', methods: ['POST'])]
    public function delete(Request $request, MemoryDuty $memoryDuty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $memoryDuty->getId(), $request->request->get('_token'))) {
            // Remove the old file before removing the entity
            $this->removeOldFile($memoryDuty->getMemoryPicture());

            $entityManager->remove($memoryDuty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_memory_duty_index', [], Response::HTTP_SEE_OTHER);
    }
}
