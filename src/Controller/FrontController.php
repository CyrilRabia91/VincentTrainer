<?php

namespace App\Controller;

use App\Entity\OptionSite;
use App\Entity\Opinion;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('app_login');
    }



    /**
     * @Route("/front_search_property", name="front_search_property")
     * @param Request $request
     * @return JsonResponse
     */
    public function front_search_property(Request $request)
    {


        $messages = $this->getDoctrine()->getRepository('App:Message')->findBy(['chat'=>$id]);

        $html = $this->container->get('twig')->render('Message/messages_user.html.twig',['messages'=>$messages]);

        return new JsonResponse(json_encode(
            $html
        ), 200);
    }


}
