<?php

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaGesObjEspBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
