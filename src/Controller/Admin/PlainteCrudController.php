<?php

namespace App\Controller\Admin;

use App\Entity\Plainte;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;



class PlainteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plainte::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('objet'),
            TextEditorField::new('description'),
            DateTimeField::new('date', 'Date de dépôt'),
            AssociationField::new('user', 'Déposée par'),
            AssociationField::new('status', 'Statut'),
            AssociationField::new('typePlainte', 'Type de plainte'),
        ];
    }
}
