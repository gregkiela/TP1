<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;
use App\Entity\Entreprise;

use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;

class TriFormationController extends AbstractController
{
    /**
     * @Route("/formations/{nom}", name="tri_formation")
     */
    public function index($nom,EntrepriseRepository $entrepriseRepository, FormationRepository $formationRepository,StageRepository $stageRepository, Formation $formation): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        //$formationRepository = $this->getDoctrine()->getRepository(Formation::class);
        //$entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        //$formation = $formationRepository->find($id);
        $stages = $stageRepository -> trouverStagesParFormation($nom);

        $donneesEntreprises = $entrepriseRepository->findAll();
        $donneesFormations = $formationRepository->findAll();

        return $this->render('tri_formation/index.html.twig', [
            'controller_name' => 'TriFormationController',
            'formation'=>$formation,'stages'=>$stages,
            'formations' => $donneesFormations,
            'entreprises' =>$donneesEntreprises,
        ]);
    }
}
