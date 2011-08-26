<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MensajeCorreTempDao
 *
 * @author edwin
 */

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\MensajeCorreTemp;


class MensajeCorreTempDao {
    //put your code here

    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:MensajeCorreTemp');
    } 
    
  
    
    public function getMensaTem() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
  
    /*
     *  Almacena un rol ingresado en el sistema
     */
    
    public function addMensaTem($nombreRol, $funciones) {
        
        $MensatemSistema=new MensajeCorreTemp();
        
        $MensatemSistema->setMencortemTexto($nombreRol);
        $MensatemSistema->setMencortemNombre($funciones);
	    
        $this->em->persist($MensatemSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar el mensaje correo ha termino con exito', 'Rol '.$MensatemSistema->getMencortemTexto());

        return $matrizMensajes;
    }
    
    public function editMensaTem($nombreRol, $funciones, $id){
            
            $MensaTemp=new MensajeCorreTemp();            
            $MensaTemp=$this->repositorio->find($id);
            
            if(!$MensaTemp){
                throw $this->createNotFoundException('No se encontro rol con ese id '.$id);
            }
            
            $MensaTemp->setMencortemTexto($nombreRol);
            $MensaTemp->setMencortemNombre($funciones);
            
            $this->em->flush();            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Rol '.$MensaTemp->getMencortemTexto());
 
            return $matrizMensajes;
        }
        
         /*
         * eliminar rol
         */
        
        
        public function delMensaTem($id){            
            
            $MensaTemp=$this->repositorio->find($id);
            
            if(!$MensaTemp){
                throw $this->createNotFoundException('No se encontro el mensaje con ese  id '.$id);
            }
            
            $this->em->remove($MensaTemp);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar el mensaje correo termino con exito', 'Rol '.$MensaTemp->getMencortemTexto());
 
            return $matrizMensajes;
        }
    
    
    
    
    
    
}

?>
