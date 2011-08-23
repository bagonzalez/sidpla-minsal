<?php

namespace MinSal\SidPla\AdminBundle\EntityDao;

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
}

?>
