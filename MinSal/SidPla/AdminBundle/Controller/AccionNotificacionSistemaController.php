<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\AdminBundle\EntityDao\NotificacionSistemaDao;
use MinSal\SidPla\AdminBundle\Entity\NotificacionSistema;

class AccionNotificacionSistemaController extends Controller {

    public function consultarNotificacionAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $notificacionDao = new NotificacionSistemaDao($this->getDoctrine());
        $notificacion = $notificacionDao->getNotiSistema();

        return $this->render('MinSalSidPlaAdminBundle:NotificacionSistema:showNotificacionSistema.html.twig'
                        , array('opciones' => $opciones, 'notificaciones' => $notificacion));
    }

    public function consultarNotificacionJSONAction() {

        $notificacionDao = new NotificacionSistemaDao($this->getDoctrine());
        $notificacion = $notificacionDao->getNotiSistema();

        $numfilas = count($notificacion);

        $aux = new NotificacionSistema();
        $i = 0;

        foreach ($notificacion as $aux) {
            $rows[$i]['id'] = $aux->getCodNoti();
            $rows[$i]['cell'] = array($aux->getCodNoti(),
                $aux->getNombreNoti(),
                $aux->getMensajeNoti(),
                $aux->getTipoMensajeNoti()
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
    public function manttNotificacionEdicionAction() {
        $request = $this->getRequest();

        $nombrenoti=$request->get('nombre');
        $mensajenoti=$request->get('mensaje');
        $tipomensajenoti = $request->get('tipomensaje');
        $codigonoti = $request->get('codigo');

        $operacion = $request->get('oper');

        $NotificacionSistemaDao = new NotificacionSistemaDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $rolDao->editRol($nombreRol, $funciones, $id);
                break;
            case 'del':
                $rolDao->delRol($id);
                break;
            case 'add':
                $NotificacionSistemaDao->addNotiSistema($nombrenoti, $tipomensajenoti,$mensajenoti);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }*/

}

?>
