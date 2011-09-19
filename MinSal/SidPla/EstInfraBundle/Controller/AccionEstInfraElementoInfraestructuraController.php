<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\EstInfraBundle\EntityDao\ElementoInfraestructuraDao;
use MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura;

class AccionEstInfraElementoInfraestructuraController extends Controller {

    public function mantenimientoElementoInfraestructuraAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaEstInfraBundle:ElementoInfraestructura:manttElementoInfraestructura.html.twig'
                        , array('opciones' => $opciones));
  
       // return new Response("hola kren hohohohohohohoho ");
    }

    public function consultarElementoInfraestructuraJSONAction() {

        $ElementoInfraestructuraDao=new ElementoInfraestructuraDao($this->getDoctrine());
        $ElementoInfraestructura=$ElementoInfraestructuraDao->getElementoInfraestructura();
        

        $numfilas = count($ElementoInfraestructura);

        $aux = new ElementoInfraestructura();
        $i = 0;

        foreach ($ElementoInfraestructura as $aux) {
            $rows[$i]['id'] = $aux->getIdElemInfra();
            $rows[$i]['cell'] = array($aux->getIdElemInfra(),
                $aux->getNomElemInfra(),
                $aux->getElemInfraDescrip(),
                $aux->getCodUnidadMed()->getNomUnidMed()
                             
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
/*
    public function manttTipoPeriodoAction() {
        $request = $this->getRequest();
        
        $codTipoPer=$request->get('id');
        $nomTipoPer=$request->get('nombre');
        $descTipoPer=$request->get('descripcion');
        if($request->get('activo')=='SI')
                $actTipoPer=true;
            else
                $actTipoPer=false;
            
        $operacion = $request->get('oper');

        $tipoPeriodoDao=new TipoPeriodoDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $tipoPeriodoDao->editTipoPeriodo($codTipoPer, $nomTipoPer, $descTipoPer, $actTipoPer);
                break;
            case 'del':
               $tipoPeriodoDao->delTipoPeriodo($codTipoPer);
                break;
            case 'add':
                $tipoPeriodoDao->addTipoPeriodo($nomTipoPer, $descTipoPer, $actTipoPer);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }
*/
}

?>

