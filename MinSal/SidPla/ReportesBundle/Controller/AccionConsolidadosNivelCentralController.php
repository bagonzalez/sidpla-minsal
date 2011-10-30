<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionConsolidadosNivelCentralController
 *
 * @author edwin
 */
namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccionConsolidadosNivelCentralController extends Controller {
    
    public function showConsolidadosNivelCentralAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaReportesBundle:Consolidados:reportConsolidosPersonalizados.html.twig', array('opciones' => $opciones));
    }
    
}

?>
