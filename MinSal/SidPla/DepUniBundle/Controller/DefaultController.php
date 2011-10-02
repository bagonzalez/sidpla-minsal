<?php

namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function principalAction()
    {
        $opciones = $this->getRequest()->getSession()->get('opciones');
              
        return $this->render('MinSalSidPlaDepUniBundle:Default:manttDeptoHumano_RRHH.html.twig'
                         , array('opciones' => $opciones));
    }
}
