<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function principalAction()
    {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaEstInfraBundle:Default:manttElementoInfra_UnidadMedida.html.twig'
                         , array('opciones' => $opciones));
    }
}
