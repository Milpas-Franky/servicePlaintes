<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $noms = ['En attente', 'En cours', 'Résolue', 'Réjetée'];

        foreach ($noms as $index => $nom) {
            $status = new Status();
            $status->setNom($nom);
            $manager->persist($status);

            // Ajout de la référence pour le premier statut seulement
            if ($index === 0) {
                $this->addReference('status_default', $status);
            }
        }

        $manager->flush();
    }
}
