<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura;
use MinSal\SidPla\EstInfraBundle\EntityDao\EstadoInfraestructuraDao;
use MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada;

class EvaluacionElementoInfraDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaEstInfraBundle:EvaluacionElementoInfra');
    }

    public function getEvaluacionElemento() {
        $evaluacionElemento = $this->em->createQuery("select el
                                                 from MinSalSidPlaEstInfraBundle:EvaluacionElementoInfra el
                                                 order by el.idEvaEleInfra ASC");
        return $evaluacionElemento->getResult();
    }

    public function getEvaluacionElementoEspecifica($codigo) {
        $evaluacionElemento = $this->repositorio->find($codigo);
        return $evaluacionElemento;
    }

    public function editarEvaluacionElemento($codEvaEleInfra, $codEstInfra, $cantEvaEleInfra,$cantTot) {

        $evaluacionElemento = new EvaluacionElementoInfra();
        $evaluacionElemento = $this->getEvaluacionElementoEspecifica($codEvaEleInfra);
        $evaluacionElemento->setCantElemt($cantEvaEleInfra);

        $estadoInfraestructuraDao = new EstadoInfraestructuraDao($this->doctrine);
        $estadoInfraestructura = $estadoInfraestructuraDao->getEstadoInfraestructuraEspecifico($codEstInfra);
        $evaluacionElemento->setEstInfCodigo($estadoInfraestructura);
        $evaluacionElemento->setCantTot($cantTot);
        $evaluacionElemento->setFechaEvaluacion( date('Y-m-d'));

        $this->em->persist($evaluacionElemento);
        $this->em->flush();
        $matrizMensajes = array('El proceso de editar la Evaluacion Elemento termino con exito');

        return $matrizMensajes;
    }
    /*
     * Consulta las opciones que no estan asignadas
     */

    public function consultarElementosDisponibles($idInfra) {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaEstInfraBundle:ElementoInfraestructura', 'ei');
        $rsm->addFieldResult('ei', 'eleminf_codigo', 'IdElemInfra');
        $rsm->addFieldResult('ei', 'eleminf_nombre', 'nomElemInfra');
        $query = $this->em->createNativeQuery('SELECT ei.eleminf_codigo, ei.eleminf_nombre
                                               FROM sidpla_elementoinfraestructura ei   
                                               WHERE ei.eleminf_codigo NOT IN (SELECT ee.eleminf_codigo
                                                                               FROM sidpla_infraestructuraevaluada ie,sidpla_evaluacionelementoinfra ee,sidpla_elementoinfraestructura eli
                                                                               WHERE ie.infeva_codigo=ee.infeva_codigo AND eli.eleminf_codigo=ee.eleminf_codigo 
                                                                                     AND ie.infeva_codigo=?)
                                                     AND ei.eleminf_codigo != -1', $rsm);
        $query->setParameter(1, $idInfra);
        $elementosDisponibles = $query->getResult();

        return $elementosDisponibles;
    }
    
   public function agregarElementoAEvaluacion($idEleInfra, $idInfra) {

        $estadoInfraestructuraDao = new EstadoInfraestructuraDao($this->doctrine);
        $estadoInfraestructura = $estadoInfraestructuraDao->getEstadoInfraestructuraEspecifico(-1);
        
        $elementoInfraestructuraDao= new ElementoInfraestructuraDao($this->doctrine);
        $elementoInfraestructura=$elementoInfraestructuraDao->getElementoInfraestructuraEspecifico($idEleInfra);
        
        $infraestructuraEvaluadaDao = new InfraestructuraEvaluadaDao($this->doctrine);
        $infraestructuraEvaluada= $infraestructuraEvaluadaDao->getInfraEvaEspecifica($idInfra);
        
        $evaluacionElemento = new EvaluacionElementoInfra();
        $evaluacionElemento->setCantElemt(0);
        $evaluacionElemento->setElemInfCodigo($elementoInfraestructura);
        $evaluacionElemento->setEstInfCodigo($estadoInfraestructura);
        $evaluacionElemento->setInfraEvaluada($infraestructuraEvaluada);
        $evaluacionElemento->setCantTot(0);
        $evaluacionElemento->setFechaEvaluacion( date('Y-m-d'));
        
        $this->em->persist($evaluacionElemento);
        $this->em->flush();
        $matrizMensajes = array('El proceso de editar la Evaluacion Elemento termino con exito');

        return $matrizMensajes;
    }
    
    public function quitarElementoDeEvaluacion($idEleInfra, $idInfra) {

        $infraestructuraEvaluadaDao = new InfraestructuraEvaluadaDao($this->doctrine);
        $infraestructuraEvaluada= $infraestructuraEvaluadaDao->getInfraEvaEspecifica($idInfra);
        
        $evaluacionesElemento=$infraestructuraEvaluada->getEvaEleInfra();
        
        $aux = new EvaluacionElementoInfra();
        foreach ($evaluacionesElemento as $aux) {
            if ($aux->getElemInfCodigo()->getIdElemInfra()==$idEleInfra){
                $this->em->remove($aux);
                $this->em->flush();
                $matrizMensajes = array('El proceso de eliminar termino con exito');
                return $matrizMensajes;
            }
        }
    }

}

?>
