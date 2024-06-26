<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ContactsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PresentationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact')]
class ContactsController extends AbstractController
{
    // #[Route('/', name: 'app_contacts_index', methods: ['GET'])]
    // public function index(ContactsRepository $contactsRepository): Response
    // {
    //     return $this->render('contacts/index.html.twig', [
    //         'contacts' => $contactsRepository->findAll(),
    //     ]);
    // }

    // #[Route('/nouveau-message', name: 'app_contacts_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager, PresentationsRepository $presentationsRepository): Response
    // {
    //     $contact = new Contacts();
    //     $form = $this->createForm(ContactsType::class, $contact);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $contact->setCreatedAt(new \DateTimeImmutable());

    //         $entityManager->persist($contact);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('contacts/new.html.twig', [
    //         'contact' => $contact,
    //         'form' => $form,
    //         'presentations' => $presentationsRepository->findAll(),
    //     ]);
    // }

    // #[IsGranted('ROLE_ADMIN')]
    // #[Route('/{id}', name: 'app_contacts_delete', methods: ['POST'])]
    // public function delete(Request $request, Contacts $contact, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($contact);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_contacts_index', [], Response::HTTP_SEE_OTHER);
    // }
}
