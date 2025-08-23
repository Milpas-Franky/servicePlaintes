<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MonCompteController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_user_account')]
    public function account(): Response
    {
        $user = $this->getUser();

        return $this->render('user/account.html.twig', [
            //'controller_name' => 'MonCompteController',
            'user' => $user,
        ]);
    }
}
