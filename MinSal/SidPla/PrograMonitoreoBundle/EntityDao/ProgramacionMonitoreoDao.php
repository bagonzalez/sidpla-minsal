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

namespace MinSal\SidPla\PrograMonitoreoBundle\EntityDao;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Description of ProgramacionMonitoreoDao
 *
 * @author bagonzalez
 */
class ProgramacionMonitoreoDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:Actividad');
    }
    
    
    public function getActividades(){
        
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:Actividad', 'a');
             $rsm->addFieldResult('a', 'opcionsistema_codigo', 'idOpcionSistema');
             $rsm->addFieldResult('a', 'opcionsistema_nombre', 'nombreOpcion');
             $query = $this->em->createNativeQuery('SELECT opc.opcionsistema_codigo, opc.opcionsistema_nombre 
                                                    FROM sidpla_rol_opcion rolopc, sidpla_opcionsistema opc, sidpla_rol rol  
                                                    WHERE rol.rol_codigo=rolopc.rol_codigo AND opc.opcionsistema_codigo=rolopc.opcionsistema_codigo
                                                    AND rol.rol_codigo = ?' , $rsm);   
             $query->setParameter(1, $id);
             $opciones = $query->getResult();             
             
             return $opciones;
    }
    
}

?>
