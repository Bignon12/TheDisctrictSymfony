<?php

namespace App\Controller;

use App\Entity\Commande;
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
    public function add(PanierService $panierservice, EntityManagerInterface $em): Response
    {
        //je vérifie s'il y a un utilisateur connecté
        $this->denyAccessUnlessGranted('ROLE_USER');

        //je récupère les données du panier
        $panierData = $panierservice->getpanier();
        
        //je vérifie si le panier récupéré est vide
        if($panierData === [])
        {
            $this->addFlash('message', 'votre panier est vide');
            return $this->redirectToRoute('app_catalogue');
        }

        //Si le panier n'est pas vide, on crée la commande
        $commande = new Commande();

        //on remplit la commande
        $commande->setUtilisateur($this->getUser());

        //on parcourt le panier pour créer les détails de la commande
        foreach($panierData as $item=>$quantity)
        {
            //on instancie la classe détail
            $detail = new Detail();

            //on récupère le plat
            $plat = $panierData[$item];
           
            //on crée le détail de la commande
            $detail->setPlat($plat);
            $detail->setQuantite($quantity);

            //j'ajoute les détails à ma commande
            $commande->addDetail($detail);
        }
         //on persite et on flush pour envoyer la commande dans la base de données
         $em->persist($commande);
         $em->flush();

          //on vide le panier
       
        $this->addFlash('message', 'commande créée avec succès');

        
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
