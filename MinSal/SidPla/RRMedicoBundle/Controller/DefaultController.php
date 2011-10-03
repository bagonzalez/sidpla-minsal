<?php

namespace MinSal\SidPla\RRMedicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MinSalSidPlaRRMedicoBundle:Default:index.html.twig', array('name' => $name));
    }
}
