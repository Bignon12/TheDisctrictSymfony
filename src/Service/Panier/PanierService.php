<?php

namespace App\Service\Panier;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $requestStack;
    private $platRepo;
    
    public function __construct(RequestStack $requestStack, PlatRepository $platRepo)
    {
        $this->requestStack = $requestStack;
        $this->platRepo = $platRepo;
    }

    public function ajout_panier(int $id)
    {
        // Récupérer la session à partir de RequestStack
        $session = $this->requestStack->getSession();

        // Récupérer le panier depuis la session
        $panier = $session->get('panier', []);

        // Vérifier si le plat ayant cet id a été sélectionné une fois
        if (!empty($panier[$id]))
        {
            // Si oui, incrémenter
            $panier[$id]++;
        }
        else
        {
            // Sinon, initialiser à 1
            $panier[$id] = 1;
        }

        // Sauvegarder le contenu du panier dans la session
        $session->set('panier', $panier);
    }

    public function delete_panier(int $id)
    {
        // Récupérer la session à partir de RequestStack
        $session = $this->requestStack->getSession();

        //je vérifie si mon panier contient de données, 
        //la variable me renvoie un tableau vide, le cas échéant
        $panier = $session->get('panier', []);

        //je vérifie si ce plat ayant cet id a été sélectionné une fois
        if (!empty($panier[$id]) && $panier[$id]>0)
        {
            //si oui, je décrémente
            $panier[$id]--;
        }
       
        //je sauvegarde le contenu de mon panier dans la session
        $session->set('panier', $panier);
    }

    public function remove_panier(int $id)
    {
        // Récupérer la session à partir de RequestStack
        $session = $this->requestStack->getSession();

        //je vérifie si mon panier contient de données, 
        //la variable me renvoie un tableau vide, le cas échéant
        $panier = $session->get('panier', []);

        //je vérifie si ce plat ayant cet id a été sélectionné une fois
        if (!empty($panier[$id]))
        {
            //si oui, on supprime le produit
            unset($panier[$id]);
        }
       
        //je sauvegarde le contenu de mon panier dans la session
        $session->set('panier', $panier);
        
    }

    public function getPanier()
    {
        // Récupérer la session à partir de RequestStack
        $session = $this->requestStack->getSession();

        //je récupère le contenu du panier
        $panier = $session->get('panier', []);

        //je crée une variable pour les données du panier (le plat et la quantité)
        //je récupère le plat sélectionné et la quantité commandée
        $panierData = [];
        foreach($panier as $id=>$quantite)
        {
            $panierData[] = [
                'plat'=>$this->platRepo->find($id),
                'quantite'=>$quantite
            ];
        }
        return $panierData;
    }

    public function getTotal()
    {
        //j'initialise la variable $total à 0
        $total = 0;

        foreach($this->getPanier() as $plat)
        {   
            //je calcule le montant total de la commande dans le panier
            $total += $plat['plat']->getPrix() * $plat['quantite'];
        }

        return $total;
    }

   
    public function vider_panier()
        {
            // Récupérer la session à partir du service SessionInterface
            $session = $this->requestStack->getSession();
            
            // Récupérer le panier de la session
            $panier = $session->get('panier', []);
        
            // Vider le panier
            $panier = [];
        
            // Sauvegarder le panier vidé dans la session
            $session->set('panier', $panier);
        }
        
    }

