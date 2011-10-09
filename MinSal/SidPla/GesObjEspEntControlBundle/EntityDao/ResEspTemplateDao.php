<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResEspTemplateDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\GesObjEspEntControlBundle\eEntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate;
class ResEspTemplateDao {
    //put your code here
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('GesObjEspEntControlBundle:ResEspTemplate');
    } 
    
    public function getResultadoTemplate($id) {	    
        $resultadotemplate=$this->repositorio->find($id);
        return $resultadotemplate;
    }
}

?>
