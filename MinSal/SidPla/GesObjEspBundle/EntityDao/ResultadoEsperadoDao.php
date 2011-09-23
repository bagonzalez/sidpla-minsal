<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResultadoEsperadoDao
 *
 * @author edwin
 */

namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\Entity\MedioVerificacion;

class ResultadoEsperadoDao {
    //put your code here

    
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:ResultadoEsperado');
    } 
    
    public function getResulEspera($id) {	    
        $ResulEsp=$this->repositorio->find($id);
        return $ResulEsp;
    }
    
    
    public function delResulEsp($id){            

        $Res=$this->repositorio->find($id);

        if(!$Res){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($Res);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    
    public function editResulEsp(       $idResTempl,
                                        $idTipoMeta,
                                        $resEspeDesc,
                                        $resEspNomencl,
                                        $resEspCondi,
                                        $resEspMetAnual,
                                        $resEspDescMetAnual,
                                        $resEspResponsable,
                                        $resEspEntidadControl,
                                        $resEspIndicador,
                                        $idobjetivo,
                                        $id){  
          
   
         $objResulesperado=new ResultadoEsperado();
         $objResulesperado=$this->repositorio->find($id);
         $objResulesperado->setIdResTempl($idResTempl);                         
         $objResulesperado->setIdTipoMeta($idTipoMeta);                         
         $objResulesperado->setResEspeDesc($resEspeDesc);                         
         $objResulesperado->setResEspNomencl($resEspNomencl);                         
         $objResulesperado->setResEspCondi($resEspCondi);                         
         $objResulesperado->setResEspMetAnual($resEspMetAnual);                         
         $objResulesperado->setResEspDescMetAnual($resEspDescMetAnual);                         
         $objResulesperado->setResEspResponsable($resEspResponsable);                         
         $objResulesperado->setResEspEntidadControl($resEspEntidadControl);
         $objResulesperado->setResEspIndicador($resEspIndicador);
        
         
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
   }
   
   
   public function agregarMedioVerificacion($descrpMedVeri,$idResultado) {
         
      
         $resultadoAux=new ResultadoEsperado();
         $resultadoAux=$this->getResulEspera($idResultado); 
            
         $objMedVerif=new MedioVerificacion();
         $objMedVerif->setMedVerfDescricion($descrpMedVeri);                         
         $objMedVerif->setIdResulEspe($resultadoAux);

         
         $resultadoAux->addmedioVerificacion($objMedVerif);

         $this->em->persist($objMedVerif);
         $this->em->persist($resultadoAux);
         $this->em->flush();
        
        
        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }
   
   
   
}

?>
