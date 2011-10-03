<?php

namespace MinSal\SidPla\RRMedicoBundle\EntityDao;

use MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed;
use Doctrine\ORM\Query\ResultSetMapping;

class ResulPrograRRMedDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaRRMedicoBundle:ResulPrograRRMed');
    }

   
    /*
     * Obtiene todos los Resultados RRMed
     */

    public function getResulPrograRRMed() {
        $resulPrograRRMedo = $this->em->createQuery("SELECT rp
                                                FROM MinSalSidPlaRRMedicoBundle:ResulPrograRRMed rp
                                                ORDER BY rp.codResproRR ASC");
        return $resulPrograRRMedo->getResult();
    }

    /*
     * Obtiene una Resultado RRMed
     */
    public function getResulPrograRRMedEspecifico($codigo) {
        $resulPrograRRMed= $this->repositorio->find($codigo);
        return $resulPrograRRMed ;
    }
    
       /*
     * Agregar Resultado RRMed
     */

    public function agregarTipoHorario($DescTipoHorario,$cantHoras ,$tipTurno) {

        $tipoHorario= new TipoHorario();
        $tipoHorario->setTipoHorDes($DescTipoHorario);  
        $tipoHorario->setTipoCantidadHor($cantHoras);
        $tipoHorario->setTipoHorTurno($tipTurno);
        
        $this->em->persist($tipoHorario);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo horario termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Editar un tipo de periodo
     */

    public function editarTipoHorario($codTipoH, $DescTipoHorario,$cantHoras,$tipTurno) {

        $tipoHorario= $this->getTipoHorarioEspecifico($codTipoH);
         $tipoHorario->setTipoHorDes($DescTipoHorario);  
        $tipoHorario->setTipoCantidadHor($cantHoras);
        $tipoHorario->setTipoHorTurno($tipTurno);
        
        $this->em->persist($tipoHorario);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo horario termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Eliminar un tipo de periodo
     */

    public function eliminarTipoHorario($codigo) {

          $tipoHorario= $this->getTipoHorarioEspecifico($codigo);

        $this->em->remove($tipoHorario);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

}
?>