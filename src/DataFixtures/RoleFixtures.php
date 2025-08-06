<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Role;


class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = ['ROLE_ADMIN', 'ROLE_AGENT', 'ROLE_ABONNE'];

        foreach ($roles as $roleName) {
            $role = new Role();
            $role->setNom($roleName);
            $manager->persist($role);
        }
        $manager->flush();
    }
}
