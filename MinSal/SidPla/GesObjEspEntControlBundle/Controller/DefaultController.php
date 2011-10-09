<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:Default:index.html.twig', array('name' => $name));
    }
}
