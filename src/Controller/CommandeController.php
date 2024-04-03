<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Utilisateur;
use App\Repository\PlatRepository;
use App\Service\Panier\PanierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(PanierService $panierService, EntityManagerInterface $em): Response
    {
        // Vérifie si l'utilisateur est connecté
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupère les données du panier
        $panierData = $panierService->getPanier();

        // Vérifie si le panier est vide
        if (empty($panierData)) {
            $this->addFlash('message', 'votre panier est vide');
            return $this->redirectToRoute('app_catalogue');
        }

        //Si le panier n'est pas vide, on crée la commande
        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());

        // Crée les détails de la commande à partir des éléments du panier
        foreach ($panierData as $plat => $quantite) 
        {
            $detail = new Detail();
            $plat = $panierData['plat'];
            $detail->setPlat($plat);
            $detail->setQuantite($quantite);
            $commande->addDetail($detail);
        }

        // Enregistre la commande dans la base de données
       
            $em->persist($commande);
            $em->flush();
        
            return $this->redirectToRoute('app_catalogue');

        // Vide le panier
        // $panierService->viderPanier();

        // Ajoute un message flash de succès
        $this->addFlash('message', 'commande créée avec succès');

        return $this->redirectToRoute('app_home');
    }
}

