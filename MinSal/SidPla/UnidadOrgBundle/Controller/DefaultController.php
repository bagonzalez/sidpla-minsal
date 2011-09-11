<?php

namespace MinSal\SidPla\UnidadOrgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaUnidadOrgBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
