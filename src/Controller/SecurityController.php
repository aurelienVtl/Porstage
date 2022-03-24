<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\UserType;
use App\Entity\User;
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
         if ($this->getUser()) {
             return $this->redirectToRoute('accueil');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/Login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


	/**
     * @Route("/inscription", name="app_register")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        //creer utilisateur
        $user = new User(); 

        $formulaireUtilisateur = $this->createForm(UserType::class,$user);
        $formulaireUtilisateur->handleRequest($request);
        if($formulaireUtilisateur ->isSubmitted()&& $formulaireUtilisateur->isValid()){
			
			$user->setRoles(['ROLE_USER']);
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodagePassword);
			$manager->persist($user);
			$manager->flush();
            return $this->redirectToRoute('accueil');
        }

        return $this->render('security/inscription.html.twig', ['vueFormulaire' => $formulaireUtilisateur -> createView()]);
    
    }



    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
