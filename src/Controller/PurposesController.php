<?php

namespace App\Controller;

use App\Entity\Purposes;
use App\Form\PurposesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/raison-asso')]
class PurposesController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/nouveau', name: 'app_purposes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $purpose = new Purposes();
        $form = $this->createForm(PurposesType::class, $purpose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($purpose);
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purposes/new.html.twig', [
            'purpose' => $purpose,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_purposes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Purposes $purpose, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurposesType::class, $purpose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purposes/edit.html.twig', [
            'purpose' => $purpose,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_purposes_delete', methods: ['POST'])]
    public function delete(Request $request, Purposes $purpose, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $purpose->getId(), $request->request->get('_token'))) {
            $entityManager->remove($purpose);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
    }
}
