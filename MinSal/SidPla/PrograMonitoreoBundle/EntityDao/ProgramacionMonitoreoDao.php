<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ActividadUniSalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal;

/**
 * Description of ProgramacionMonitoreoDao
 *
 * @author bagonzalez
 */
class ProgramacionMonitoreoDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo');
    }

    public function getActividades($idProgramon) {

        $rsm = new ResultSetMapping;
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
                      sidpla_programacionmonitoreo.promon_codigo=?', $rsm);
        $query->setParameter(1, $idProgramon);
        $actividades = $query->getResult();

        return $actividades;
    }

    public function getActividadesUniSal($idProgramon) {


        $actividadesUniSal = new ArrayCollection();

        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaTemplateUnisalBundle:ActividadUniSal', 'a');
        $rsm->addFieldResult('a', 'actuni_codigo', 'codActUni');
        $rsm->addFieldResult('a', 'actuni_responsable', 'responsableActUni');
        $query = $this->em->createNativeQuery('SELECT 
                          sidpla_actividadunisal.actuni_codigo,
                          sidpla_actividadunisal.actuni_responsable
                        FROM 
                          public.sidpla_actividadunisal, 
                          public.sidpla_actividadunisaltemplate, 
                          public.sidpla_programacionmonitoreo
                        WHERE 
                          sidpla_actividadunisaltemplate.actunitem_codigo = sidpla_actividadunisal.actunitem_codigo AND
                          sidpla_programacionmonitoreo.promon_codigo = sidpla_actividadunisal.promon_codigo AND
                          sidpla_programacionmonitoreo.promon_codigo=?', $rsm);
        $query->setParameter(1, $idProgramon);
        $actividades = $query->getResult();

        $actDao = new ActividadUniSalDao($this->doctrine);

        foreach ($actividades as $actividad) {
            $actividadesUniSal[] = $actDao->getActividadUniSal($actividad->getCodActUni());
            $actividadUnisalotra = $actDao->getActividadUniSal($actividad->getCodActUni());
            $temp = $actividadUnisalotra->getActTemp();
        }

        return $actividadesUniSal;
    }

    public function getProgramacionActividad($idProgramon, $idActividad) {

        $rsm = new ResultSetMapping;
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
                                      sidpla_actividad.actividad_codigo=?
                                    ORDER BY sidpla_resultadoactvidad.resact_trimestre ', $rsm);
        $query->setParameter(1, $idProgramon);
        $query->setParameter(2, $idActividad);
        $resultadoActividades = $query->getResult();



        return $resultadoActividades;
    }

    public function trimestrePao() {
        $mes = date('m');
        if ($mes >= 1 & $mes <= 3)
            return 1;
        else
        if ($mes >= 3 & $mes <= 6)
            return 2;
        else
        if ($mes >= 3 & $mes <= 9)
            return 3;
        else
            return 4;
    }

}

?>
