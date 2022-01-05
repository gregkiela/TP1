<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Création d'un générateur de données faker
        $faker = \Faker\Factory::create('fr_FR');

        $nbElements = 20;

        for ($i=1; $i <= $nbElements; $i++) 
        {             
            $entreprise1 = new Entreprise();
            $entreprise1->setActivite("truc");
            $entreprise1->setAdresse("truc");
            $entreprise1->setNom("truc");
            $entreprise1->setUrlSite("truc");
            $manager->persist($entreprise1);


            $formation1 = new Formation();
            $formation1->setNomLong("truc");
            $formation1->setNomCourt("truc");
            $manager->persist($formation1);


            $stage1 = new Stage();
            $entreprise1 = new Entreprise();
            $stage1->setTitre($faker->sentence(3));
            $stage1->setDescription($faker->paragraph(2));
            $stage1->setEmail($faker->freeEmail());
            $stage1->setEntreprise($entreprise1);
            $manager->persist($stage1);
        }

        $manager->flush();
    }
}
