<?php

namespace App\Controller;

use App\Entity\Memberships;
use App\Form\MembershipsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/adhésion')]
class MembershipsController extends AbstractController
{

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/modifier', name: 'app_memberships_edit', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('memberships/edit.html.twig', [
            'membership' => $membership,
            'form' => $form,
        ]);
    }
}
