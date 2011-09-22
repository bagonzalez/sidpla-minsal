<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura;
use MinSal\SidPla\EstInfraBundle\EntityDao\EstadoInfraestructuraDao;



class EvaluacionElementoInfraDao {
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
    
    public function editarEvaluacionElemento($codEvaEleInfra, $codEstInfra,$cantEvaEleInfra) {

        $evaluacionElemento = $this->getEvaluacionElementoEspecifica($codEvaEleInfra);
        $evaluacionElemento->setCantElemt($cantEvaEleInfra);
        
        $estadoInfraestructuraDao=new EstadoInfraestructuraDao($this->doctrine);
        $estadoInfraestructura=$estadoInfraestructuraDao->getEstadoInfraestructuraEspecifico($codEstInfra);
        $evaluacionElemento->setEstInfCodigo($estadoInfraestructura);
 
        $this->em->persist($evaluacionElemento);
        $this->em->flush();
        $matrizMensajes = array('El proceso de editar la Evaluacion Elemento termino con exito');

        return $matrizMensajes;
    }
}

?>
