<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InformacionRelevanteDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\CensoBundle\EntityDao;
use MinSal\SidPla\CensoBundle\Entity\InformacionRelevante;
class InformacionRelevanteDao {
    //put your code here

    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaCensoBundle:InformacionRelevante');
    }
    
    public function getInfoRel() {	    
        $mensajes=$this->repositorio->findAll();
        return $mensajes;
    }
    
    /*
     *  Almacena los datos de informacion relevante  ingresado en el sistema
     */
    
    public function addInfoRel($codCenPob,$codCatCen,$infRelCant) {
        
        $InforelSistema=new InformacionRelevante();
        
        $InforelSistema->setCodCenPob($codCenPob);
        $InforelSistema->setCodCatCen($codCatCen);
        $InforelSistema->setInfRelCant($infRelCant);
        
        
	    
        $this->em->persist($InforelSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar la informacion relevante ha termino con exito', 'InfoRele'.$InforelSistema->getInfRelCant());

        return $matrizMensajes;
    }
    
    
    public function editInfoRel($codCenPob,$codCatCen,$infRelCant, $id){
            
            $InforelEdit=new InformacionRelevante();            
            $InforelEdit=$this->repositorio->find($id);
            
            if(!$InforelEdit){
                throw $this->createNotFoundException('No se encontro la informacion relevante con ese id '.$id);
            }
            
            $InforelEdit->setCodCenPob($codCenPob);
            $InforelEdit->setCodCatCen($codCatCen);
            $InforelEdit->setInfRelCant($infRelCant);
                       
            $this->em->flush();            
            $matrizMensajes = array('El proceso de editar termino con exito', 'InfoRel'.$InforelEdit->getInfRelCant());
 
            return $matrizMensajes;
        }
    
    
    public function delInfoRel($id){            
            
            $InfoRelDel=$this->repositorio->find($id);
            
            if(!$InfoRelDel){
                throw $this->createNotFoundException('No se encontro la informacion Relevante  con ese  id '.$id);
            }
            
            $this->em->remove($InfoRelDel);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar el bloque termino con exito', 'Info Rel '.$InfoRelDel->getIdInfRel());
 
            return $matrizMensajes;
        }
        
   public function getInfRelevante($id) {	    
        $infRelevante=$this->repositorio->find($id);
        if(!$infRelevante){
            $infRelevante = new InformacionRelevante();
        }
        return $infRelevante;
    }
    
    
}

?>
