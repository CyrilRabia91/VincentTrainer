<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use App\Entity\Chat;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LogsController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/inscription", name="subscribe")
     */
    public function subscribe(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder )
    {
        $user = new User();
        $user->setStatus("User");
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setBanned(0);
            $manager->persist($user);
            $manager->flush();

            $chat = new Chat();
            $chat->setUser($user);
            $chat->setTitle('Discussion');
            $manager->persist($chat);
            $manager->flush();
        }
        return $this->render('Logs/subscribe.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/information-suplementaire", name="aditionnal_information")
     */
    public function aditionnal_information()
    {
        return $this->render('Front/information.html.twig');
    }

}
