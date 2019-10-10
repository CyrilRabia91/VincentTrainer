<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class GlobalController extends AbstractController
{
    /**
     * @Route("/ajax_send_msg", name="ajax_send_msg")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajax_send_msg(Request $request)
    {
        $html = "";
        if (!$user=$this->getUser())
            return new JsonResponse(['html'=>$html,'status'=>"Error"]);

        $value = $request->request->get('value');
        $status = $request->request->get('status');
        $content = $request->request->get('content');
        $date = new \DateTime('now');
        $chat = $this->getDoctrine()->getRepository('App:Chat')->find($value);

        $em = $this->getDoctrine()->getManager();
        $msg = new Message();
        $msg->setDate($date);
        $msg->setContent($content);
        $msg->setChat($chat);
        $msg->setStatus($status);

        $em->persist($msg);
        $em->flush();

        $messages = $this->getDoctrine()->getRepository('App:Message')->findBy(['chat'=>$value]);

        return new JsonResponse(['html'=>$html,'status'=>200]);
    }
}
