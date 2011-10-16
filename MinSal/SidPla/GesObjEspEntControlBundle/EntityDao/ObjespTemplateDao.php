<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ResEspTemplate;

class ObjespTemplateDao {
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspEntControlBundle:ObjespTemplate');
    } 
    
    public function getObjetivoTemplate($id) {	    
        $objetivotemplate=$this->repositorio->find($id);
        return $objetivotemplate;
    }
    
   
    public function agregarResulEsperadoTemplate($resEspeDesc,$resEspNomencl,$resEspIndicador, $idObjetivo) {
         
      
           $objetivoespecificoAux=new ObjespTemplate();
           $objetivoespecificoAux=$this->getObjetivoTemplate($idObjetivo); 
       // $tipometa=1;
        
           //$resEspNomencl="gfdsfsdf";
       // $resEspMetAnual=100;
       // $resEspDescMetAnual="ttttt";
       // $resEspResponsable="neto";
         $objResulesperado=new ResEspTemplate();
         $objResulesperado->setResEspTemplDescripcion($resEspeDesc);                         
         $objResulesperado->setResEspTemplIndicador($resEspIndicador);                         
         $objResulesperado->setIdObjEspecTempl($objetivoespecificoAux);
                 
         $objetivoespecificoAux->addResultadostemplate($objResulesperado);

         $this->em->persist($objResulesperado);
         $this->em->persist($objetivoespecificoAux);
         $this->em->flush();
        
        
       // $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ','Resultado'.$objResulesperado->getIdResEsp());

        return $objResulesperado->getIdResEspTempl();
    }
    
    
}

?>
