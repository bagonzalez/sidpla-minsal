<?php

namespace MinSal\SidPla\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();        
        $opciones=$sesion->get('opciones');
        return $this->render('MinSalSidPlaAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
