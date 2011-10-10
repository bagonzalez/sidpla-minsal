<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
class ObjespTemplateDao {
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('GesObjEspEntControlBundle:ObjespTemplate');
    } 
    
    public function getObjetivoTemplate($id) {	    
        $objetivotemplate=$this->repositorio->find($id);
        return $objetivotemplate;
    }
    
    
}

?>
