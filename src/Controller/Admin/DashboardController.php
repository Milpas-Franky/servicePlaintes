<?php

namespace App\Controller\Admin;

use App\Entity\Plainte;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Commentaire;
use App\Entity\Reponse;
use App\Entity\Commune;
use App\Entity\Status;
use App\Entity\TypePlainte;
use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\PlainteCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    /*public function_construct(
            private AdminUrlGenerator $adminUrlGenerator
    ){
    }*/

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        //return $this->render('admin/dashboard.html.twig');

        //dump($this->getUser()); die;

        $url = $this->container->get(AdminUrlGenerator::class)
            ->setController(PlainteCrudController::class)
            ->generateUrl();

        return $this->redirect($url);


        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion des Plaintes - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::section('Gestion des utilisateurs');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Utilisateurs', 'fas fa-user', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Utilisateurs', 'fas fa-eye', User::class)
        ]);

        yield MenuItem::section('Gestion des plaintes');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Plaintes', 'fas fa-file-alt', Plainte::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Plaintes', 'fas fa-eye', Plainte::class)
        ]);

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Commentaires', 'fas fa-comments', Commentaire::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Commentaires', 'fas fa-eye', Commentaire::class)
        ]);

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Reponses', 'fas fa-reply', Reponse::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Reponses', 'fas fa-eye', Reponse::class)
        ]);

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Types de plainte', 'fas fa-list', TypePlainte::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Types de plainte', 'fas fa-eye', TypePlainte::class)
        ]);

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Statuts', 'fas fa-flag', Status::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Statuts', 'fas fa-eye', Status::class)
        ]);

        yield MenuItem::section('Autres');

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Communes', 'fas fa-city', Commune::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Communes', 'fas fa-eye', Commune::class)
        ]);

        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Contacts', 'fas fa-envelope', Contact::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Contacts', 'fas fa-eye', Contact::class)
        ]);
    }
}
