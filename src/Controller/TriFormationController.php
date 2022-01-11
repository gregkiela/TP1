<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;

class TriFormationController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="tri_formation")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesFormation = $formationRepository->find($id);
        $stages = $donneesFormation->getStage();

        return $this->render('tri_formation/index.html.twig', [
            'controller_name' => 'TriFormationController',
            'formation'=>$donneesFormation,'stages'=>$stages,
        ]);
    }
}
