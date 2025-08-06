<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $user = $this->getReference('user_default');
        $plainte = $this->getReference('plainte_default');


        $commentaire = new Commentaire();
        $commentaire->setContenu("Ceci est un commentaire d'exemple.");
        $commentaire->setDate(new \DateTime());
        $commentaire->setUser($user);
        $commentaire->setPlainte($plainte);

        $manager->persist($commentaire);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PlainteFixtures::class,
        ];
    }
}
