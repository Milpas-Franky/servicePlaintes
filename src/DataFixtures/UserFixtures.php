<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    //private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        /*$user = new User();
        $user->setNom('Luzayangamo')
            ->setPostnom('Anna')
            ->setPrenom('Aminata')
            ->setEmail('agent@gmail.com')
            ->setPassword($this->hasher->hashPassword($user, 'admin123'))
            ->setTelephone('+243 852 675 684')
            ->setRoles(['ROLE_AGENT'])
            ->setCommune($commune2); // association obligatoire

        $user = new User();
        $user->setNom($record['nom']);
            $user->setPostnom($record['postnom']);
            $user->setPrenom($record['prenom']);
            $user->setEmail($record['email']);
            $user->setTelephone($record['telephone']);
            $user->setRoles([$record['roles']]);   
            $user->setCommune($record['commune']);*/

        $users = [
            [
                'nom'=>'Luzayangamo',
                'postnom'=>'Mampuya',
                'prenom'=>'Nourdine',
                'email'=>'luzayanourdine@gmail.com',
                'password'=>'123',
                'telephone'=>'+243 852 675 684',
                'roles' => 'admin',
                //'commune_id' => 0
            ],
            [
                'nom'=>'Kongo',
                'postnom'=>'Milpas',
                'prenom'=>'Frank',
                'email'=>'frankonga@hotmail.com',
                'password' =>'123',
                'telephone'=>'+32 494 35 18 30',
                'roles'=>'agent',
                //'commune_id' => 1
            ],
            [
                'nom'=>'Luzayangamoko',
                'postnom'=>'Anna',
                'prenom'=>'Aminata',
                'email'=>'luzzaminata@hotmail.com',
                'telephone'=>'+243 816 015 211',
                'password' =>'123',
                'roles'=>'abonne',
                //'commune_id' => 2
            ],
        ];
        
        foreach ($users as $record) {
            $user = new User();
            
            $user->setNom($record['nom']);
            $user->setPostnom($record['postnom']);
            $user->setPrenom($record['prenom']);
            $user->setEmail($record['email']);
            $user->setTelephone($record['telephone']);
            $user->setRoles([$record['roles']]);   
            //$user->setCommune_id($record['commune_id']);

            //Hasher le mot de passe (sur base de la config security.yaml pour la classe $user)
            $hashedPassword = $this->passwordHasher->hashPassword($user, $record['password']);
              
            $user->setPassword($hashedPassword);

        /*$admin = (new User())
            ->setNom('Luzayangamo')
            ->setPostnom('Mampuya')
            ->setPrenom('Nourdine')
            ->setEmail('admin@eau.com')
            ->setPassword($this->hasher->hashPassword(new User(), 'admin123'))
            ->setTelephone('+243 852 675 684')
            ->setRoles(['ROLE_ADMIN']);

        $agent = (new User())
            ->setNom('Luzayangamo')
            ->setPostnom('Anna')
            ->setPrenom('Aminata')
            ->setEmail('agent@eau.com')
            ->setPassword($this->hasher->hashPassword(new User(), 'agent123'))
            ->setTelephone('+243 816 015 211')
            ->setRoles(['ROLE_AGENT']);
            
        $abonne = (new User())
            ->setNom('Kongo')
            ->setPostnom('Mbumba')
            ->setPrenom('Frank')
            ->setEmail('abonne@eau.com')
            ->setPassword($this->hasher->hashPassword(new User(), 'abonne123'))
            ->setTelephone('+243 816 015 211')
            ->setRoles(['ROLE_ABONNE']);
        
            $manager->persist($admin);
            $manager->persist($agent);
            $manager->persist($abonne);*/
            
            $manager->persist($user);
        }

            $manager->flush();
        }
    }