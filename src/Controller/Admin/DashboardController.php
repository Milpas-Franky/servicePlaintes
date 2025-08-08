<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Plainte;
use App\Entity\Contact;
//use App\Entity\Commentaire;
//use App\Entity\Reponse;
use App\Entity\Commune;
use App\Entity\Status;
use App\Entity\TypePlainte;
//use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\PlainteCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();
        //return $this->render('admin/dashboard.html.twig');

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
            ->setTitle('ServicePlaintes - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::section('Gestion des utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        //yield MenuItem::linkToCrud('Rôles', 'fas fa-user-shield', Role::class);

        yield MenuItem::section('Gestion des plaintes');
        yield MenuItem::linkToCrud('Plaintes', 'fas fa-file-alt', Plainte::class);
        //yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Commentaire::class);
        //yield MenuItem::linkToCrud('Réponses', 'fas fa-reply', Reponse::class);
        yield MenuItem::linkToCrud('Types de plainte', 'fas fa-list', TypePlainte::class);
        yield MenuItem::linkToCrud('Statuts', 'fas fa-flag', Status::class);

        yield MenuItem::section('Autres');
        yield MenuItem::linkToCrud('Communes', 'fas fa-city', Commune::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-envelope', Contact::class);
    }
}
