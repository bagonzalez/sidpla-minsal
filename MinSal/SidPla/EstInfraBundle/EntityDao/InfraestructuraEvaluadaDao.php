<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada;
use Doctrine\ORM\Query\ResultSetMapping;

class InfraestructuraEvaluadaDao {
    
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaEstInfraBundle:InfraestructuraEvaluada');
    }
    
     public function getInfraEvaEspecifica($codigo) {
        $infraEva = $this->repositorio->find($codigo);
        return $infraEva;
    }

}

?>
