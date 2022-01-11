<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Stage;

class TriEntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="tri_entreprise")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprise = $entrepriseRepository->find($id);
        $stages = $donneesEntreprise->getStage();

        return $this->render('tri_entreprise/index.html.twig', [
            'controller_name' => 'TriEntrepriseController',
            'entreprise'=>$donneesEntreprise, 'stages'=>$stages,
        ]);
    }
}
