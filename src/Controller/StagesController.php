<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;

class StagesController extends AbstractController
{
    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $stageRepository = $this->getDoctrine()->getRepository(Stage::class);
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesStage = $stageRepository->find($id);
        $entreprise = $donneesStage->getEntreprise();
        $formations = $donneesStage->getFormation();
        $donneesFormations = $formationRepository->findAll();
        $donneesEntreprises = $entrepriseRepository->findAll(); 

        return $this->render('stages/index.html.twig', [
            'controller_name' => 'StagesController','id'=>$id,
            'stage'=>$donneesStage,'entreprise'=>$entreprise,
            'formationsStage'=>$formations,
            'formations' => $donneesFormations,
            'entreprises' =>$donneesEntreprises,
        ]);
    }
}
