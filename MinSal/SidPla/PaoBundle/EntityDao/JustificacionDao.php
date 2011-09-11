<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Justificacion
 *
 * @author JENNY
 * 
 */
namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\Justificacion;// aqui defino la entidad

class JustificacionDao {
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaPaoBundle:Justificacion');// aqui pongo entidad
        // y paquete (bundle)
    } 
    
      public function getHistorialJustificacion() { //recupera toda las justificaciones registradas	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
    
    public function addJustificacion($descripcion,$codPao) {
        
         $JustificacionSistema=new Justificacion(); //instancia de justificacion
        
         $JustificacionSistema->setJustificacion_descripcion($descripcion);
         $JustificacionSistema->setPao_codigo($codPao);
         
        $this->em->persist($JustificacionSistema);
        $this->em->flush();	    
        $matrizMensajes = array('La Justificacion se creo con exito', 'Justificacion '.$JustificacionSistema->getJustificacion_descripcion());

        return $matrizMensajes;
    }
    
    
   public function editJustificacion($descripcion,$codPao){
            
            $JustificacionSistema=new justificacion();  //Instancia          
            $JustificacionSistema=$this->repositorio->find($id);
            
            if(!$JustificacionSistema){
                throw $this->createNotFoundException('No existe justificacion '.$id);
            }
            
            $JustificacionSistema->setJustificacion_descripcion($descripcion);
            $JustificacionSistema->setPao_codigo($codPao);
            
            $this->em->flush();            
            $matrizMensajes = array('Justificacion modificada con exito', 'Justificacion '.$JustificacionSistema->getJustificacion_descripcion());
 
            return $matrizMensajes;
        }// editar justificacion 
        
        
    public function delJustificacion($id){            
            
             $JustificacionSistema=$this->repositorio->find($id);
            
            if(! $JustificacionSistema){
                throw $this->createNotFoundException('No se encontro Justificacion'.$id);
            }
            
            $this->em->remove( $JustificacionSistema);
            $this->em->flush();
            
            $matrizMensajes = array('Justificacion modificada con exito', 'Justificacion '. $JustificacionSistema->getJustificacion_descripcion());
 
            return $matrizMensajes;
        }// eliminar justificacion
        

          public function buscarJustificacion($id){
           $JustificacionSistema=$this->repositorio->find($id);
            
            if(! $JustificacionSistema){
                throw $this->createNotFoundException('No se encontro Justificacion'.$id);
            }
           return $JustificacionSistema;
            
        }
        
        
        
        public function actualizacionJustificacion($descripcion,$id){
            $JustificacionSistema=new justificacion();  //Instancia          
            $JustificacionSistema=$this->repositorio->find($id);
            
            if(!$JustificacionSistema){
                throw $this->createNotFoundException('No existe justificacion '.$id);
            }
            
           $JustificacionSistema->setJustificacion_descripcion($descripcion);
                        
            $this->em->flush();            
            $matrizMensajes = array('Justificacion modificada con exito', 'Justificacion '.$JustificacionSistema->getJustificacion_descripcion());
 
            return $matrizMensajes;
            
            
        }
        
        
}//cierre de la clase justificacion

?>
