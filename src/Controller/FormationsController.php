<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations", name="formations")
     */
    public function index(): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesFormations = $formationRepository->findAll();

        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',          
            'formations' => $donneesFormations,
        ]);
    }
}
