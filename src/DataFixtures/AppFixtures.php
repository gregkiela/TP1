<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR');

        //GESTION DU NOMBRE D'ENTITE
        $nbEntreprises = 20;
        $nbFormations = 20;
        $nbStages = 30;


        /* GESTION DES ENTREPRISES */

        //Gestion du tableau
        $tabEntreprises = array();
        
        //Boucle création des entreprises
        for ($i=1; $i <= $nbEntreprises; $i++) 
        {             
            $entreprise = new Entreprise();

            $entreprise->setActivite("activité.$i");
            $entreprise->setAdresse("adresse.$i");
            $entreprise->setNom("nom.$i");
            $entreprise->setUrlSite("url.$i");

            array_push($tabEntreprises,$entreprise);

            $manager->persist($entreprise);
        }


        /* GESTION DES FORMATIONS */

        //Gestion du tableau
        $tabFormations = array();

        //Boucle création des formations
        for ($i=1; $i <= $nbFormations; $i++)
        {
            $formation = new Formation();
            $formation->setNomLong("nomLong.$i");
            $formation->setNomCourt("nomCourt.$i");

            array_push($tabFormations,$formation);

            $manager->persist($formation);
        }
        

        /* GESTION DES STAGES */

        //Gestion du tableau
        $tabStages = array();

        //Boucle création des stages
        for ($i=1; $i <= $nbStages; $i++)
        {
            $stage = new Stage();

            $stage->setTitre($faker->sentence(3));
            $stage->setDescription($faker->paragraph(1));
            $stage->setEmail($faker->freeEmail());

            $stage->setEntreprise($tabEntreprises[$faker->numberBetween(0,count($tabEntreprises)-1)]);

            $nbFormationStage = $faker->numberBetween(1,3);

            for ($j=0;$j<$nbFormationStage;$j++)
            {
                $stage->addFormation($tabFormations[$faker->numberBetween(0,count($tabFormations)-1)]);
            }

            $manager->persist($stage);
        }

        $manager->flush();
    }
}
