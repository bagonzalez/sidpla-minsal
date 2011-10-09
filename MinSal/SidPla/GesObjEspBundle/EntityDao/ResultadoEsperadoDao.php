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
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\GesObjEspBundle\Entity\Resultadore;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo;

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
                                        $medioverificacion,
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
        $objResulesperado->setmedioVerificacion($medioverificacion);
         
         
        $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
   }
   
   public function agregarActividad($idfilaResultado,
                                       $tipometa,
                                        $actividad,
                                        $resEspNomencl,
                                        $supuestosfactores,
                                        $metaAnual,
                                        $descripMetaAnual,
                                        $responsable,
                                        $indicador,
                                        $medioverifindicador ){
         
      
           $resultadoAux=new ResultadoEsperado();
           $resultadoAux=$this->getResulEspera($idfilaResultado); 
     
         $objActividad=new Actividad();
         $objActividad->setIdTipoMeta($tipometa);                         
         $objActividad->setActDescripcion($actividad);                         
         $objActividad->setActNomenclatura($resEspNomencl);                         
         $objActividad->setSupuestosFactores($supuestosfactores);                         
         $objActividad->setActMetaAnual($metaAnual);                         
         $objActividad->setActDescMetaAnu($descripMetaAnual);                         
         $objActividad->setActResponsable($responsable);                         
         $objActividad->setActIndicador($indicador);
         $objActividad->setIdTipoMedVeri($medioverifindicador);
         $objActividad->setIdResEsp($resultadoAux);
                 
         $resultadoAux->addActividades($objActividad);

         $this->em->persist($objActividad);
         $this->em->persist($resultadoAux);
         $this->em->flush();
        
        
       // $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ','Resultado'.$objResulesperado->getIdResEsp());

        return $objActividad->getIdAct();
    }
   
    
    public function agregarResultadore($idResultadoEsp,$trimes,$trim, $programacionMonitoreo) {
         
      
           $resultadoAux=new ResultadoEsperado();
           $resultadoAux=$this->getResulEspera($idResultadoEsp); 
     
         $objresultadore=new Resultadore();
         $objresultadore->setResultadoreTrimestre($trimes);                         
         $objresultadore->setResultadoreProgramado($trim);                         
         $objresultadore->setIdResEsp($resultadoAux); 
         
         $objresultadore->setProgramacionMonitoreo($programacionMonitoreo);
         
         $programacionMonitoreo->addResultadores($objresultadore);         
                 
         $resultadoAux->addResultadore($objresultadore);

         $this->em->persist($objresultadore);
         $this->em->persist($resultadoAux);
         $this->em->persist($programacionMonitoreo);
         $this->em->flush();
        
        
       // $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ','Resultado'.$objResulesperado->getIdResEsp());

        return $objresultadore->getIdResultadore();
    }
   
}

?>
