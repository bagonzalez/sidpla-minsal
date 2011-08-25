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

    public function ingresoNuevaUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', array('opciones' => $opciones,));
    }

    public function ingresarUnidadOrgAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $nombreUnidad = $request->get('nombreUnidad');
        $direccion = $request->get('direccion');
        $responsable = $request->get('responsable');
        $telefono = $request->get('telefono');
        $fax = $request->get('fax');
        $tipoUnidad = $request->get('tipoUnidad');
        $unidadPadre = $request->get('unidadPadre');





        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', array('opciones' => $opciones,));
    }

}

?>
