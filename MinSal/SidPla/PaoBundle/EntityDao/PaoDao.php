<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Doctrine\ORM\Query\ResultSetMapping;


class PaoDao {
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPaoBundle:Pao');
    }
    
    public function existenPaos($anio) {
        $paos = $this->em->createQuery("SELECT count (P)
                                               FROM MinSalSidPlaPaoBundle:Pao P
                                               WHERE P.anio = " . $anio );
        return $paos->getSingleScalarResult();
    }
    
    
}

?>
