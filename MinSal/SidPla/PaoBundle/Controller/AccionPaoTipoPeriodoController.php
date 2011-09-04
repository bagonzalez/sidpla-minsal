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
        
        //$notificacionDao = new NotificacionSistemaDao($this->getDoctrine());
        

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
                $aux->getUsuarioTipPer(),
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

    public function manttTipoPeriodoAction() {
        $request = $this->getRequest();
        
        $codigoTipoPeriodo = $request->get('id');
        $nombreTipoPeriodo=$request->get('nombre');
        $nombreTipoPeriodo=$request->get('usuario');
        $nombreTipoPeriodo=$request->get('activo');
        

        $operacion = $request->get('oper');

        //$notificacionSistemaDao = new NotificacionSistemaDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
               // $notificacionSistemaDao->editNotiSistema($codigo,$nombreNoti,$mensajeNoti,$tipoMensajeNoti);
                break;
            case 'del':
               //$notificacionSistemaDao->delNotiSistema($codigo);
                break;
            case 'add':
                //$notificacionSistemaDao->addNotiSistema($nombreNoti, $tipoMensajeNoti,$mensajeNoti);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
