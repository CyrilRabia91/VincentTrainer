<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
