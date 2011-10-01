<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActividadDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\GesObjEspBundle\EntityDao;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
class ActividadDao {
    //put your code here

     var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:Actividad');
    } 
    
     
    
    public function getActividad($id) {	    
        $actividad=$this->repositorio->find($id);
        return $actividad;
    }
    
    
    
    
    
    
    
    
    
}

?>
