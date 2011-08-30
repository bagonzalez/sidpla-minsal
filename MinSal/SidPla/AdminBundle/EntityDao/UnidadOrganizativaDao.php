<?php

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;
use MinSal\SidPla\AdminBundle\EntityDao\MunicipioDao;

/**
 * Description of UnidadOrganizativaDao
 *
 * @author bagonzalez
 */
class UnidadOrganizativaDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:UnidadOrganizativa');
    } 
    
    /*
     *  Obtiene todos las unidades organizativadel sistema.
     */    
    
    public function getUnidadesOrg() {	    
        $unidadesOrg=$this->repositorio->findAll();
        return $unidadesOrg;
    }
    
    /*
     * Insertar nueva unidad organizativa
     */
    
    public function ingresarUnidadOrg($nombreUnidad,
                                      $direccion,
                                      $responsable,
                                      $telefono,
                                      $fax,
                                      $tipoUnidad,
                                      $unidadPadre,
                                      $departameto,
                                      $municipio,
                                      $descripcion) {	    
        
        
         
        
        $municipioDao=new MunicipioDao($this->doctrine);
        $muncipioObj=$municipioDao->getMunicipio($municipio);
        
        
        $informacionGeneral=new InformacionGeneral();         
        $informacionGeneral->setDireccion($direccion);
        $informacionGeneral->setTelefono($telefono);
        $informacionGeneral->setFax($fax);
        
        
        $unidadOrg=new UnidadOrganizativa();
        $unidadOrg->setNombreUnidad($nombreUnidad);
        $unidadOrg->setTipoUnidad($tipoUnidad);
        
        if($unidadPadre!=0){
            $unidadParent=$this->repositorio->find($unidadPadre); 
            $unidadOrg->setParent($unidadParent);
        }        
        
        $unidadOrg->setIdMunicipio($municipio);        
        $unidadOrg->setInformacionGeneral($informacionGeneral);
        $unidadOrg->setDescripcionUnidad($descripcion);
        
        $informacionGeneral->setUnidadOrganizativa($unidadOrg);
        
        $this->em->persist($unidadOrg);	    
        $this->em->persist($informacionGeneral);        
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar Unidad Organizativa termino con exito', 'Unidad '.$unidadOrg->getIdUnidadOrg());
        
        return $matrizMensajes;

    }
    
    public function getUnidadOrg($id) {	    
        $unidadOrg=$this->repositorio->find($id);
        return $unidadOrg;
    }
}

?>
