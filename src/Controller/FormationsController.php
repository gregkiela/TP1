<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;
use App\Entity\Stage;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="formations")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);
        $stageRepository = $this->getDoctrine()->getRepository(Stage::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesFormations = $formationRepository->find($id);
        $stages = $donneesFormations->getStage();

        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController','id'=>$id,            
            'formations' => $donneesFormations,
            'stages' => $stages,
        ]);
    }
}
