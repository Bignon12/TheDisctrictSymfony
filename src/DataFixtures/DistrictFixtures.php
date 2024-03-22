<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Contact;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use App\Entity\Detail;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DistrictFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        include 'the_district.php';

        // Chargement des catégories
        foreach ($categorie as $cat) 
        {
            $categorieDB = new Categorie();
            $categorieDB->setId($cat['id']);
            $categorieDB->setLibelle($cat['libelle']);
            $categorieDB->setImage($cat['image']);
            $categorieDB->setActive($cat['active']);

            $manager->persist($categorieDB);
            // empêcher l'auto incrément
            $metadata = $manager->getClassMetaData(Categorie::class);
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $manager->flush();

        // Chargement des plats
        foreach ($plat as $plt) {
            $platDB = new Plat();
            $platDB->setId($plt['id']);
            $platDB->setLibelle($plt['libelle']);
            $platDB->setImage($plt['image']);
            $platDB->setPrix($plt['prix']);
            $platDB->setDescription($plt['description']);
            $platDB->setActive($plt['active']);

            $categorie = $manager->getRepository(Categorie::class)->find($plt['id_categorie']);
            $platDB->setCategorie($categorie);
            $manager->persist($platDB);

            $metadata = $manager->getClassMetaData(Plat::class);
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $manager->flush();

        // Chargement des utilisateurs
        $utilisateur1 = new Utilisateur();
        $utilisateur1->setEmail('example@example.com');
        $utilisateur1->setPassword('$2y$13$Dva7l2H0UHZkzb33mc2/HubjH27sh2Og36mJH2pcS/GFX.w7KMsse');
        $utilisateur1->setNom('JOJO');
        $utilisateur1->setPrenom('Joseph');
        $utilisateur1->setCp(80080);
        $utilisateur1->setVille('amiens');
        $utilisateur1->setTelephone('0658962323');
        $utilisateur1->setAdresse('Rue Georges GUYNEMER');

        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setEmail('exo@example.com');
        $utilisateur2->setPassword('$2y$13$d0b2h51qnRXhFv2b/9TnKudFdtJzn8z8yNG.0DQryEh3zvSrNNSSq');
        $utilisateur2->setNom('LAPLAGE');
        $utilisateur2->setPrenom('Jean');
        $utilisateur2->setCp('60060');
        $utilisateur2->setVille('Boulogne');
        $utilisateur2->setTelephone('0748562023');
        $utilisateur2->setAdresse('Rue Jean Moulin');

        $manager->persist($utilisateur2);
        $manager->flush();

        // Chargement des commandes
        $commande1 = new Commande();
        $commande1->setDateCommande(new DateTime());
        $commande1->setTotal(50.00);
        $commande1->setEtat(0);
        $commande1->setUtilisateur($utilisateur1);

        $manager->persist($commande1);

        $commande2 = new Commande();
        $commande2->setDateCommande(new DateTime());
        $commande2->setTotal(70.00);
        $commande2->setEtat(1);
        $commande2->setUtilisateur($utilisateur2);

        $manager->persist($commande2);

        $commande3 = new Commande();
        $commande3->setDateCommande(new DateTime());
        $commande3->setTotal(60.00);
        $commande3->setEtat(2);
        $commande3->setUtilisateur($utilisateur1);

        $manager->persist($commande3);

        $commande4 = new Commande();
        $commande4->setDateCommande(new DateTime());
        $commande4->setTotal(60.00);
        $commande4->setEtat(2);
        $commande4->setUtilisateur($utilisateur2);

        $manager->persist($commande4);

        $commande5 = new Commande();
        $commande5->setDateCommande(new DateTime());
        $commande5->setTotal(60.00);
        $commande5->setEtat(2);
        $commande5->setUtilisateur($utilisateur2);

        $manager->persist($commande5);

        $manager->flush();

        //chargement des details
        //District Burger
        $plat = $manager->getRepository(plat::class)->find(4);
        $detail1 = new detail();
        $detail1->setQuantite(5);
        $detail1->setQuantite(5);
        $detail1->setPlat($plat);
        $detail1->setCommande($commande1);
        $manager->persist($detail1);

        //Spaguetti aux légumes
        $plat = $manager->getRepository(plat::class)->find(12);
        $detail2 = new detail();
        $detail2->setQuantite(1);
        $detail2->setPlat($plat);
        $detail2->setCommande($commande1);
        $manager->persist($detail2);

        //Salades césar
        $plat = $manager->getRepository(plat::class)->find(13);
        $detail3 = new detail();
        $detail3->setQuantite(10);
        $detail3->setPlat($plat);
        $detail3->setCommande($commande2);
        $manager->persist($detail3);

        //Lasagnes
        $plat = $manager->getRepository(plat::class)->find(16);
        $detail4 = new detail();
        $detail4->setQuantite(11);
        $detail4->setPlat($plat);
        $detail4->setCommande($commande3);
        $manager->persist($detail4);

        //Tagliatelles aux saumons
        $plat = $manager->getRepository(plat::class)->find(17);
        $detail5 = new detail();
        $detail5->setQuantite(6);
        $detail5->setPlat($plat);
        $detail5->setCommande($commande4);
        $manager->persist($detail5);

        //Buffalo chiken wrap
        $plat = $manager->getRepository(plat::class)->find(9);
        $detail6 = new detail();
        $detail6->setQuantite(12);
        $detail6->setPlat($plat);
        $detail6->setCommande($commande5);
        $manager->persist($detail6);


        $plat = $manager->getRepository(plat::class)->find(4);
        $detail7 = new detail();
        $detail7->setQuantite(2);
        $detail7->setPlat($plat);
        $detail7->setCommande($commande1);
        $manager->persist($detail7);
        

        $plat = $manager->getRepository(plat::class)->find(4);
        $detail8 = new detail();
        $detail8->setQuantite(3);
        $detail8->setPlat($plat);
        $detail8->setCommande($commande2);
        $manager->persist($detail8);
        
        $plat = $manager->getRepository(plat::class)->find(4);
        $detail9 = new detail();
        $detail9->setQuantite(3);
        $detail9->setPlat($plat);
        $detail9->setCommande($commande2);
        $manager->persist($detail9);

        $plat = $manager->getRepository(plat::class)->find(15);
        $detail10 = new detail();
        $detail10->setQuantite(3);
        $detail10->setPlat($plat);
        $detail10->setCommande($commande2);
        $manager->persist($detail10);

        $plat = $manager->getRepository(plat::class)->find(5);
        $detail11 = new detail();
        $detail11->setQuantite(3);
        $detail11->setPlat($plat);
        $detail11->setCommande($commande2);
        $manager->persist($detail11);

        $manager->flush();
    }
}

