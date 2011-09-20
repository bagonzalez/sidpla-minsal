<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\EstInfraBundle\EntityDao\UnidadMedidaDao;


class DefaultController extends Controller
{
    
    public function principalAction()
    {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $unidadMedidadDao= new UnidadMedidaDao($this->getDoctrine());
        $comboUniMed=$unidadMedidadDao->obtenerUnidadMedida();
        
        return $this->render('MinSalSidPlaEstInfraBundle:Default:manttElementoInfra_UnidadMedida.html.twig'
                         , array('opciones' => $opciones,'comboUniMed'=>$comboUniMed));
    }
}
