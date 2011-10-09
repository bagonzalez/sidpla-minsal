<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjespTemplateDao
 *
 * @author edwin
 */

namespace MinSal\SidPla\GesObjEspEntControlBundle\eEntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
class ObjespTemplateDao {
    //put your code here
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
