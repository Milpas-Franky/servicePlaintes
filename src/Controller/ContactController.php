<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{

    #[Route('/contact/ajax', name: 'app_contact_ajax', methods: ['POST'])]

    public function contactAjax(Request $request): Response
    {
        $name = $request->get('nom');
        $email = $request->get('email');
        $message = $request->get('message');

        // Traitement...

        return new Response('<div class="alert alert-success">Message envoyé !</div>');
    }
}