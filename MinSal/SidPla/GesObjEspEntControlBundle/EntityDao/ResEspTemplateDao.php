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
    
    public function editResulEspTemplate($resEspeDesc,$resEspNomencl,$resEspIndicador,$idobjetivo,$id){  
          
   
         $objResulesperado=new ResEspTemplate();
         $objResulesperado=$this->repositorio->find($id);
         $objResulesperado->setResEspTemplDescripcion($resEspeDesc);                         
         //$objResulesperado->setResEspNomencl($resEspNomencl);                         
         $objResulesperado->setResEspTemplIndicador($resEspIndicador);                         
                 
         
        $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
   }
   
   public function delResultadoEsperadotemplate($id){            

        $obj=$this->repositorio->find($id);

        if(!$obj){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($obj);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
   
   
}

?>
