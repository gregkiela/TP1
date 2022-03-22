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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function inscription(Request $requetteHttp, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $formulaireUser = $this -> createForm(UserType::class, $user);
        
        $formulaireUser->handleRequest($requetteHttp);
                        
        if($formulaireUser->isSubmitted()&&$formulaireUser->isValid())
        {
            //Atribuer un rôle à l'utilisateur
            $user->setRoles(['ROLES_USER']);

            //Encoder le mot de passe de l'utilisateur
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodagePassword);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_login');
        }


        return $this->render('security/inscription.html.twig',['vueFormulaire' => $formulaireUser->createView()]);
    }
}
