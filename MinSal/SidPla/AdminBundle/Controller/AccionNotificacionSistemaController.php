<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\AdminBundle\EntityDao\NotificacionSistemaDao;
use MinSal\SidPla\AdminBundle\Entity\NotificacionSistema;

class AccionNotificacionSistemaController extends Controller {

    public function mantenimientoNotificacionAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaAdminBundle:NotificacionSistema:showNotificacionSistema.html.twig'
                        , array('opciones' => $opciones));
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

         if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ');
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function manttNotificacionEdicionAction() {
        $request = $this->getRequest();

        $nombreNoti=$request->get('nombre');
        $mensajeNoti=$request->get('mensaje');
        $tipoMensajeNoti = $request->get('tipomensaje');
        $codigo = $request->get('id');

        $operacion = $request->get('oper');

        $notificacionSistemaDao = new NotificacionSistemaDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $notificacionSistemaDao->editNotiSistema($codigo,$nombreNoti,$mensajeNoti,$tipoMensajeNoti);
                break;
            case 'del':
               $notificacionSistemaDao->delNotiSistema($codigo);
                break;
            case 'add':
                $notificacionSistemaDao->addNotiSistema($nombreNoti, $tipoMensajeNoti,$mensajeNoti);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
