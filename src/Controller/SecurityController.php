<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

    }
    
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscription(Request $requetteHttp, EntityManagerInterface $manager)
    {
        $user = new User();

        $formulaireUser = $this -> createForm(UserType::class, $user);
        
        $formulaireUser->handleRequest($requetteHttp);
                        
        if($formulaireUser->isSubmitted()&&$formulaireUser->isValid())
        {
            // $manager->persist($user);
            // $manager->flush();

            return $this->redirectToRoute('accueil');
        }


        return $this->render('security/inscription.html.twig',['vueFormulaire' => $formulaireUser->createView()]);
    }
}
