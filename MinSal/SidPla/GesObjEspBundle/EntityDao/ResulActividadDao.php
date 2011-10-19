<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResulActividadDao
 *
 * @author edwin
 */

namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;
class ResulActividadDao {
    //put your code here

    
     var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:ResulActividad');
    } 
    
    
     public function getResulActividad($id) {	    
        $ResultEsp=$this->repositorio->find($id);
        return $ResultEsp;
    }
    
     public function guardarResulAct($resulAct) {
        $this->em->persist($resulAct);
        $this->em->flush();
    }
    
    public function delResulActividad($id){            

        $Res=$this->repositorio->find($id);

        if(!$Res){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($Res);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    
     public function editResulActividad($trim,$id,$fechainicio,$fechafin){
         
         $objResultadore=new ResulActividad();
         $objResultadore=$this->repositorio->find($id);
         $objResultadore->setResulActProgramado($trim);                         
         $objResultadore->setResulActFechaInicio($fechainicio);
         $objResultadore->setResulActFechaFin($fechafin);
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
    }
    
    
    public function addCompromisoCumplimiento($hallazgos, $medidasadoptar,$fechacumplimiento,$responsable,$idResultActividad) {
        
       $resultProMon= new ResulActividad();
        $resultProMon=$this->getResulActividad($idResultActividad); 
       
        
        
        $comprocumpl= new CompromisoCumplimiento();
        $comprocumpl->setComproCumpliHallazgozEncontrados($hallazgos);
        $comprocumpl->setComproCumpliMedidaAdoptar($medidasadoptar);
        $comprocumpl->setComproCumpliResponsable($responsable);
        $comprocumpl->setComproCumpliFecha($fechacumplimiento);
        $comprocumpl->setIdResActividad($resultProMon);
        
        $resultProMon->addCompromisoCumplimiento($comprocumpl);
	    
        $this->em->persist($comprocumpl);
        $this->em->persist($resultProMon);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar terminoexito', 'compro'.$comprocumpl->getIdComproCumpl());

        return $matrizMensajes;
    }
}

?>
