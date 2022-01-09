<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DescriptionEntrepriseController extends AbstractController
{
    /**
     * @Route("/description/entreprise/{id}", name="description_entreprise")
     */
    public function index($id): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprise = $entrepriseRepository->find($id);

        return $this->render('description_entreprise/index.html.twig', [
            'controller_name' => 'DescriptionEntrepriseController','entreprise'=>$donneesEntreprise,
        ]);
    }
}
