<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Uid\Uuid;
//use Symfony\Component\Security\Http\Attribute\IsGranted;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_security_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /*#[Route(path: '/inscription', name: 'app_security_registration', methods: ['GET', 'POST'])]
    //#[IsGranted('IS_AUTHENTICATED_ANONYMOUSLY')]
    //const ROUTE_NAME = 'app_security_registration';
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, RoleRepository $roleRepository): Response
    {
        //dd('Controleur appelé');
        $user = new User();
        //$user->setRoles(['ROLE_USER']);

        /*$role = $roleRepository->findOneBy(['nom' => 'ROLE_USER']);
        $user->setRole($role);
        $em->persist($user);
        $em->flush();*/

    /*if ($request->isMethod('POST')) {
            dump('POST reçu');
        }

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        //dump($form->getErrors(true));

        if ($form->isSubmitted() && $form->isValid()) {
            /*dump('Formulaire soumis');
            dump($form->isValid());
            dump($form->getErrors(true));
            dd('Formulaire soumis');*/

    // Récupération des données du formulaire
    //$user = $form->getData();

    // Hashage du mot de passe
    /*$plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Rôle par défaut 
            $user->setRoles(['ROLE_USER']);
            $defaultRole = $roleRepository->findOneBy(['nom' => 'ROLE_USER']);
            $user->setRole($defaultRole);

            // Enregistrement dans la base de données 
            $em->persist($user);
            $em->flush();

            // Envoi de l'email de confirmation
            try {
                $email = (new Email())
                    ->from('noreply@regideso.com')
                    ->to($user->getEmail())
                    ->subject('Bienvenue sur notre plateforme')
                    ->html('<p>Bonjour ' . $user->getPrenom() . ',<br><br>
                    Votre compte a été créé avec succès.<br>
                    Vous pouvez maintenant vous connecter et suivre vos plaintes.<br><br>
                    Merci pour votre confiance.</p>');
                $mailer->send($email);
            } catch (\Throwable $e) {
                $this->addFlash('warning', 'Impossible d\'envoyer l\'email : ' . $e->getMessage());
            }

            $this->addFlash('success', 'Votre compte a bien été créé.');
            return $this->redirectToRoute('app_security_login');
            //return $this->redirectToRoute('app_user_dashboard');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

    /*#[Route(path: '/inscription', name: 'app_security_registration', methods: ['GET', 'POST'])]
    public function registration(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        MailerInterface $mailer,
        RoleRepository $roleRepository
    ): Response {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        // 🔍 Debug : est-ce que le formulaire est soumis ?
        /*dump('Form submitted?', $form->isSubmitted());
        dump('Form valid?', $form->isValid());
        dump('Errors:', (string) $form->getErrors(true, false));*/


    //dump($form->isSubmitted(), $form->isValid(), $form->getErrors(true));

    //if ($form->isSubmitted() && $form->isValid()) {
    // 🔍 Debug : vérifier que les données arrivent
    //dump('User data before persist', $user);

    // Récupération du mot de passe
    //$plainPassword = $form->get('plainPassword')->getData();
    //dump('Plain password', $plainPassword);

    /*$hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Rôle par défaut
            $user->setRoles(['ROLE_USER']);
            $defaultRole = $roleRepository->findOneBy(['nom' => 'ROLE_USER']);
            if ($defaultRole) {
                $user->setRole($defaultRole);
            }

            $em->persist($user);
            $em->flush();

            dump('User persisted successfully');
            dd('STOP ICI pour test avant envoi email');

            // Envoi de l'email de confirmation
            /*
        $email = (new Email())
            ->from('noreply@regideso.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre plateforme')
            ->html('<p>Bonjour ' . $user->getPrenom() . ',<br><br>
            Votre compte a été créé avec succès.<br>
            Vous pouvez maintenant vous connecter et suivre vos plaintes.<br><br>
            Merci pour votre confiance.</p>');
        $mailer->send($email);
        

            $this->addFlash('success', 'Votre compte a bien été créé.');
            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

    #[Route('/inscription', name: 'app_security_registration')]
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, RoleRepository $roleRepository): Response
    {
        $user = new User();
        //$user->setRoles(['ROLE_USER']);

        //$role = $roleRepository->findOneBy(['nom' => 'ROLE_USER']);
        //$user->setRole($role);


        $form = $this->createForm(RegistrationType::class, $user);

        // Important : handleRequest AVANT tout test
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plain = $form->get('plainPassword')->getData();
                $user->setPassword($passwordHasher->hashPassword($user, $plain));
                // Donne un rôle minimal si besoin
                if (!in_array('ROLE_USER', $user->getRoles(), true)) {
                    $user->setRoles(['ROLE_USER']);
                }

                //if ($form->isSubmitted() && $form->isValid()) {
                // Récupérer le plainPassword
                //$plainPassword = $form->get('plainPassword')->getData();

                // Hashage du mot de passe
                //$hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                //$user->setPassword($hashedPassword);

                // Sauvegarde en base
                $em->persist($user);
                $em->flush();

                /* Envoi de l'email de confirmation
            try {
                $email = (new Email())
                    ->from('noreply@regideso.com')
                    ->to($user->getEmail())
                    ->subject('Bienvenue sur notre plateforme')
                    ->html('<p>Bonjour ' . $user->getPrenom() . ',<br><br>
                Votre compte a été créé avec succès.<br>
                Vous pouvez maintenant vous connecter et suivre vos plaintes.<br><br>
                Merci pour votre confiance.</p>');
                $mailer->send($email);
            } catch (\Throwable $e) {
                $this->addFlash('warning', 'Impossible d\'envoyer l\'email : ' . $e->getMessage());
            }*/

                /*$email = (new Email())
                ->from('noreply@tonsite.com')
                ->to($user->getEmail())
                ->subject('Confirmez votre inscription')
                ->html('<p>Merci de confirmer votre compte en cliquant sur ce lien : 
                              <a href="' . $this->generateUrl('app_confirm_email', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL) . '">Confirmer</a></p>');
            */

                // Flash message
                $this->addFlash('success', 'Votre compte a bien été créé. Vous pouvez maintenant vous connecter.');

                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_security_login');
                //return $this->redirectToRoute('app_user_dashboard');
            } else {
                // Montre clairement que le formulaire est invalide
                $this->addFlash('danger', 'Le formulaire contient des erreurs.');
            }
        }

        // Affichage du formulaire
        return $this->render('security/register.html.twig', [
            // 'form' => $form->createView(),
            'form' => $form,
        ]);
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
