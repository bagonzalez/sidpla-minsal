<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProgramacionMonitoreoDao
 *
 * @author edwin
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
    
    
    public function getActividades($idProgramon,$trim){
        
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:Actividad', 'a');
             $rsm->addFieldResult('a', 'actividad_codigo', 'idAct');
             $rsm->addFieldResult('a', 'actividad_descripcion', 'actDescripcion');
             $rsm->addFieldResult('a', 'activiadad_responsable', 'actResponsable');
             $rsm->addFieldResult('a', 'actividad_costo', 'costo');
             $rsm->addFieldResult('a', 'actividad_metanual', 'actMetaAnual');
             $rsm->addFieldResult('a', 'actividad_descripmetanual', 'actDescMetaAnu');
             $query = $this->em->createNativeQuery('SELECT 
                      DISTINCT sidpla_actividad.actividad_codigo, 
                      sidpla_actividad.actividad_descripcion,   
                      sidpla_actividad.activiadad_responsable,
                      sidpla_actividad.actividad_costo,
                      sidpla_actividad.actividad_metanual,
                      sidpla_actividad.actividad_descripmetanual
                    FROM 
                      public.sidpla_programacionmonitoreo, 
                      public.sidpla_resultadoactvidad, 
                      public.sidpla_actividad
                    WHERE 
                      sidpla_programacionmonitoreo.promon_codigo = sidpla_resultadoactvidad.promon_codigo AND
                      sidpla_actividad.actividad_codigo = sidpla_resultadoactvidad.actividad_codigo AND
                      sidpla_programacionmonitoreo.promon_codigo=? AND
                      sidpla_resultadoactvidad.resact_trimestre=?', $rsm);   
             $query->setParameter(1, $idProgramon);
             $query->setParameter(2, $trim);
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
                                     sidpla_resultadoactvidad.resact_real < sidpla_resultadoactvidad.resact_programado  AND 
                                     sidpla_programacionmonitoreo.promon_codigo = sidpla_resultadoactvidad.promon_codigo AND
                                      sidpla_actividad.actividad_codigo = sidpla_resultadoactvidad.actividad_codigo AND
                                      sidpla_programacionmonitoreo.promon_codigo=?  AND 
                                      sidpla_actividad.actividad_codigo=?
                                    ORDER BY sidpla_resultadoactvidad.resact_trimestre ', $rsm);   
             $query->setParameter(1, $idProgramon);
             $query->setParameter(2, $idActividad);
             $resultadoActividades = $query->getResult(); 
             
            
             
             return $resultadoActividades;
    }
    
    

   

}

?>
