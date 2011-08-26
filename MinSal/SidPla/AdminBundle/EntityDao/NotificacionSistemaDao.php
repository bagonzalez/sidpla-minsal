<?php
namespace MinSal\SidPla\AdminBundle\EntityDao;

class NotificacionSistemaDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:NotificacionSistema');
    } 
    
    /*
     *  Obtiene todos las unidades organizativadel sistema.
        
    */
    public function getNotiSistema() {	    
        $notificaciones=$this->repositorio->findAll();
        return $notificaciones;
    }
}

?>
