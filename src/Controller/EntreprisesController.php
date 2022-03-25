<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use App\Repository\StageRepository;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;

use Doctrine\ORM\EntityManagerInterface;

/**
     * @Route("/entreprise")
*/

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/", name="entreprises")
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

    /**
     * @Route("/ajout", name="formulaireEntreprise")
     */
    public function ajouterEntreprise(Request $requetteHttp, EntityManagerInterface $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this -> createForm(EntrepriseType::class, $entreprise);
        
        $formulaireEntreprise->handleRequest($requetteHttp);
                        
        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        $vueFormulaireEntreprise = $formulaireEntreprise->createView();

        return $this->render('entreprises/ajoutModifEntreprise.html.twig',['vueFormulaireEntreprise' => $vueFormulaireEntreprise,'action'=>"Ajouter"]);
    }

    /**
     * @Route("/modifier/{id}", name="modifFormulaire")
     */
    public function modifierEntreprise(Request $requetteHttp, EntityManagerInterface $manager, Entreprise $entreprise)
    {
        $formulaireEntreprise = $this -> createForm(EntrepriseType::class, $entreprise);        

        $formulaireEntreprise->handleRequest($requetteHttp);
                        
        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('accueil');
        }

        $vueFormulaireEntreprise = $formulaireEntreprise->createView();

        return $this->render('entreprises/ajoutModifEntreprise.html.twig',['vueFormulaireEntreprise' => $vueFormulaireEntreprise,'action'=>"Modifier"]);
    }

    /**
     * @Route("/{nom}", name="tri_entreprise")
     */
    public function tri($nom, EntrepriseRepository $entrepriseRepository, FormationRepository $formationRepository, StageRepository $stageRepository, Entreprise $entreprise): Response
    {
        $stages = $stageRepository -> trouverStagesParEntreprise($nom);

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
