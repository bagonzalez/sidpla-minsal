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
 * Description of OpcionSistemaDao
 *
 * @author Bruno González
 */


namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;

/*
 *  OpcionSistemaDao: Parte de la capa de Acceso a Datos, para separar la logica de
 *  Acceso a Datos 
 */

class OpcionSistemaDao 
{
	var $doctrine;
        var $repositorio;
        var $em;    

        function __construct($doctrine){ 
            $this->doctrine=$doctrine;      	
            $this->em=$this->doctrine->getEntityManager();
            $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:OpcionSistema');
        } 
   	
   	/*
   	 *  Agrega una nueva OpcionSistema a la base de datos, recibe como parametros
   	 *  los datos para el nuevo registro. 
   	 *  
   	 *  Retorna mensajes del sistema que indican si es exito o fracaso.
   	 */	

	public function addOpcion($nombreOpc, $descripcion, $enlace, $opcpadre) {
            
            $opcSistema=new OpcionSistema();            

            $opcSistema->setDescripcionOpcion($descripcion);
            $opcSistema->setEnlace($enlace);
            $opcSistema->setNombreOpcion($nombreOpc);
            
            if(intval($opcpadre)==0)
                $opcpadre=null;
            
            $opcSistema->setIdOpcionSistema2($opcpadre); 	    
	    
            $this->em->persist($opcSistema);
	    $this->em->flush();	    
	    $matrizMensajes = array('El proceso de almacenar termino con exito', 'Opcion '.$opcSistema->getIdOpcionSistema());
 
            return $matrizMensajes;
	}
        
         /*
         *  Obtiene todos los roles del sistema.
         */    

        public function getOpciones() {	    
            $opciones=$this->repositorio->findAll();
            return $opciones;
        }
        
        /*
         * Actualizar opcion
         */
        
        
        public function editOpcion($nombreOpc, $descripcion, $enlace, $id, $opcpadre){
            
            $opcion=new OpcionSistema();            
            $opcion=$this->repositorio->find($id);
            
            if(!$opcion){
                throw $this->createNotFoundException('No se encontro opcion con ese id '.$id);
            }
            
            $opcion->setDescripcionOpcion($descripcion);
            $opcion->setEnlace($enlace);
            $opcion->setNombreOpcion($nombreOpc);
            
            if(intval($opcpadre)==0)
                $opcpadre=null;
            
            $opcion->setIdOpcionSistema2($opcpadre);                
            
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Opcion '.$opcion->getIdOpcionSistema());
 
            return $matrizMensajes;
        }
        
        
        /*
         * eliminar opcion
         */
        
        
        public function delOpcion($id){            
            
            $opcion=$this->repositorio->find($id);
            
            if(!$opcion){
                throw $this->createNotFoundException('No se encontro opcion con ese id '.$id);
            }
            
            $this->em->remove($opcion);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'Opcion '.$opcion->getIdOpcionSistema());
 
            return $matrizMensajes;
        }
       
}
