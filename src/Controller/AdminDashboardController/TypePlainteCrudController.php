<?php

namespace App\Controller\AdminDashboardController;

use App\Entity\TypePlainte;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class TypePlainteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypePlainte::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
        ];
    }
    
}