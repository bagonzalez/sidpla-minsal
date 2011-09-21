<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoMetaDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta;
class TipoMetaDao {
    //put your code here

    
     var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:TipoMeta');
    } 
    
    public function geTipometa($id) {	    
        $ResulEsp=$this->repositorio->find($id);
        return $ResulEsp;
    }
    
    public function getTiposMeta() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
}

?>
