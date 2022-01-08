<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Stage;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="entreprises")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);
        $stageRepository = $this->getDoctrine()->getRepository(Stage::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprises = $entrepriseRepository->findAll();
        $donneesStages = $stageRepository->findAll();

        return $this->render('entreprises/index.html.twig', [
            'controller_name' => 'EntreprisesController','id'=>$id,
            'entreprises' => $donneesEntreprises,
            'stages' => $donneesStages,
        ]);
    }
}
