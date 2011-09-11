<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InformacionComplementariaDAO
 *
 * @author edwin
 */
namespace MinSal\SidPla\CensoBundle\EntityDao;

use MinSal\SidPla\CensoBundle\Entity\InformacionComplementaria;
class InformacionComplementariaDAO {
    //put your code here
    
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaCensoBundle:InformacionComplementaria');
    }
    
    public function getInfoComple() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
    
    /*
     *  Almacena los datos de informacion complementaria  ingresado en el sistema
     */
    
    public function addInfoComple($areaInfo, $censoCodigo,$catcenCodigo,$cantidadInfo) {
        
        $InfoCompleSistema=new InformacionComplementaria();
        
        $InfoCompleSistema->setAreaInfoComp($areaInfo);
        $InfoCompleSistema->setCodigoCensoPoblacion($censoCodigo);
        $InfoCompleSistema->setCodigoCatCen($catcenCodigo);
        $InfoCompleSistema->setCantidadInfoComp($cantidadInfo);
        
	    
        $this->em->persist($InfoCompleSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar la informacion complementaria ha termino con exito', 'InfoComple'.$InfoCompleSistema->getAreaInfoComp());

        return $matrizMensajes;
    }
  
    
    public function editInfoComple($areaInfo, $censoCodigo,$catcenCodigo,$cantidadInfo, $id){
            
            $InfoCompleEdit=new InformacionComplementaria();            
            $InfoCompleEdit=$this->repositorio->find($id);
            
            if(!$InfoCompleEdit){
                throw $this->createNotFoundException('No se encontro la informacion complementaria con ese id '.$id);
            }
            
            $InfoCompleEdit->setAreaInfoComp($areaInfo);
            $InfoCompleEdit->setCodigoCensoPoblacion($censoCodigo);
            $InfoCompleEdit->setCodigoCatCen($catcenCodigo);
            $InfoCompleEdit->setCantidadInfoComp($cantidadInfo);
            
            $this->em->flush();            
            $matrizMensajes = array('El proceso de editar termino con exito', 'InfoComple'.$InfoCompleEdit->getAreaInfoComp());
 
            return $matrizMensajes;
        }
    
    public function delInfoComple($id){            
            
            $InfoCompleEdit=$this->repositorio->find($id);
            
            if(!$InfoCompleEdit){
                throw $this->createNotFoundException('No se encontro la informacion comple  con ese  id '.$id);
            }
            
            $this->em->remove($InfoCompleEdit);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar el bloque termino con exito', 'Info comp '.$InfoCompleEdit->getAreaInfoComp());
 
            return $matrizMensajes;
        }
    
    
    
}

?>
