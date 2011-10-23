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
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;
use Doctrine\ORM\Query\ResultSetMapping;


class RolDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:RolSistema');
    } 
    
    /*
     *  Almacena un rol ingresado en el sistema
     */
    
    public function addRol($nombreRol, $funciones) {
        
        $rolSistema=new RolSistema();
        
        $rolSistema->setNombreRol($nombreRol);
        $rolSistema->setFuncionesRol($funciones);
	    
        $this->em->persist($rolSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar rol termino con exito', 'Rol '.$rolSistema->getIdRol());

        return $matrizMensajes;
    }
    
    /*
     *  Obtiene todos los roles del sistema.
     */    
    
    public function getRoles() {	    
        $roles=$this->repositorio->findAll();
        return $roles;
    }
    
     public function getRolEspecifico($id) {	    
        $rol=$this->repositorio->find($id);
        return $rol;
    }
    
    
        /*
         * Actualizar rol
         */
        
        
        public function editRol($nombre, $funciones, $id){
            
            $rol=new RolSistema();            
            $rol=$this->repositorio->find($id);
            
            if(!$rol){
                throw $this->createNotFoundException('No se encontro rol con ese id '.$id);
            }
            
            $rol->setFuncionesRol($funciones);
            $rol->setNombreRol($nombre);
            
            $this->em->flush();            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Rol '.$rol->getIdRol());
 
            return $matrizMensajes;
        }
        
         /*
         * eliminar rol
         */
        
        
        public function delRol($id){            
            
            $rol=$this->repositorio->find($id);
            
            if(!$rol){
                throw $this->createNotFoundException('No se encontro rol con ese id '.$id);
            }
            
            $this->em->remove($rol);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'Rol '.$rol->getIdRol());
 
            return $matrizMensajes;
        }
        
        /*
         * Consulta las opciones asignadas a un rol
         * 
         */
        
         public function consultarOpcSeleccRol($id){ 
             
             
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaAdminBundle:OpcionSistema', 'o');
             $rsm->addFieldResult('o', 'opcionsistema_codigo', 'idOpcionSistema');
             $rsm->addFieldResult('o', 'opcionsistema_nombre', 'nombreOpcion');
             $query = $this->em->createNativeQuery('SELECT opc.opcionsistema_codigo, opc.opcionsistema_nombre 
                                                    FROM sidpla_rol_opcion rolopc, sidpla_opcionsistema opc, sidpla_rol rol  
                                                    WHERE rol.rol_codigo=rolopc.rol_codigo AND opc.opcionsistema_codigo=rolopc.opcionsistema_codigo
                                                    AND rol.rol_codigo = ?' , $rsm);   
             $query->setParameter(1, $id);
             $opciones = $query->getResult();             
             
             return $opciones;
         }
         
         /*
          * Asigna una opcion seleccionada a un rol
          * 
          */
         
         public function insertOpcSeleccRol($idRol, $idOpc){ 
             
             $query = $this->em->getConnection()
                     ->executeUpdate('INSERT INTO sidpla_rol_opcion(
                                opcionsistema_codigo, rol_codigo)
                                VALUES ('.$idOpc.','.$idRol.' );');
         }
         
         /*
          * Elimina una opcion asignada a un rol
          */
         
         public function deleteOpcSeleccRol($idRol, $idOpc){ 
             
             $query = $this->em->getConnection()
                     ->executeUpdate('DELETE FROM sidpla_rol_opcion
                                      WHERE opcionsistema_codigo='.$idOpc.'  
                                      AND rol_codigo='.$idRol);  
         }
         
         /*
          *  Consulta las opciones no asignadas a un rol
          */
         
          public function consultarOpcNoSeleccRol($idRol){ 
             
             
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaAdminBundle:OpcionSistema', 'o');
             $rsm->addFieldResult('o', 'opcionsistema_codigo', 'idOpcionSistema');
             $rsm->addFieldResult('o', 'opcionsistema_nombre', 'nombreOpcion');
             $query = $this->em
                     ->createNativeQuery('SELECT opc.opcionsistema_codigo, opc.opcionsistema_nombre 
                                          FROM sidpla_opcionsistema opc
                                          WHERE opc.opcionsistema_codigo 
                                          NOT IN (SELECT opc.opcionsistema_codigo 
                                            FROM sidpla_rol_opcion rolopc, sidpla_rol rol 
                                            WHERE rol.rol_codigo=rolopc.rol_codigo AND opc.opcionsistema_codigo=rolopc.opcionsistema_codigo
                                            AND rol.rol_codigo=?)' , $rsm);   
             $query->setParameter(1, $idRol);
             $opciones = $query->getResult();             
             
             return $opciones;
         }
 
}

?>
