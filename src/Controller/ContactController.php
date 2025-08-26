<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ContactMessageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        $form = $this->createForm(ContactMessageType::class);

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact/ajax', name: 'app_contact_ajax', methods: ['POST'])]

    public function ajax(Request $request, EntityManager $em): Response
    {
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTime());
            $em->persist($contact);
            $em->flush();

            $contact->setCreatedAt(new \DateTime());

            return new Response('<div class="alert alert-success animate__animated animate__fadeIn">Merci, votre message a été envoyé !</div>');
        }

        // Affiche les erreurs
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = '<div class="alert alert-danger">' . $error->getMessage() . '</div>';
        }

        return new Response(implode('', $errors));
    }
}
