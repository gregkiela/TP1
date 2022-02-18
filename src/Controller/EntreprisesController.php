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
use App\Entity\Entreprise;

use Doctrine\ORM\EntityManagerInterface;

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

    /**
     * @Route("/ajoutEntreprise", name="formulaireEntreprise")
     */
    public function ajouterEntreprise(Request $requetteHttp, EntityManagerInterface $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                        ->add('nom', TextType::class)
                                        ->add('activite', TextareaType::class)
                                        ->add('adresse',TextType::class)
                                        ->add('urlSite',UrlType::class)
                                        ->getForm();
        

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
     * @Route("/modifierEntreprise/{id}", name="modifFormulaire")
     */
    public function modifierEntreprise(Request $requetteHttp, EntityManagerInterface $manager, Entreprise $entreprise)
    {
        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                        ->add('nom', TextType::class)
                                        ->add('activite', TextareaType::class)
                                        ->add('adresse',TextType::class)
                                        ->add('urlSite',UrlType::class)
                                        ->getForm();
        

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
}
