<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;

class ObjTemplateDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaGesObjEspEntControlBundle:ObjTemplate');
    }

    public function obtenerObjTempAnio($anio) {
        
        $objTmp= $this->em->createQuery("SELECT ot
                                         FROM MinSalSidPlaGesObjEspEntControlBundle:ObjTemplate ot
                                         WHERE ot.anioObjTemp = '2011'");
        return $objTmp->getResult();
    }

}

?>
