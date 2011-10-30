<?php

namespace MinSal\SidPla\GesObjEspBundle\EntityDao;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;

class ResulActividadDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:ResulActividad');
    }

    public function getResulActividad($id) {
        $ResultEsp = $this->repositorio->find($id);
        return $ResultEsp;
    }

    public function guardarResulAct($resulAct) {
        $this->em->persist($resulAct);
        $this->em->flush();
    }

    public function delResulActividad($id) {

        $Res = $this->repositorio->find($id);

        if (!$Res) {
            throw $this->createNotFoundException('No se encontro registro con ese id ' . $id);
        }

        $this->em->remove($Res);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

    public function editResulActividad($trim, $id, $fechainicio, $fechafin) {

        $objResultadore = new ResulActividad();
        $objResultadore = $this->repositorio->find($id);
        $objResultadore->setResulActProgramado($trim);
        $objResultadore->setResulActFechaInicio($fechainicio);
        $objResultadore->setResulActFechaFin($fechafin);
        $this->em->flush();
        $matrizMensajes = array('El proceso de editar termino con exito');

        return $matrizMensajes;
    }

    public function addCompromisoCumplimiento($hallazgos, $medidasadoptar, $fechacumplimiento, $responsable, $idResultActividad) {

        $resultProMon = new ResulActividad();
        $resultProMon = $this->getResulActividad($idResultActividad);



        $comprocumpl = new CompromisoCumplimiento();
        $comprocumpl->setComproCumpliHallazgozEncontrados($hallazgos);
        $comprocumpl->setComproCumpliMedidaAdoptar($medidasadoptar);
        $comprocumpl->setComproCumpliResponsable($responsable);
        $comprocumpl->setComproCumpliFecha($fechacumplimiento);
        $comprocumpl->setIdResActividad($resultProMon);

        $resultProMon->addCompromisoCumplimiento($comprocumpl);

        $this->em->persist($comprocumpl);
        $this->em->persist($resultProMon);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar terminoexito', 'compro' . $comprocumpl->getIdComproCumpl());

        return $matrizMensajes;
    }

    public function consultarResulActPorTrim($trimestre,$idAct) {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:ResulActividad', 're');
        $rsm->addFieldResult('re', 'resact_codigo', 'idResulAct');
        $rsm->addFieldResult('re', 'resact_programado', 'resulActProgramado');
        $rsm->addFieldResult('re', 'resact_trimestre', 'resulActTrimestre');
        $rsm->addFieldResult('re', 'resact_fechainicio', 'resulActFechaInicio');
        $rsm->addFieldResult('re', 'resact_fechafin', 'resulActFechaFin');
        $query = $this->em->createNativeQuery('SELECT  re.resact_codigo,re.resact_programado,re.resact_trimestre,re.resact_fechainicio,re.resact_fechafin
                                               FROM sidpla_resultadoactvidad re
                                               WHERE re.actividad_codigo = ? AND re.resact_trimestre = ?', $rsm);
        $query->setParameter(1, $idAct);
        $query->setParameter(2, $trimestre);
        $resultadoAct = $query->getResult();

        return $resultadoAct[0];
    }

}

?>
