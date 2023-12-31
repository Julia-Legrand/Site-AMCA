<?php

namespace App\Controller;

use App\Entity\Purposes;
use App\Form\PurposesType;
use App\Repository\PurposesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/purposes')]
class PurposesController extends AbstractController
{
    #[Route('/', name: 'app_purposes_index', methods: ['GET'])]
    public function index(PurposesRepository $purposesRepository): Response
    {
        return $this->render('purposes/index.html.twig', [
            'purposes' => $purposesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_purposes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $purpose = new Purposes();
        $form = $this->createForm(PurposesType::class, $purpose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($purpose);
            $entityManager->flush();

            return $this->redirectToRoute('app_purposes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purposes/new.html.twig', [
            'purpose' => $purpose,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_purposes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Purposes $purpose, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurposesType::class, $purpose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_purposes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purposes/edit.html.twig', [
            'purpose' => $purpose,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purposes_delete', methods: ['POST'])]
    public function delete(Request $request, Purposes $purpose, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purpose->getId(), $request->request->get('_token'))) {
            $entityManager->remove($purpose);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_purposes_index', [], Response::HTTP_SEE_OTHER);
    }
}
