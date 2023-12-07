<?php

namespace App\Controller;

use App\Entity\Memberships;
use App\Form\MembershipsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MembershipsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/memberships')]
class MembershipsController extends AbstractController
{
    #[Route('/', name: 'app_memberships_index', methods: ['GET'])]
    public function index(MembershipsRepository $membershipsRepository): Response
    {
        return $this->render('memberships/index.html.twig', [
            'memberships' => $membershipsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_memberships_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $membership = new Memberships();
        $form = $this->createForm(MembershipsType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling file uploading
            $imageFile = $form->get('membershipForm')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $membership->setMembershipForm($newFilename);
            }

            $entityManager->persist($membership);
            $entityManager->flush();

            return $this->redirectToRoute('app_memberships_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memberships/new.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_memberships_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Memberships $membership, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(MembershipsType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handling file uploading
            $imageFile = $form->get('membershipForm')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $membership->setMembershipForm($newFilename);
            }
            
            $entityManager->flush();

            return $this->redirectToRoute('app_memberships_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memberships/edit.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memberships_delete', methods: ['POST'])]
    public function delete(Request $request, Memberships $membership, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membership->getId(), $request->request->get('_token'))) {
            $entityManager->remove($membership);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_memberships_index', [], Response::HTTP_SEE_OTHER);
    }
}
