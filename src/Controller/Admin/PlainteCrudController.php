<?php

namespace App\Controller\Admin;

use App\Entity\Plainte;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
//use App\Repository\PlainteRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;


class PlainteCrudController extends AbstractCrudController
{
      //private PlainteRepository $repo;
      private ManagerRegistry $doctrine;


    /*public function __construct(PlainteRepository $repo)
    {
        $this->repo = $repo;
    }*/

    
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public static function getEntityFqcn(): string
    {
        return Plainte::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Plainte')
            ->setEntityLabelInPlural('Plaintes')
            ->setDefaultSort(['id' => 'DESC']);
    }

    
    public function configureFields(string $pageName): iterable
    {
         // Récupération rapide des plaintes pour debug
    /*$repo = $this->getDoctrine()->getRepository(Plainte::class);
    $plaintes = $this->repo->findAll();

    foreach ($plaintes as $p) {
        dump([
            'id' => $p->getId(),
            'typePlainte' => $p->getTypePlainte(),
            'user' => $p->getUser(),
            'status' => $p->getStatus(),
        ]);
        }
        die(); // Stoppe l'exécution pour voir le résultat complet

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('objet'),
            TextEditorField::new('description'),
            DateTimeField::new('date', 'Date de dépôt'),
            AssociationField::new('user', 'Déposée par'),
            AssociationField::new('status', 'Statut'),
            AssociationField::new('typePlainte', 'Type de plainte')
                /*->setRequired(false)
                ->formatValue(function($value, $entity){ 
                    return $value ? $value->getNom() : '—' ;
                }),
        ];*/
        return [
            IdField::new('id')->onlyOnIndex(),
            
            // Champ "objet" : un simple texte court
            TextField::new('objet', 'Objet'),

            // Champ "description" : éditeur multi-ligne
            TextEditorField::new('description', 'Description')
            ->hideOnIndex(), // pas besoin de l’afficher en entier dans la liste

            // Champ "date" : date de dépôt
            DateTimeField::new('date', 'Date de dépôt')
            ->setFormat('dd/MM/yyyy HH:mm')
            //->hideOnForm(), // si c’est géré automatiquement en back-end
            ->onlyOnDetail(), // visible uniquement en mode "detail" et "liste"
            
            // Relations
            AssociationField::new('typePlainte', 'TypePlainte'),
            AssociationField::new('user', 'Déposée par'),
            AssociationField::new('status', 'Statut'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = $this->doctrine->getRepository(Plainte::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.typePlainte', 'tp')->addSelect('tp')
            ->leftJoin('p.user', 'u')->addSelect('u')
            ->leftJoin('p.status', 's')->addSelect('s');

        return $qb;
    }
    

    /*public function findAllWithRelations():array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.typePlainte', 'tp')->addSelect('tp')
            ->leftJoin('p.user', 'u')->addSelect('u')
            ->leftJoin('p.status', 's')->addSelect('s')
            ->getQuery()
            ->getResult();
        
    }*/
}