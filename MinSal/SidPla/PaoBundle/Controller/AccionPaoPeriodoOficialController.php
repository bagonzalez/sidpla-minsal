<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
Use MinSal\SidPla\PaoBundle\EntityDao\PeriodoOficialDao;
Use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;

class AccionPaoPeriodoOficialController extends Controller {

    public function mantenimientoPeriodoOficialAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
          return $this->render('MinSalSidPlaPaoBundle:PeriodoPaoOficial:manttPerPaoOfi.html.twig'
                        , array('opciones' => $opciones));
    }

   public function consultarPeriodoOficialJSONAction() {

       $periodoOficialDao=new PeriodoOficialDao($this->getDoctrine());
       $periodoOficial=$periodoOficialDao->getPeriodoOficial();
       
        $numfilas = count($periodoOficial);

        $aux = new PeriodoOficial();
        $i = 0;

        foreach ($periodoOficial as $aux) {
            $rows[$i]['id'] = $aux->getIdPerOfi();
            $rows[$i]['cell'] = array($aux->getIdPerOfi(),
                $aux->gettipPerioPerOfi()->getIdTipPer(),
                $aux->getFechIniPerOfi(),
                $aux->getFechFinPerOfi(),
                $aux->getActivoPerOfi()
            );
            $i++;
        }

        $datos = json_encode($rows);


        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

}

?>
