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

    
    public function obtenerTipoHorario() {
        $encabezado=  $this->getUnidadMedidaEspecifica(-1);
        $cadena = $encabezado->getIdUnidMed().":".$encabezado->getAbreUnidMed().';';
        
        $unidadMedida = $this->getUnidadMedida();
        $aux = new UnidadMedida();
        $n = $this->cuantasUnidadesMedida();
        $i = 1;
        
        foreach ($unidadMedida as $aux) {
            if ($i < $n)
                $cadena.=$aux->getIdUnidMed().":".$aux->getAbreUnidMed().';';
            else
                $cadena .=$aux->getIdUnidMed().":".$aux->getAbreUnidMed();
            $i++;
        }

        return $cadena;
    }
    
    public function cuantasUnidadesMedida() {
        $unidadmedida = $this->em->createQuery("SELECT count(um)
                                                FROM MinSalSidPlaEstInfraBundle:UnidadMedida um
                                                WHERE um.idUnidMed != -1");
        return $unidadmedida->getSingleScalarResult();
    }
    
    /*
     * Obtiene todos los tipos de periodos
     */

    public function getTipoHorario() {
        $tipoHorario = $this->em->createQuery("SELECT th
                                                FROM MinSalSidPlaRRMedicoBundle:TipoHorario th
                                                ORDER BY th.codTipoHor ASC");
        return $tipoHorario->getResult();
    }

    /*
     * Obtiene una unidad de medida especifica
     */
    public function getTipoHorarioEspecifico($codigo) {
        $tipoHorario = $this->repositorio->find($codigo);
        return $tipoHorario ;
    }
    
       /*
     * Agregar Unidad de Medida 
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