<?php

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\NotificacionSistema;

class NotificacionSistemaDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaAdminBundle:NotificacionSistema');
    }

    /*
      Obtiene todos las notificaciones del sistema

     */

    public function getNotiSistema() {
        $notificaciones = $this->repositorio->findAll();
        return $notificaciones;
    }

    public function addNotiSistema($nombreNoti, $tipoMensajeNoti, $mensajeNoti) {

        $notificacionsistema = new NotificacionSistema();
        
        $notificacionsistema->setNombreNoti($nombreNoti);
        $notificacionsistema->setTipoMensajeNoti($tipoMensajeNoti);
        $notificacionsistema->setMensajeNoti($mensajeNoti);
             
        $this->em->persist($notificacionsistema);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar notificacion del sistema termino con exito',
            'Notificacion Sistema' . $notificacionsistema->getCodNoti());

        return $matrizMensajes;
    }

}

?>
