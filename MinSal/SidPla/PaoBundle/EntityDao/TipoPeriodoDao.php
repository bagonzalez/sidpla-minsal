<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;
use Doctrine\ORM\Query\ResultSetMapping;

class TipoPeriodoDao {

    var $doctrine;
    var $repositorio;
    var $em;
//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPaoBundle:PaoTipoPeriodo');
    }

    /*
      Obtiene todos las notificaciones del sistema

     */

    public function getTipoPeriodo() {
        $tiposPeriodos = $this->repositorio->findAll();
        return  $tiposPeriodos;
    }

    /*
     * Agregar Notificacion del Sistema
     
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
    }*/


    /*
     * Elimina Notificacion del sistema
     

    public function delNotiSistema($codigo) {

        $notificacionSistema = $this->repositorio->find($codigo);

        if (!$notificacionSistema) {
            throw $this->createNotFoundException('No se encontro rol con ese id ' . $codigo);
        }

        $this->em->remove($notificacionSistema);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }*/

    /*
     * Actualiza Notificacion Sistema
    

    public function editNotiSistema($codigo, $nombreNoti, $mensajeNoti, $tipoMensajeNoti) {

        $notificacionSistema = $this->repositorio->find($codigo);

        if (!$notificacionSistema) {
            throw $this->createNotFoundException('No se encontro rol con ese id ' . $codigo);
        }
        
        $notificacionSistema->setMensajeNoti($mensajeNoti);
        $notificacionSistema->setNombreNoti($nombreNoti);
        $notificacionSistema->setTipoMensajeNoti($tipoMensajeNoti);

        $this->em->flush();
        $matrizMensajes = $codigo;
    
            return $matrizMensajes;
        } */

}

?>

