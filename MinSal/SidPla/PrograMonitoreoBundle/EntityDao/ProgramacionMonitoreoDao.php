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
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo');
    }
    
    
    public function getActividades($idProgramon){
        
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:Actividad', 'a');
             $rsm->addFieldResult('a', 'actividad_codigo', 'idAct');
             $rsm->addFieldResult('a', 'actividad_descripcion', 'actDescripcion');
             $rsm->addFieldResult('a', 'activiadad_responsable', 'actResponsable');
             $query = $this->em->createNativeQuery('SELECT 
                      DISTINCT sidpla_actividad.actividad_codigo, 
                      sidpla_actividad.actividad_descripcion,   
                      sidpla_actividad.activiadad_responsable
                    FROM 
                      public.sidpla_programacionmonitoreo, 
                      public.sidpla_resultadoactvidad, 
                      public.sidpla_actividad
                    WHERE 
                      sidpla_programacionmonitoreo.promon_codigo = sidpla_resultadoactvidad.promon_codigo AND
                      sidpla_actividad.actividad_codigo = sidpla_resultadoactvidad.actividad_codigo AND
                      sidpla_programacionmonitoreo.promon_codigo=?' , $rsm);   
             $query->setParameter(1, $idProgramon);
             $actividades = $query->getResult();             
             
             return $actividades;
    }
    
}

?>
