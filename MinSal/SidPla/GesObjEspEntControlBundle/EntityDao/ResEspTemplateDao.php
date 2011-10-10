<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate;
class ResEspTemplateDao {
    //put your code here
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspEntControlBundle:ResEspTemplate');
    } 
    
    public function getResultadoTemplate($id) {	    
        $resultadotemplate=$this->repositorio->find($id);
        return $resultadotemplate;
    }
}

?>
