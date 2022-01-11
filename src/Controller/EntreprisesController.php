<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function index(EntrepriseRepository $entrepriseRepository, FormationRepository $formationRepository): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        //$entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);
        //$formationRepository = $this->getDoctrine()->getRepository(Formation::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprises = $entrepriseRepository->findAll();
        $donneesFormations = $formationRepository->findAll();

        return $this->render('entreprises/index.html.twig', [
            'controller_name' => 'EntreprisesController',
            'entreprises' => $donneesEntreprises,
            'formations' => $donneesFormations,
        ]);
    }
}
