<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PoblacionHumanaDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\CensoBundle\EntityDao;
use MinSal\SidPla\CensoBundle\Entity\PoblacionHumana;
class PoblacionHumanaDao {
    //put your code here

    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaCensoBundle:PoblacionHumana');
    }
    
    public function getInfoPobHum() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
    public function getPoblacionHumana($id) {	    
        $poblacionHumana=$this->repositorio->find($id);
        if(!$poblacionHumana){
            $poblacionHumana = new PoblacionHumana();
        }
        return $poblacionHumana;
    }
    
    
    /*
     *  Almacena los datos de informacion complementaria  ingresado en el sistema
     */
    
    public function addInfoPobHuma($codCenPob, $codCatCen,$pobHumClasi,$pobHumArea,$pobHumCant,$pobhumSexo) {
        
        $InfoPobHumaSistema=new PoblacionHumana();
        
        $InfoPobHumaSistema->setCodCenPob($codCenPob);
        $InfoPobHumaSistema->setCodCatCen($codCatCen);
        $InfoPobHumaSistema->setPobHumClasi($pobHumClasi);
        $InfoPobHumaSistema->setPobHumArea($pobHumArea);
        $InfoPobHumaSistema->setPobHumCant($pobHumCant);
	$InfoPobHumaSistema->setPobhumSexo($pobhumSexo); 
        
        
        $this->em->persist($InfoPobHumaSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar la informacion de poblacion huaman ha termino con exito', 'InfoPobHumana'.$InfoPobHumaSistema->getPobHumClasi());

        return $matrizMensajes;
    }
  
    
    public function editPobHuma($codCenPob, $codCatCen,$pobHumClasi,$pobHumArea,$pobHumCant,$pobhumSexo, $id){
            
            $InfoPobHumaEdit=new PoblacionHumana();            
            $InfoPobHumaEdit=$this->repositorio->find($id);
            
            if(!$InfoPobHumaEdit){
                throw $this->createNotFoundException('No se encontro la informacion de la poblacion huamana  con ese id '.$id);
            }
            
             $InfoPobHumaEdit->setCodCenPob($codCenPob);
             $InfoPobHumaEdit->setCodCatCen($codCatCen);
             $InfoPobHumaEdit->setPobHumClasi($pobHumClasi);
             $InfoPobHumaEdit->setPobHumArea($pobHumArea);
             $InfoPobHumaEdit->setPobHumCant($pobHumCant);
	     $InfoPobHumaEdit->setPobhumSexo($pobhumSexo);
            
                        
            $this->em->flush();            
            $matrizMensajes = array('El proceso de editar termino con exito', 'InfoPobHum'.$InfoPobHumaEdit->getPobHumClasi());
 
            return $matrizMensajes;
        }
    
    public function delPobHuma($id){            
            
            $InfoPobHumaDel=$this->repositorio->find($id);
            
            if(!$InfoPobHumaDel){
                throw $this->createNotFoundException('No se encontro la informacion de la poblacion  con ese  id '.$id);
            }
            
            $this->em->remove($InfoPobHumaDel);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar la informacion de poblacion humana ha  con exito', 'InfoPobHum '.$InfoPobHumaDel->getPobHumClasi());
 
            return $matrizMensajes;
        }
    
    
    
    
    
    
    
}

?>
