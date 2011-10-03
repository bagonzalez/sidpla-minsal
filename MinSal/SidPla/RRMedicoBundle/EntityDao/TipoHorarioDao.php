<?php

namespace MinSal\SidPla\RRMedicoBundle\EntityDao;

use MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario;
use Doctrine\ORM\Query\ResultSetMapping;

class TipoHorarioDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaRRMedicoBundle:TipoHorario');
    }

    
    public function obtenerTipoHorarios() {
        $cadena="";
        $TipoHorarios=$this->getTipoHorario();
        $aux = new TipoHorario();
        $n =  count($TipoHorarios);
        $i = 1;
        
        foreach ($TipoHorarios as $aux) {
            if ($i < $n)
                $cadena.=$aux->getCodTipoHor().":".$aux->getTipoHorDes().';';
            else
                $cadena.=$aux->getCodTipoHor().":".$aux->getTipoHorDes();
            $i++;
        }

        return $cadena;
    }
  
    /*
     * Obtiene todos los tipos de horarios
     */

    public function getTipoHorario() {
        $tipoHorario = $this->em->createQuery("SELECT th
                                                FROM MinSalSidPlaRRMedicoBundle:TipoHorario th
                                                ORDER BY th.codTipoHor ASC");
        return $tipoHorario->getResult();
    }

    /*
     * Obtiene un tipo de horario especifico
     */
    public function getTipoHorarioEspecifico($codigo) {
        $tipoHorario = $this->repositorio->find($codigo);
        return $tipoHorario ;
    }
    
       /*
     * Agregar Tipo Horario
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
     * Editar un tipo de Horario
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
     * Eliminar un tipo de Horario
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