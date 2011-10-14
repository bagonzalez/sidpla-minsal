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
    
    
    public function getProgramacionActividad($idProgramon, $idActividad){
        
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:ResulActividad', 'a');
             $rsm->addFieldResult('a', 'resact_codigo', 'idResulAct');
             $rsm->addFieldResult('a', 'resact_fechainicio', 'resulActFechaInicio');
             $rsm->addFieldResult('a', 'resact_fechafin', 'resulActFechaFin');
             $rsm->addFieldResult('a', 'resact_programado', 'resulActProgramado');
             $rsm->addFieldResult('a', 'resact_real', 'resulActRealizado');
             $rsm->addFieldResult('a', 'resact_trimestre', 'resulActTrimestre');             
             $rsm->addFieldResult('a', 'resact_costoprogramado', 'costoProgramado');
             $rsm->addFieldResult('a', 'resact_costoreal', 'costoReal');
             $query = $this->em->createNativeQuery('SELECT 
                                      sidpla_resultadoactvidad.resact_codigo,       
                                      sidpla_resultadoactvidad.resact_fechainicio,      
                                      sidpla_resultadoactvidad.resact_fechafin,
                                      sidpla_resultadoactvidad.resact_programado,
                                      sidpla_resultadoactvidad.resact_real,
                                      sidpla_resultadoactvidad.resact_trimestre,
                                      sidpla_resultadoactvidad.resact_costoprogramado,      
                                      sidpla_resultadoactvidad.resact_costoreal
                                    FROM 
                                      public.sidpla_programacionmonitoreo, 
                                      public.sidpla_resultadoactvidad, 
                                      public.sidpla_actividad
                                    WHERE 
                                      sidpla_programacionmonitoreo.promon_codigo = sidpla_resultadoactvidad.promon_codigo AND
                                      sidpla_actividad.actividad_codigo = sidpla_resultadoactvidad.actividad_codigo AND
                                      sidpla_programacionmonitoreo.promon_codigo=?  AND 
                                      sidpla_actividad.actividad_codigo=?' , $rsm);   
             $query->setParameter(1, $idProgramon);
             $query->setParameter(2, $idActividad);
             $resultadoActividades = $query->getResult();             
             
             return $resultadoActividades;
    }
    
}

?>
