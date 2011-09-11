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

namespace MinSal\SidPla\UnidadOrgBundle\EntityDao;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;

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
 
}

?>
