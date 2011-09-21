<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedioVerificacion
 *
 * @author edwin
 */
namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\MedioVerificacion;
class MedioVerificacionDao {
    //put your code here

    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:MedioVerificacion');
    } 
    
    
    public function delMedVerif($id){            

        $Medio=$this->repositorio->find($id);

        if(!$Medio){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($Medio);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    
    public function editMedVerif($medVerfDescricion,$id){  
          
    
         $objMedioVerificacion=new MedioVerificacion();
         $objMedioVerificacion=$this->repositorio->find($id);
         $objMedioVerificacion->setMedVerfDescricion($medVerfDescricion);                         
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
          return $matrizMensajes;
   }
     
}

?>
