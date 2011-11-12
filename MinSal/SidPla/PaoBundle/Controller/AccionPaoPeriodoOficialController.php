<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\PaoBundle\EntityDao\PeriodoOficialDao;
use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;

use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ActividadUnisalTemplateDao;

use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ResEspTemplateDao;
use MinSal\SidPla\PaoBundle\EntityDao\PaoDao;

class AccionPaoPeriodoOficialController extends Controller {

    public function consultarPeriodoOficialJSONAction() {

        $periodoOficialDao = new PeriodoOficialDao($this->getDoctrine());
        $periodoOficial = new PeriodoOficial();
        $anio=$this->getRequest()->get('anio');
        
        if ($periodoOficialDao->existePeriodoOfi($anio)==0)
            $periodoOficialDao->crearPeriodoOficial ($anio);
            
        $periodoOficial = $periodoOficialDao->getPeriodoOficial($anio);
        

        $numfilas = count($periodoOficial);

        $aux = new PeriodoOficial();
        $i = 0;
        
        foreach ($periodoOficial as $aux) {
            $rows[$i]['id'] = $aux->getIdPerOfi();
            $rows[$i]['cell'] = array($aux->getIdPerOfi(),
                $aux->gettipPerioPerOfi()->getNomTipPer(),
                $aux->getFechIniPerOfi(),
                $aux->getFechFinPerOfi(),
                $aux->getActivoPerOfi()
            );
            if ($aux->getActivoPerOfi())
                $rows[$i]['cell'][4] = 'SI';
            else
                $rows[$i]['cell'][4] = 'NO';
            
            if ($aux->getFechFinPerOfi()!=null)
                $rows[$i]['cell'][3]=DATE_FORMAT($aux->getFechFinPerOfi(), 'd/m/Y');
                        
            if ($aux->getFechIniPerOfi()!=null)
                $rows[$i]['cell'][2]=DATE_FORMAT($aux->getFechIniPerOfi(), 'd/m/Y');
            
            if ($aux->getFechIniPerOfi()==null or $aux->getFechFinPerOfi()==null)
                $rows[$i]['cell'][5]=1;
            else
                $rows[$i]['cell'][5]=2;
            
            $i++;
        }

       if ($numfilas != 0){
            array_multisort($rows,SORT_ASC);
        }
        else{
            $rows[0]['id']=0;
            $rows[0]['cell']=array(' ',' ',' ',' ',' ');
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
    
    public function crearPaoAction() {
        $anio=$this->getRequest()->get('anio');
        $periodoOficialDao = new PeriodoOficialDao($this->getDoctrine());
        $msj=$periodoOficialDao->crearPao($anio);
        
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $mostrarboton=FALSE;
        
       return $this->render('MinSalSidPlaPaoBundle:CrearPao:manttCrearPao.html.twig'
                        , array('opciones' => $opciones,'mostrarboton'=>$mostrarboton,'msj'=>$msj));

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

       $anioPerOfi=$this->getRequest()->get('anio');
        
        if($anioPerOfi==0)
            $anioPerOfi=date("Y");
        
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
    
     public function manttCrearPaosAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $anio=date('Y')+1;
        
        //Para saber Si ya esta definido el Cronograma de la PAO en elaboracion
        $cronogramaDao= new PeriodoOficialDao($this->getDoctrine());
        $bc=$cronogramaDao->cuantasFechasNoDefinidas($anio);
        
        //Para saber si ya se definieron actividades en la Plantilla de Actividades para Unidades de Salud
        $actividadTemplateDao= new ActividadUnisalTemplateDao($this->getDoctrine());
        $ba=$actividadTemplateDao->cuantasActDefinidas($anio);
        
        //Para saber si ya se definieron resultados esperados de la Plantilla para SIBASI y Regiones de Salud
        $resulTemplateDao = new ResEspTemplateDao($this->getDoctrine());
        $bec=$resulTemplateDao->cuantosResulDefinidas((string) ($anio));
        
        $paoDao=new PaoDao($this->getDoctrine());
        $bp=$paoDao->existenPaos($anio);
        
        if($bc!=0)
            $mostrarboton=FALSE;
        else
            if($ba==0)
                $mostrarboton=FALSE;
            else
                if($bec==0)
                    $mostrarboton=FALSE;
                else
                    if($bp!=0){
                        $mostrarboton=FALSE;
                        $msj="LA PAO PARA ESTE ANIO (".$anio.") YA HA SIDO CREADA";
                    }
                    else
                        $mostrarboton=TRUE;
                    
            
        if(isset($msj))
         return $this->render('MinSalSidPlaPaoBundle:CrearPao:manttCrearPao.html.twig'
                        , array('opciones' => $opciones,'mostrarboton'=>$mostrarboton,'msj'=>$msj));
        else
            return $this->render('MinSalSidPlaPaoBundle:CrearPao:manttCrearPao.html.twig'
                        , array('opciones' => $opciones,'mostrarboton'=>$mostrarboton));
    }

}

?>
