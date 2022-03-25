<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Stage;
use App\Form\StageType;

use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

use Doctrine\ORM\EntityManagerInterface;

/**
     * @Route("/stage")
     */

class StagesController extends AbstractController
{
    /**
     * @Route("/{id}", name="stage")
     */
    public function index(EntrepriseRepository $entrepriseRepository, FormationRepository $formationRepository, Stage $donneesStage): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        //$stageRepository = $this->getDoctrine()->getRepository(Stage::class);
        //$formationRepository = $this->getDoctrine()->getRepository(Formation::class);
        //$entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        $entreprise = $donneesStage->getEntreprise();
        $formations = $donneesStage->getFormation();
        $donneesFormations = $formationRepository->findAll();
        $donneesEntreprises = $entrepriseRepository->findAll(); 

        return $this->render('stages/index.html.twig', [
            'controller_name' => 'StagesController',
            'stage'=>$donneesStage,'entreprise'=>$entreprise,
            'formationsStage'=>$formations,
            'formations' => $donneesFormations,
            'entreprises' =>$donneesEntreprises,
        ]);
    }

    /**
     * @Route("/ajouter", name="formulaireStage")
     */
    public function ajouterStage(Request $requetteHttp, EntityManagerInterface $manager)
    {
        $stage = new Stage();

        $formulaireStage = $this -> createForm(StageType::class, $stage);
        
        $formulaireStage->handleRequest($requetteHttp);
                        
        if($formulaireStage->isSubmitted()&&$formulaireStage->isValid())
        {
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        $vueFormulaireStage = $formulaireStage->createView();

        return $this->render('stages/ajoutModifStage.html.twig',['vueFormulaireStage' => $vueFormulaireStage,'action'=>"Ajouter"]);
    }

}
