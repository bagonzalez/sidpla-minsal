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
 * Description of RolDao
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class EmpleadoDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:Empleado');
    } 
    
    /*
     *  Obtiene todos los empleados.
     */    
    
    public function getEmpleados() {	    
        $empleados=$this->repositorio->findAll();
        return $empleados;
    }
    
    
    
    public function addEmpleado($dui,
                                $primerNombre,
                                $segundoNombre,
                                $primerApellido,
                                $segundoApellido,
                                $unidadAsignada) {
        
        $empleado=new Empleado();
        
        $empleado->setDui($dui);
        $empleado->setPrimerNombre($primerNombre);
        $empleado->setSegundoNombre($segundoNombre);
        $empleado->setPrimerApellido($primerApellido);
        $empleado->setSegundoApellido($segundoApellido);
        
        $unidadDao=new UnidadOrganizativaDao($this->doctrine);        
        $unidad=$unidadDao->getUnidadOrg($unidadAsignada);
        
        $empleado->setUnidadOrganizativa($unidad);
	    
        $this->em->persist($empleado);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar rol termino con exito', 'Empleado '.$empleado->getIdEmpleado());

        return $matrizMensajes;
    }
    
    public function delEmpleado($id){            
            
            $empleado=$this->repositorio->find($id);
            
            if(!$empleado){
                throw $this->createNotFoundException('No se encontro empleado con ese id '.$id);
            }
            
            $this->em->remove($empleado);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'Empleado '.$empleado->getIdEmpleado() );
 
            return $matrizMensajes;
    }
    
     public function editEmpleado($dui,
                                $primerNombre,
                                $segundoNombre,
                                $primerApellido,
                                $segundoApellido,
                                $id, 
                                $unidadAsignada){
            
            $empleado=new Empleado();            
            $empleado=$this->repositorio->find($id);
            
            if(!$empleado){
                throw $this->createNotFoundException('No se encontro empleado con ese id '.$id);
            }
            
            $empleado->setDui($dui);
            $empleado->setPrimerNombre($primerNombre);
            $empleado->setSegundoNombre($segundoNombre);
            $empleado->setPrimerApellido($primerApellido);
            $empleado->setSegundoApellido($segundoApellido);
            
            $unidadDao=new UnidadOrganizativaDao($this->doctrine);        
            $unidad=$unidadDao->getUnidadOrg($unidadAsignada);

            $empleado->setUnidadOrganizativa($unidad);
            
            $this->em->flush();            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Rol '.$rol->getIdRol());
 
            return $matrizMensajes;
        }
        
        
}

?>
