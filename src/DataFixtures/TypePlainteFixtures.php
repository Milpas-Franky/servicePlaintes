<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TypePlainte;


class TypePlainteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Facturation', 'Fuite', 'Coupure', 'Qualité de l’\eau'];

        foreach ($types as $index => $typeNom) {
            $typePlainte = new TypePlainte();
            $typePlainte->setNom($typeNom);
            $manager->persist($typePlainte);

            // Ajout de la référence pour le premier statut seulement
            if ($index === 0) {
                $this->addReference('type_default', $typePlainte);
            }
        }

        $manager->flush();
        echo "✅ TypePlainteFixtures : Types insérés avec succès.\n";

        $manager->flush();
    }
}
