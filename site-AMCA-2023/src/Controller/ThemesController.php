<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Form\ThemesType;
use App\Repository\ThemesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/themes')]
class ThemesController extends AbstractController
{
    #[Route('/', name: 'app_themes_index', methods: ['GET'])]
    public function index(ThemesRepository $themesRepository): Response
    {
        return $this->render('themes/index.html.twig', [
            'themes' => $themesRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_themes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $theme = new Themes();
        $form = $this->createForm(ThemesType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('app_themes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('themes/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_themes_edit', methods: ['GET', 'POST'])]
    public function edit(UserInterface $user, Request $request, Themes $theme, EntityManagerInterface $entityManager,ThemesRepository $themesRepository): Response
    {
        $form = $this->createForm(ThemesType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_themes_index', [], Response::HTTP_SEE_OTHER);
        }

        // Editing themes only by the owner user
        $userThemes = $themesRepository->findBy(['user' => $user]);

        return $this->renderForm('themes/edit.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_themes_delete', methods: ['POST'])]
    public function delete(Request $request, Themes $theme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_themes_index', [], Response::HTTP_SEE_OTHER);
    }
}
