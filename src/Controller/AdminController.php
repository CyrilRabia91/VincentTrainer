<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    function logsAdmin(){
        $valid = true;
        if ($user = $this->getUser())
            if($user->getStatus() == "Admin")
                $valid = false;

        return $valid;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        if ( $this->logsAdmin())
            return $this->redirectToRoute('home');

        $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        $chats = $this->getDoctrine()->getRepository('App:Chat')->findAll();
        $messages = $this->getDoctrine()->getRepository('App:Message')->findAll();

        $stats = ['user'=>sizeof($users),'chat'=>sizeof($chats),'msg'=>sizeof($messages)];

        return $this->render('admin/index.html.twig', ['stats'=>$stats]);
    }

    /**
     * @Route("/admin/utilisateurs", name="users")
     */
    public function showUser()
    {
        if ( $this->logsAdmin())
            return $this->redirectToRoute('home');

        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        return $this->render('admin/User/users.html.twig', ['users'=>$users]);
    }

    /**
     * @Route("/admin/messagerie", name="chat")
     */
    public function showChat()
    {
        if ( $this->logsAdmin())
            return $this->redirectToRoute('home');


        return $this->render('admin/Chat/chat.html.twig', []);
    }

    /**
     * @Route("/admin/calendrier", name="calendar")
     */
    public function showCalendar()
    {
        if ( $this->logsAdmin())
            return $this->redirectToRoute('home');


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
    * @Route("/ajax_search_user", name="ajax_search_user")
    * @param Request $request
    * @return JsonResponse
    */

    public function ajax_search_user(Request $request)
    {

        $value = $request->request->get('value');
        if (empty($value))
            $users = $this->getDoctrine()->getRepository('App:User')->findAll();
        else
            $users = $this->getDoctrine()->getRepository('App:User')->search($value);

        $html = $this->renderView('admin/User/list-users.html.twig',['users'=>$users]);

        return new JsonResponse(['html'=>$html,'status'=>200]);
    }
}
