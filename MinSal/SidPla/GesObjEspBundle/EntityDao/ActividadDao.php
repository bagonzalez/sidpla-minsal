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
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
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
    
     public function editActividad($idfilaResultado,
                                       $tipometa,
                                        $actividad,
                                        $resEspNomencl,
                                        $supuestosfactores,
                                        $metaAnual,
                                        $descripMetaAnual,
                                        $responsable,
                                        $indicador,
                                        $medioverifindicador,
                                        $id){
         
         $objActividad=new Actividad();
         $objActividad=$this->repositorio->find($id);
         $objActividad->setIdTipoMeta($tipometa);                         
         $objActividad->setActDescripcion($actividad);                         
         $objActividad->setActNomenclatura($resEspNomencl);                         
         $objActividad->setSupuestosFactores($supuestosfactores);                         
         $objActividad->setActMetaAnual($metaAnual);                         
         $objActividad->setActDescMetaAnu($descripMetaAnual);                         
         $objActividad->setActResponsable($responsable);                         
         $objActividad->setActIndicador($indicador);
         $objActividad->setIdTipoMedVeri($medioverifindicador);
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
    }
    
    public function agregarResulActividad($idActividad,$trimes,$trim,$fechInicio,$fechaFin) {
         
      
           $resultadoAux=new Actividad();
           $resultadoAux=$this->getActividad($idActividad); 
     
         $objresultadore=new ResulActividad();
         $objresultadore->setResulActTrimestre($trimes);                         
         $objresultadore->setResulActProgramado($trim); 
         $objresultadore->setResulActFechaInicio($fechInicio);
         $objresultadore->setResulActFechaFin($fechaFin);
         $objresultadore->setIdActividad($resultadoAux);                         
         
                 
         $resultadoAux->addResulAct($objresultadore);

         $this->em->persist($objresultadore);
         $this->em->persist($resultadoAux);
         $this->em->flush();
        
        
      
        return $objresultadore->getIdResulAct();
    }
    
    
    
    
    
}

?>
