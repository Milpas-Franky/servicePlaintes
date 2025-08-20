<?php

namespace App\Controller;

use App\Repository\PlainteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/*final class SuiviPlainteController extends AbstractController
{
    #[Route('/suivre-plainte', name: 'app_suivre_plainte')]
    public function index(Request $request, PlainteRepository $repository): Response
    {
        return $this->render('suivi_plainte/index.html.twig', [
            'controller_name' => 'SuiviPlaintController',
        ]);
    }
}*/

#[Route('/suivre-plainte', name: 'app_suivre_plainte')]
class SuiviPlainteController extends AbstractController
{
    #[Route('', name: 'suivre_plainte_form', methods: ['GET', 'POST'])]
    public function index(Request $request, PlainteRepository $repository): Response
    {
        $code = $request->request->get('code_suivi');
        $plainte = $code ? $repository->findOneBy(['codeSuivi' => $code]) : null;

        return $this->render('plainte/suivi.html.twig', [
            'plainte' => $plainte,
            'code' => $code,
        ]);
    }
}
