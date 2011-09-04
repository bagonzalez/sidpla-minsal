<?php

namespace MinSal\SidPla\CensoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');        
        return $this->render('MinSalSidPlaCensoBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
