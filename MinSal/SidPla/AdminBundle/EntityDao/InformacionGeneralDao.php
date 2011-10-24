<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InformacionGeneralDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\AdminBundle\EntityDao;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;
class InformacionGeneralDao {
    //put your code here

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaAdminBundle:InformacionGeneral');
    }
    
    public function getInfoGeneral($id) {
        $infogeneral = $this->repositorio->find($id);
        return $infogeneral;
    }
    
    
    public function editarInfoGeneral($direccion,$telefono, $fax,$id) {



        $objinfogeneral=new InformacionGeneral();
         $objinfogeneral=$this->repositorio->find($id);
        $objinfogeneral->setDireccion($direccion);
        $objinfogeneral->setTelefono($telefono);
        $objinfogeneral->setFax($fax);
         
                 
        $this->em->flush();            
         $matrizMensajes = array('El proceso de editar termino con exito');
 
         return $matrizMensajes;
   }
   
}

?>
