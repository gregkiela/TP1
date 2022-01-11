<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function index(): Response
    {
        //Récupérer le repository de nos entités Entreprise, Formation et Stage
        $entrepriseRepository = $this->getDoctrine()->getRepository(Entreprise::class);

        //Récupérer les donneées stockés dans notre base;
        $donneesEntreprises = $entrepriseRepository->findAll();

        return $this->render('entreprises/index.html.twig', [
            'controller_name' => 'EntreprisesController',
            'entreprises' => $donneesEntreprises,
        ]);
    }
}
