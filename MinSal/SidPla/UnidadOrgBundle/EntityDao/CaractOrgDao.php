<?php

/*
  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  
  
 */

/**
 * Description of CaractOrgDao
 *
 * @author Bruno González
 */

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
    
    public function agregarObjEspec($objetivo, $idCaractOrg) {
         
         $caractOrgAux=new CaractOrg();
         $caractOrgAux=$this->getCaractOrg($idCaractOrg); 
            
         $objEspec=new ObjetivoEspecifico();
         $objEspec->setDescripcion($objetivo);                         
         $objEspec->setCaractOrg($caractOrgAux);

         $caractOrgAux->addObjetivoEspecifico($objEspec);

         $this->em->persist($objEspec);
         $this->em->persist($caractOrgAux);
         $this->em->flush();
        
        
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
