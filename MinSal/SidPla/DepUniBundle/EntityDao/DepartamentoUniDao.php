<?php

namespace MinSal\SidPla\DepUniBundle\EntityDao;

use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;
use Doctrine\ORM\Query\ResultSetMapping;

class DepartamentoUniDao {
     var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaDepUniBundle:DepartamentoUni');
    }

    public function getDeptoUni() {
        $deptoUni = $this->repositorio->findAll();
        return $deptoUni->getResult();
    }

}

?>
