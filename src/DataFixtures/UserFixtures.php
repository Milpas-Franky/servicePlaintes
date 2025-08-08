<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    //private UserPasswordHasherInterface $passwordHasher;

    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    /*{
        $this->passwordHasher = $passwordHasher;
    }*/

    public function load(ObjectManager $manager): void
    {
        // Création des rôles
        $adminRole = new Role();
        $adminRole->setNom(('ROLE_ADMIN'));
        $manager->persist($adminRole);

        $agentRole = new Role();
        $agentRole->setNom(('ROLE_AGENT'));
        $manager->persist($agentRole);

        $abonneRole = new Role();
        $abonneRole->setNom(('ROLE_ABONNE'));
        $manager->persist($abonneRole);

        $userRole = new Role();
        $userRole->setNom('ROLE_USER');
        $manager->persist($userRole);


        // Création de l'utilisateur Admin
        $admin = new User();
        $admin->setNom('Luzayangamo')
            ->setPostnom('Mampuya')
            ->setPrenom('Nourdine')
            ->setEmail('admin@regideso.com')
            ->setTelephone('+243 852 675 684')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'NMampuya1995_@Choubebe'))
            ->setRoles(['ROLE_ADMIN'])
            ->setRole($adminRole);
        $manager->persist($admin);
        $manager->flush();
        //dd($admin->getPassword());


        // Création d'un agent
        $agent = new User();
        $agent->setNom('Luzayangamo')
            ->setPostnom('Anna')
            ->setPrenom('Aminata')
            ->setEmail('agent@regideso.com')
            ->setTelephone('+243 816 015 211')
            ->setPassword($this->passwordHasher->hashPassword($agent, 'Anna1991_@Llz'))
            ->setRoles(['ROLE_AGENT'])
            ->setRole($agentRole);
        $manager->persist($agent);
        $this->addReference('agent_user', $agent);


        // Création d'un abonné
        $abonne = new User();
        $abonne->setNom('Kongolo')
            ->setPostnom('Mbumba')
            ->setPrenom('Frank')
            ->setEmail('abonne@regideso.com')
            ->setTelephone('+243 816 015 212')
            ->setPassword($this->passwordHasher->hashPassword($abonne, 'Kongo1976_@Cct'))
            ->setRoles(['ROLE_ABONNE'])
            ->setRole($abonneRole);
        $manager->persist($abonne);
        $this->addReference('abonne_user', $abonne);


        // Création de User par défaut (pour les fixtures)
        $user = new User();
        $user->setNom('User')
            ->setPostnom('Démo')
            ->setPrenom('Fixture')
            ->setEmail('user@regideso.com')
            ->setTelephone('+243000000000')
            ->setPassword($this->passwordHasher->hashPassword($user, 'User2025_@Demo'))
            ->setRoles(['ROLE_USER'])
            ->setRole($userRole);

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'User2025_@Demo');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $this->addReference('user_default', $user);

        $manager->flush();
    }
}
