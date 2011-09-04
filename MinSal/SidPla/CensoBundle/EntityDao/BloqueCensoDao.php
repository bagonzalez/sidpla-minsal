<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BloqueCensoDao
 *
 * @author edwin
 */

namespace MinSal\SidPla\CensoBundle\EntityDao;

use MinSal\SidPla\CensoBundle\Entity\BloqueCenso;
class BloqueCensoDao {
    //put your code here
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaCensoBundle:BloqueCenso');
    } 
    
    public function getBloqueCen() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
    
    /*
     *  Almacena un rol ingresado en el sistema
     */
    
    public function addBloqueCen($nombreBloque, $ordenBloque) {
        
        $BloqueCensoSistema=new BloqueCenso();
        
        $BloqueCensoSistema->setNombreBloque($nombreBloque);
        $BloqueCensoSistema->setOrdenBloque($ordenBloque);
	    
        $this->em->persist($BloqueCensoSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar el bloque censo ha termino con exito', 'Bloque '.$BloqueCensoSistema->getNombreBloque());

        return $matrizMensajes;
    }
  
    
    public function editBloqueCen($nombreBloque, $ordenBloque, $id){
            
            $BloqueCen=new BloqueCenso();            
            $BloqueCen=$this->repositorio->find($id);
            
            if(!$BloqueCen){
                throw $this->createNotFoundException('No se encontro el bloque con ese id '.$id);
            }
            
            $BloqueCen->setNombreBloque($nombreBloque);
            $BloqueCen->setOrdenBloque($ordenBloque);
            
            $this->em->flush();            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Bloque '.$BloqueCen->getNombreBloque());
 
            return $matrizMensajes;
        }
    
    public function delBloqueCen($id){            
            
            $BloqueCen=$this->repositorio->find($id);
            
            if(!$BloqueCen){
                throw $this->createNotFoundException('No se encontro el bloque  con ese  id '.$id);
            }
            
            $this->em->remove($BloqueCen);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar el bloque termino con exito', 'bloque '.$BloqueCen->getNombreBloque());
 
            return $matrizMensajes;
        }
        
        
        
}

?>
