<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\EntityDao\PeriodoOficialDao;
use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;

class AccionPaoPeriodoOficialController extends Controller {

    public function mantenimientoPeriodoOficialAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $periodoOficialDao = new PeriodoOficialDao($this->getDoctrine());
        $combobox = $periodoOficialDao->obtenerTiposPeriodos();

        return $this->render('MinSalSidPlaPaoBundle:PeriodoPaoOficial:manttPerPaoOfi.html.twig'
                        , array('opciones' => $opciones, 'combotipoperiodos' => $combobox));
    }

    public function consultarPeriodoOficialJSONAction() {

        $periodoOficialDao = new PeriodoOficialDao($this->getDoctrine());
        $periodoOficial = new PeriodoOficial();

        $periodoOficial = $periodoOficialDao->getPeriodoOficial();

        $numfilas = count($periodoOficial);

        $aux = new PeriodoOficial();
        $i = 0;
        
        foreach ($periodoOficial as $aux) {
            $rows[$i]['id'] = $aux->getIdPerOfi();
            $rows[$i]['cell'] = array($aux->getIdPerOfi(),
                $aux->gettipPerioPerOfi()->getNomTipPer(),
                DATE_FORMAT($aux->getFechIniPerOfi(), 'd/m/Y'),
                DATE_FORMAT($aux->getFechFinPerOfi(), 'd/m/Y'),
                $aux->getActivoPerOfi()
            );
            if ($aux->getActivoPerOfi())
                $rows[$i]['cell'][4] = 'SI';
            else
                $rows[$i]['cell'][4] = 'NO';
            $i++;
        }

        if($numfilas!=0)
            $datos = json_encode($rows);
        else
            $datos='';


        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function manttPeriodoOficialAction() {
        $request = $this->getRequest();

        $codPerOfi = $request->get('id');
        $tipoPeriodoCodigo = $request->get('nombre');
        $dia=substr($request->get('fechini'),0,2);
        $mes=substr($request->get('fechini'),3,2);
        $anio=substr($request->get('fechini'),6,4);
        $fechIniPerOfi=$anio.'-'.$mes.'-'.$dia;
        $dia=substr($request->get('fechfin'),0,2);
        $mes=substr($request->get('fechfin'),3,2);
        $anio=substr($request->get('fechfin'),6,4);
        $fechFinPerOfi=$anio.'-'.$mes.'-'.$dia;
        if ($request->get('activo') == 'SI')
            $actPerOfi = true;
        else
            $actPerOfi = false;

        $anioPerOfi = 2011;
        
        $periodoOficialDao = new PeriodoOficialDao($this->getDoctrine());
        $operacion = $request->get('oper');

        switch ($operacion) {
            case 'add':
                $periodoOficialDao->agregarPeriodoOficial($tipoPeriodoCodigo, $fechIniPerOfi, $fechFinPerOfi, $anioPerOfi, $actPerOfi);
                break;
            case 'edit':
                $periodoOficialDao->editarPeriodoOficial($codPerOfi,$tipoPeriodoCodigo, $fechIniPerOfi, $fechFinPerOfi, $anioPerOfi, $actPerOfi);
                break;
            case 'del':
                $periodoOficialDao->eliminarPeriodoOficial($codPerOfi);
               break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
