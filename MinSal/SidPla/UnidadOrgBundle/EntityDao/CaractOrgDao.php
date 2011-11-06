<?php
namespace MinSal\SidPla\UnidadOrgBundle\EntityDao;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\UnidadOrgBundle\Entity\FuncionEspecifica;

class CaractOrgDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaUnidadOrgBundle:CaractOrg');
    } 
    
    
    public function getCaractOrg($id) {	    
        $caractOrg=$this->repositorio->find($id);
        return $caractOrg;
    }
    
    public function updateCaractOrg($caractOrg) {
        
        $this->em->persist($caractOrg);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar la carcteristica termino con exito', 'Caract Org ');

        return $matrizMensajes;
    }
    
    public function agregarObjEspec($objetivo, $idCaractOrg,$anio) {
         
         $caractOrgAux=new CaractOrg();
         $caractOrgAux=$this->getCaractOrg($idCaractOrg); 
            
         $objEspec=new ObjetivoEspecifico();
         $objEspDao=new ObjetivoEspecificoDao($this->doctrine);
         $objEspec->setDescripcion($objetivo);                         
         $objEspec->setCaractOrg($caractOrgAux);
         $objEspec->setActivo(true);
         $caractOrgAux->addObjetivoEspecifico($objEspec);

         $this->em->persist($objEspec);
         $this->em->persist($caractOrgAux);
         $this->em->flush();
         $objEspDao->actualizaNomenclatura($idCaractOrg, $anio);
        
        $matrizMensajes = array('El proceso de ingresar objetivo especifico termino con exito ');

        return $matrizMensajes;
    }
    
      public function agregarFuncEspec($funcion, $idCaractOrg) {
         
         $caractOrgAux=new CaractOrg();
         $caractOrgAux=$this->getCaractOrg($idCaractOrg);          
         
         $funcionEspec=new FuncionEspecifica();
         $funcionEspec->setFuncDescripcion($funcion);
         $funcionEspec->setCaractOrg($caractOrgAux);

         $unidad=$caractOrgAux->getUnidadOrganizativa();

         $caractOrgAux->addFuncionesEspec($funcionEspec);

         $this->em->persist($funcionEspec);
         $this->em->persist($caractOrgAux);
         $this->em->flush();
        
        
        $matrizMensajes = array('El proceso de ingresar funcion especifica termino con exito ');

        return $matrizMensajes;
    }
    
    
}

?>
