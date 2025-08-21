<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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


    #[Route(path: '/inscription', name: 'app_security_registration', methods: ['GET', 'POST'])]
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

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        //dump($form->getErrors(true));

        if ($form->isSubmitted() && $form->isValid()) {
            //dd('Formulaire soumis');
            // Récupération des données du formulaire
            $user = $form->getData();

            // Hashage du mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
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
            //return $this->redirectToRoute('app_security_login');
            return $this->redirectToRoute('app_user_dashboard');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
