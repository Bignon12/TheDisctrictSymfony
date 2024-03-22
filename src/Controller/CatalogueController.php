<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Entity\Categorie;
use App\Entity\Plat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{ 
    private $categorieRepo;
    private $platRepo;

     public function __construct(CategorieRepository $categorieRepo, PlatRepository $platRepo)
     {
        $this->categorieRepo = $categorieRepo;
        $this->platRepo = $platRepo;
       
     }

    #[Route('/', name: 'app_catalogue')]
    public function index(EntityManagerInterface $EntityManager, PlatRepository $platRepo, CategorieRepository $categorieRepo): Response
    {
        $plat = $platRepo->getBestPlat($EntityManager);
        $categorie = $categorieRepo->getBestCat($EntityManager);

       
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'plat' => $plat,
            'categorie' => $categorie
         ]);
    }

    #[Route('/categorie', name: 'app_catalogue_categorie')]
    public function afficherCat(): Response
    {
        $categorie = $this->categorieRepo->findAll();

        return $this->render('catalogue/cat.html.twig', [
            'controller_name' => 'CatalogueController',
            'categorie' => $categorie,
        ]);
    }

    #[Route('/plat', name: 'app_catalogue_plat')]
    public function afficherPlat(): Response
    {
        $plat = $this->platRepo->findAll();

        return $this->render('catalogue/plat.html.twig', [
            'controller_name' => 'CatalogueController',
            'plat' => $plat,
        ]);
    }

    #[Route('/plat/{categorie_id}', name: 'app_catalogue_platcat')]
    public function afficherPlatByCategorieId(Request $request, PlatRepository $platRepo): Response
    {
        
        $id = $request->attributes->get('categorie_id');
        $plat = $platRepo->findBy(['categorie'=>$id]);
     
        return $this->render('catalogue/platcategorie.html.twig', [
            'controller_name' => 'CatalogueController',
            'plat' => $plat
        ]);
    }
}
