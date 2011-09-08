<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;
//use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;

class AccionPaoTipoPeriodoController extends Controller {

    public function mantenimientoTipoPeriodoAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaPaoBundle:TipoPeriodoPao:manttTipoPeriodo.html.twig'
                        , array('opciones' => $opciones));
        
    }

    public function consultarTipoPeriodoJSONAction() {

        $tipoPeriodoDao=new TipoPeriodoDao($this->getDoctrine());
        $tipoPeriodo =$tipoPeriodoDao->getTipoPeriodo();
        

        $numfilas = count($tipoPeriodo);

        $aux = new TipoPeriodo();
        $i = 0;

        foreach ($tipoPeriodo as $aux) {
            $rows[$i]['id'] = $aux->getIdTipPer();
            $rows[$i]['cell'] = array($aux->getIdTipPer(),
                $aux->getNomTipPer(),
                $aux->getActivoTipPer()
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

    
    //Para agregar el Tipo Periodo en otra Pagina
     public function ingresarTipoPeriodoAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones'); 
        
        return $this->render('MinSalSidPlaPaoBundle:TipoPeriodoPao:ingresarTipoPeriodo.html.twig', 
                    array('opciones' => $opciones));       
    }
    
public function addTipoPeriodoAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones'); 
        $request=$this->getRequest();
        
        $nombreTipoPeriodo=$request->get('nombreTipoPeriodo');
        $descTipoPeriodo=$request->get('descTipoPeriodo');
       
        $tipoPeriodoDao=new TipoPeriodoDao($this->getDoctrine());
        $tipoPeriodoDao->addTipoPeriodo($nombreTipoPeriodo, $descTipoPeriodo);
                    
        return $this->render('MinSalSidPlaPaoBundle:TipoPeriodoPao:manttTipoPeriodo.html.twig'
                        , array('opciones' => $opciones));
              
     }

}

?>
