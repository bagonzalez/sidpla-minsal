<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{    
    public function indexAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');        
        return $this->render('MinSalSidPlaAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
        //return $this->render('MinSalSidPlaAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
