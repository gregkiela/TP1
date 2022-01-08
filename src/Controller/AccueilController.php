<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);
        $stageRepository = $this->getDoctrine()->getRepository(Stage::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprises = $entrepriseRepository->findAll();
        $donneesFormations = $formationRepository->findAll();
        $donneesStages = $stageRepository->findAll();

        //Envoyer les données récupérées
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'entreprises' => $donneesEntreprises,
            'formations' => $donneesFormations,
            'stages' => $donneesStages
        ]);
    }
}
