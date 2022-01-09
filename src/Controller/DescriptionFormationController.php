<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;

class DescriptionFormationController extends AbstractController
{
    /**
     * @Route("/description/formation/{id}", name="description_formation")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesFormations = $formationRepository->find($id);

        return $this->render('description_formation/index.html.twig', [
            'controller_name' => 'DescriptionFormationController',
            'formation'=>$donneesFormations,
        ]);
    }
}
