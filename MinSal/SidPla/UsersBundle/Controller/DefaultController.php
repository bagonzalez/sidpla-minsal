<?php

namespace MinSal\SidPla\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MinSalSidPlaUsersBundle:Default:index.html.twig', array('name' => $name));
    }
}
