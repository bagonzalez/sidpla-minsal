<?php

namespace MinSal\SidPla\GesObjEspBundle\EntityDao;

use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\GesObjEspBundle\Entity\Resultadore;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\ProgramacionMonitoreo;
use Doctrine\ORM\Query\ResultSetMapping;

class ResultadoEsperadoDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:ResultadoEsperado');
    }

    public function getResulEspera($id) {
        $ResulEsp = $this->repositorio->find($id);
        return $ResulEsp;
    }

    public function delResulEsp($id) {

        $Res = $this->repositorio->find($id);

        if (!$Res) {
            throw $this->createNotFoundException('No se encontro registro con ese id ' . $id);
        }

        $this->em->remove($Res);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

    public function editResulEsp($idResTempl, $idTipoMeta, $resEspeDesc, $resEspCondi, $resEspMetAnual, $resEspDescMetAnual, $resEspResponsable, $resEspEntidadControl, $resEspIndicador, $idobjetivo, $medioverificacion, $id) {


        $objResulesperado = new ResultadoEsperado();
        $objResulesperado = $this->repositorio->find($id);
        $objResulesperado->setIdResTempl($idResTempl);
        $objResulesperado->setIdTipoMeta($idTipoMeta);
        $objResulesperado->setResEspeDesc($resEspeDesc);
        $objResulesperado->setResEspCondi($resEspCondi);
        $objResulesperado->setResEspMetAnual($resEspMetAnual);
        $objResulesperado->setResEspDescMetAnual($resEspDescMetAnual);
        $objResulesperado->setResEspResponsable($resEspResponsable);
        $objResulesperado->setResEspEntidadControl($resEspEntidadControl);
        $objResulesperado->setResEspIndicador($resEspIndicador);
        $objResulesperado->setmedioVerificacion($medioverificacion);


        $this->em->flush();
        $matrizMensajes = array('El proceso de editar termino con exito');

        return $matrizMensajes;
    }

    public function agregarActividad($idfilaResultado, $tipometa, $actividad, $supuestosfactores, $metaAnual, $descripMetaAnual, $responsable, $indicador, $medioverifindicador, $costo) {


        $resultadoAux = new ResultadoEsperado();
        $resultadoAux = $this->getResulEspera($idfilaResultado);

        $objActividad = new Actividad();
        $objActividad->setIdTipoMeta($tipometa);
        $objActividad->setActDescripcion($actividad);
        $objActividad->setSupuestosFactores($supuestosfactores);
        $objActividad->setActMetaAnual($metaAnual);
        $objActividad->setActDescMetaAnu($descripMetaAnual);
        $objActividad->setActResponsable($responsable);
        $objActividad->setActIndicador($indicador);
        $objActividad->setIdTipoMedVeri($medioverifindicador);
        $objActividad->setIdResEsp($resultadoAux);
        $objActividad->setCosto($costo);

        $resultadoAux->addActividades($objActividad);

        $this->em->persist($objActividad);
        $this->em->persist($resultadoAux);
        $this->em->flush();


        // $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ','Resultado'.$objResulesperado->getIdResEsp());

        return $objActividad->getIdAct();
    }

    public function agregarResultadore($idResultadoEsp, $trimes, $trim, $programacionMonitoreo) {


        $resultadoAux = new ResultadoEsperado();
        $resultadoAux = $this->getResulEspera($idResultadoEsp);

        $objresultadore = new Resultadore();
        $objresultadore->setResultadoreTrimestre($trimes);
        $objresultadore->setResultadoreProgramado($trim);
        $objresultadore->setIdResEsp($resultadoAux);

        $objresultadore->setProgramacionMonitoreo($programacionMonitoreo);

        $programacionMonitoreo->addResultadores($objresultadore);

        $resultadoAux->addResultadore($objresultadore);

        $this->em->persist($objresultadore);
        $this->em->persist($resultadoAux);
        $this->em->persist($programacionMonitoreo);
        $this->em->flush();

        return $objresultadore->getIdResultadore();
    }

    public function consultarResultadosEntidadControl($idObj, $idUniOrg) {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:ResultadoEsperado', 'RE');
        $rsm->addFieldResult('RE', 'resesp_codigo', 'idResEsp');
        $rsm->addFieldResult('RE', 'tipometa_codigo', 'idTipoMeta');
        $rsm->addFieldResult('RE', 'reses_descripcion', 'resEspeDesc');
        $rsm->addFieldResult('RE', 'resesp_nomenclatura', 'resEspNomencl');
        $rsm->addFieldResult('RE', 'resesp_condicionanteres', 'EspCondi');
        $rsm->addFieldResult('RE', 'resesp_metanual', 'resEspMetAnual');
        $rsm->addFieldResult('RE', 'resesp_descripmetanual', 'resEspDescMetAnual');
        $rsm->addFieldResult('RE', 'resesp_responsable', 'resEspResponsable');
        $rsm->addFieldResult('RE', 'resesp_indicador', 'resEspIndicador');
        $rsm->addFieldResult('RE', 'resesp_medioverificacion', 'medioVerificacion');
        $query = $this->em->createNativeQuery('SELECT RE.resesp_codigo, RE.tipometa_codigo,RE.reses_descripcion,RE.resesp_nomenclatura,
                                                        RE.resesp_condicionante, RE.resesp_metanual, RE.resesp_descripmetanual,
                                                        RE.resesp_responsable,RE.resesp_indicador, RE.resesp_medioverificacion
                                               FROM sidpla_resultadoesperado RE
                                               WHERE RE.uniorg_codigo = ? AND RE.objesp_codigo = ?', $rsm);
        $query->setParameter(1, $idUniOrg);
        $query->setParameter(2, $idObj);
        $resultados = $query->getResult();

        return $resultados;
    }

    public function actualizaNomenclatura($idUniOrg, $anio) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT "FN_ACTUALIZA_NOMENCLATURA_ENT_IND"(?,?) resp', $rsm);
        $query->setParameter(1, $idUniOrg);
        $query->setParameter(2, $anio);

        $x = $query->getResult();
    }

}

?>
