<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/espace-abonne', name: 'app_user_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    #[Route('/modifier-profil', name: 'app_user_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour.');
            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier-infos', name: 'app_modifier_infos')]
    #[IsGranted('ROLE_USER')]
    public function modifierInfos(Request $request): Response
    {
        // À implémenter : formulaire pour modifier les infos de l'utilisateur
        return $this->render('user/modifier_infos.html.twig');
    }

    #[Route('/confirmer/{token}', name: 'app_confirm_email')]
    public function confirm(string $token, UserRepository $repo, EntityManagerInterface $em): Response
    {
        $user = $repo->findOneBy(['confirmationToken' => $token]);
        if (!$user) {
            throw $this->createNotFoundException();
        }

        $user->setConfirmationToken(null);
        $em->flush();

        $this->addFlash('success', 'Votre compte est maintenant activé.');
        return $this->redirectToRoute('app_security_login');
    }
}
