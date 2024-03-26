<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Entity\plat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, PlatRepository $platRepo): Response
    {
        $panier = $session->get('panier', []);

        $panierData = [];
        foreach($panier as $id=>$quantite)
        {
            $panierData[] = [
                'plat'=>$platRepo->find($id),
                'quantite'=>$quantite
            ];
        }

        $total = 0;

    foreach($panierData as $item)
    {
        $totalPlat = $item['plat']->getPrix() * $item['quantite'];
        $total += $totalPlat;
    }
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'plat'=> $panierData,
            'total'=> $total
        ]);
    }

    #[Route('/panier/ajout_panier{id}', name: 'ajout_panier')]
    public function ajout_panier($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        
        if (!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }
       
        $session->set('panier', $panier);
        
        dd($session->get('panier'));

        return $this->render('panier/ajout.html.twig', [
            'controller_name' => 'PanierController',
            
        ]);
    }
}
