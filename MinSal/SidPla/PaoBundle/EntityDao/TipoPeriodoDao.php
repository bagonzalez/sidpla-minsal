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
     * Agregar Tipo Perido 
     */
     
    public function addNotiSistema($nomTipPer, $descTipPer, $activoTipPer) {

        $tipoPeriodo= new TipoPeriodo();
        
        $tipoPeriodo->setActivoTipPer($activoTipPer);
        $tipoPeriodo->setDescTipPer($descTipPer);
        $tipoPeriodo->setNomTipPer($nomTipPer);
        $tipoPeriodo->setUsuarioTipPer(true);

      
        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }


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

