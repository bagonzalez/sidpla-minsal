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
        
        $periodoOficialDao=new PeriodoOficialDao($this->getDoctrine());
        $combobox=$periodoOficialDao->obtenerTiposPeriodos();
            
        return $this->render('MinSalSidPlaPaoBundle:PeriodoPaoOficial:manttPerPaoOfi.html.twig'
                        , array('opciones' => $opciones, 'combotipoperiodos'=> $combobox));
    }

   public function consultarPeriodoOficialJSONAction() {

       $periodoOficialDao=new PeriodoOficialDao($this->getDoctrine());
       $periodoOficial=new PeriodoOficial();
       
       $periodoOficial=$periodoOficialDao->getPeriodoOficial();
       
        $numfilas = count($periodoOficial);

        $aux = new PeriodoOficial();
        $i = 0;

        foreach ($periodoOficial as $aux) {
            $rows[$i]['id'] = $aux->getIdPerOfi();
            $rows[$i]['cell'] = array($aux->getIdPerOfi(),
                $aux->gettipPerioPerOfi()->getNomTipPer(),
                DATE_FORMAT($aux->getFechIniPerOfi(),'d/m/Y'),
                DATE_FORMAT($aux->getFechFinPerOfi(),'d/m/Y'),
                $aux->getActivoPerOfi()
            );
            if($aux->getActivoPerOfi())
                $rows[$i]['cell'][4]='SI';
            else
                $rows[$i]['cell'][4]='NO';
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
    
    public function manttPeriodoOficialAction() {
        $request = $this->getRequest();
        
        $codPerOfi=$request->get('id');
        $nomPerOfi=$request->get('nombre');
        $fechIniPerOfi=$request->get('fechini');
        $fechFinPerOfi=$request->get('fechfin');
        if($request->get('activo')=='SI')
                $actTipoPer=true;
            else
                $actTipoPer=false;
            
        $operacion = $request->get('oper');
        $anioPerOfi=2011;
        $tipoPeriodoDao=new TipoPeriodoDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                //$tipoPeriodoDao->editTipoPeriodo($codTipoPer, $nomTipoPer, $descTipoPer, $actTipoPer);
                break;
            case 'del':
              // $tipoPeriodoDao->delTipoPeriodo($codTipoPer);
                break;
            case 'add':
               // $tipoPeriodoDao->addTipoPeriodo($nomTipoPer, $descTipoPer, $actTipoPer);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
