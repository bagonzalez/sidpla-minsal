<?php
namespace MinSal\SidPla\PrograMonitoreoBundle\EntityDao;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;

use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResulActividadDao;

class CompromisoCumplimientoDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento');
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
    
    public function existeCompromisoCumplimiento($idResulAct) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('cuanto', 'cuanto');
        $query = $this->em->createNativeQuery('SELECT count(*) cuanto 
                                               FROM sidpla_compromisocumplimiento
                                               WHERE resact_codigo = ?', $rsm);
        $query->setParameter(1, $idResulAct);

        $x = $query->getResult();
        
        if($x[0]['cuanto']==0)
            return false;
        else
            return true;
    }
    
    
    public function getCompromisoCumplimientoEspecifico($codigo) {
        $compromisoCum = $this->repositorio->find($codigo);
        return $compromisoCum;
    }
     public function editCompromisoCumplimiento($idCompromiso, $hallazgos, $medidasadoptar, $fechacumplimiento, $responsable) {

        $comprocumpl=  $this->getCompromisoCumplimientoEspecifico($idCompromiso);
        $comprocumpl->setComproCumpliHallazgozEncontrados($hallazgos);
        $comprocumpl->setComproCumpliMedidaAdoptar($medidasadoptar);
        $comprocumpl->setComproCumpliResponsable($responsable);
        $comprocumpl->setComproCumpliFecha($fechacumplimiento);
       
        $this->em->persist($comprocumpl);
        $this->em->flush();
        //LE DEVUELVO EL OBJETO PORQUE NECESITO OCUPARLO PARA LA REPROGRAMACION
        return $comprocumpl;
    }
}

?>
