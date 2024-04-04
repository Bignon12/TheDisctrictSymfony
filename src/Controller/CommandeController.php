<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\Detail;
use App\Entity\Utilisateur;
use App\Repository\PlatRepository;
use App\Service\Panier\PanierService;
use DateTime;
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
        $date_commande = new DateTime('now');
        $total = $panierService->getTotal();
        $commande->setUtilisateur($this->getUser());
        $commande->setDateCommande($date_commande);
        $commande->setTotal($total);
        

        // Crée les détails de la commande à partir des éléments du panier
        foreach ($panierData as $item) 
        {
            $detail = new Detail();
            $plat = $item['plat'];
            $detail->setPlat($plat);
            $quantite = $item['quantite'];
            $detail->setQuantite($quantite);
            $commande->addDetail($detail);
           
        }

        // Enregistre la commande dans la base de données
            $em->persist($commande);
            $em->flush();

            $panierService->vider_panier();

             // Ajoute un message flash de succès
            $this->addFlash('success', 'commande créée avec succès');
        
            return $this->render('commande/index.html.twig', [
                'controller_name' => 'CommandeController',
                
            ]);

           
    }
}

