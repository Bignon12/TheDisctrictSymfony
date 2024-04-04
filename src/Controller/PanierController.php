<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierService $panierService): Response
    {
       $panierData = $panierService->getpanier();
       $total = $panierService->getTotal();

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'plat'=>$panierData,
            'total'=>$total
        ]);
    }

    #[Route('/panier/ajout_panier{id}', name: 'ajout_panier')]
    public function ajout_panier($id, PanierService $panierService)
    {
        //je fais appel au PanierService auquel j'applique la méthode ajout_panier
        $panierService->ajout_panier($id);

        //redirection sur la page panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/delete_panier{id}', name: 'delete_panier')]
    public function delete_panier($id, PanierService $panierService)
    {
        //je fais appel au PanierService auquel j'applique la méthode ajout_panier
        $panierService->delete_panier($id);

        //redirection sur la page panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/remove_panier{id}', name: 'remove_panier')]
    public function remove_panier($id, PanierService $panierService)
    {
        //je fais appel au PanierService auquel j'applique la méthode ajout_panier
        $panierService->remove_panier($id);

         //redirection sur la page panier
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/vider_panier', name: 'vider_panier')]
    public function vider_panier(PanierService $panierService)
    {
        //je fais appel au PanierService auquel j'applique la méthode viderPanier
        $panierService->vider_panier();

         //redirection sur la page panier
        return $this->redirectToRoute('app_panier');
    }
}
