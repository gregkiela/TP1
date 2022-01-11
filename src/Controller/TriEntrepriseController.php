<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Formation;
use App\Entity\Entreprise;

class TriEntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="tri_entreprise")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);
        $formationRepository = $this->getDoctrine()->getRepository(Formation::class);

        //Récupérer les donneées stockés dans notre base;
        $entreprise = $entrepriseRepository->find($id);
        $stages = $entreprise->getStage();

        $donneesEntreprises = $entrepriseRepository->findAll();
        $donneesFormations = $formationRepository->findAll();

        return $this->render('tri_entreprise/index.html.twig', [
            'controller_name' => 'TriEntrepriseController',
            'entreprise'=>$entreprise, 'stages'=>$stages,
            'formations' => $donneesFormations,
            'entreprises' =>$donneesEntreprises,
        ]);
    }
}
