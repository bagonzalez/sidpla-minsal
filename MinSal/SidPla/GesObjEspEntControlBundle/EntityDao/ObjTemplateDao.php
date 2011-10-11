<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\EntityDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;

use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;

class ObjTemplateDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaGesObjEspEntControlBundle:ObjTemplate');
    }

    public function obtenerObjTempAnio($anio) {
        
        $objTmp= $this->em->createQuery("SELECT ot
                                         FROM MinSalSidPlaGesObjEspEntControlBundle:ObjTemplate ot
                                         WHERE ot.anioObjTemp = '".$anio."'");
        return $objTmp->getResult();
    }
    
    public function existeObjTmp($anio) {
        $unidadmedida = $this->em->createQuery("SELECT count(ot)
                                                FROM MinSalSidPlaGesObjEspEntControlBundle:ObjTemplate ot
                                                WHERE ot.anioObjTemp = '".$anio."'");
        return $unidadmedida->getSingleScalarResult();
    }
    
    public function agregarObjetivoTemplate($anio){
        $objTmp=new ObjTemplate;
        $objTmp->setAnioObjTemp($anio);
        
        $this->em->persist($objTmp);
        $this->em->flush();
        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');
        
        return $matrizMensajes;
        
    }
    public function agregarObjTmp($desObjEsp,$objTmp){
        $objEspTmp=new ObjespTemplate();
        $objEspTmp->setObjTmpEspe($objTmp);
        
        $objetivoEspecifico=new ObjetivoEspecifico();
        $objetivoEspecifico->setDescripcion($desObjEsp);
        $this->em->persist($objetivoEspecifico);
        $objEspTmp->setIdObjEspec($objetivoEspecifico);
        $this->em->persist($objEspTmp);
        
        $this->em->flush();
        
        
        
        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');
        
        return $matrizMensajes;
        
    }
    
    public function editarObjTmp($desObjEsp,$codObjEsp){
        
        $objEspDao = new ObjetivoEspecificoDao($this->doctrine);
        $objetivoEspecifico=$objEspDao->getObjetEspecif($codObjEsp);
        $objetivoEspecifico->setDescripcion($desObjEsp);
        
        $this->em->persist($objetivoEspecifico);
        $this->em->flush();
    
        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');
        return $matrizMensajes;
        
    }
    
    
    }

?>
