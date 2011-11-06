<?php
namespace MinSal\SidPla\UnidadOrgBundle\EntityDao;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\EntityDao\TipoMetaDao;
use MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta;
/**
 * Description of ObjetivoEspecificoDao
 *
 * @author Bruno González
 */
class ObjetivoEspecificoDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
    
       function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaUnidadOrgBundle:ObjetivoEspecifico');
    } 
    
     public function getObjetEspecif($id) {	    
        $objeEspec=$this->repositorio->find($id);
        return $objeEspec;
    }
    
    public function delObjEspec($id){            

        $obj=$this->repositorio->find($id);

        if(!$obj){
            throw $this->createNotFoundException('No se encontro registro con ese id '.$id);
        }

        $this->em->remove($obj);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    
    public function editObjEspec($objetivo, $id){  
            
        $objEspec=new ObjetivoEspecifico();
         $objEspec=$this->repositorio->find($id);
         $objEspec->setDescripcion($objetivo);                                   
            
         $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
   }
   
   
   public function agregarResulEsperado($idResTempl,
                                        $tipometa,
                                        $resEspeDesc,
                                        $resEspCondi,
                                        $resEspMetAnual,
                                        $resEspDescMetAnual,
                                        $resEspResponsable,
                                        $resEspEntidadControl,
                                        $resEspIndicador,
                                        $idObjetivo,
                                        $medioverificacion,
                                        $unidadOrganizativa) {
         
      
         $objetivoespecificoAux=new ObjetivoEspecifico();
         $objetivoespecificoAux=$this->getObjetEspecif($idObjetivo); 

         $objResulesperado=new ResultadoEsperado();
                            
         $objResulesperado->setIdTipoMeta($tipometa);                         
         $objResulesperado->setResEspeDesc($resEspeDesc);                         
         $objResulesperado->setResEspCondi($resEspCondi);                         
         $objResulesperado->setResEspMetAnual($resEspMetAnual);                         
         $objResulesperado->setResEspDescMetAnual($resEspDescMetAnual);                         
         $objResulesperado->setResEspResponsable($resEspResponsable);                         
         $objResulesperado->setResEspEntidadControl($resEspEntidadControl);
         $objResulesperado->setResEspIndicador($resEspIndicador);
         $objResulesperado->setmedioVerificacion($medioverificacion);
         $objResulesperado->setIdObjEsp($objetivoespecificoAux);
         $objResulesperado->setUnidadOrganizativa($unidadOrganizativa);
                 
         $objetivoespecificoAux->addResultadoEsperado($objResulesperado);

         $this->em->persist($objResulesperado);
         $this->em->persist($objetivoespecificoAux);
         $this->em->flush();
        
       return $objResulesperado->getIdResEsp();
    }
 
}

?>
