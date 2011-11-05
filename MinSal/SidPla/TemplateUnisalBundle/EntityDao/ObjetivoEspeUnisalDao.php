<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ProUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\AreaClasificacionDao;

class ObjetivoEspeUnisalDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal');
    }

    public function getObjetivoEspeUnisalEspecifico($codigo) {
        $objEspeUnisal = $this->repositorio->find($codigo);
        return $objEspeUnisal;
    }

    //SE OBTIENEN LOS OBJETIVOS EN UNA DETERMINADA AREA DE UN DETERMINADO ANIO
    public function obtenerPorArea($codArea, $anio) {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal', 'oeu');
        $rsm->addFieldResult('oeu', 'objespuni_codigo', 'codObjEspUni');
        $rsm->addFieldResult('oeu', 'objespuni_descripcion', 'descObjEspUni');
        $rsm->addFieldResult('oeu', 'objespuni_nomenclatura', 'nomenObjEspUni');
        $query = $this->em->createNativeQuery('SELECT 
                                                        oeu.objespuni_codigo, 
                                                        oeu.objespuni_descripcion, 
                                                        oeu.objespuni_nomenclatura
                                               FROM 
                                                        sidpla_areaclasificacion ac, 
                                                        sidpla_objetivoespeunisal oeu, 
                                                        sidpla_prounisaltemplate pu
                                               WHERE 
                                                        ac.arecla_codigo = oeu.arecla_codigo AND
                                                        pu.prounitem_codigo = oeu.prounitem_codigo AND
                                                        ac.arecla_codigo = ? AND 
                                                        pu.prounitem_anio = ?
                                               ORDER BY
                                                        oeu.objespuni_codigo ASC', $rsm);
        $query->setParameter(1, $codArea);
        $query->setParameter(2, $anio);
        $objetivos = $query->getResult();

        return $objetivos;
    }

    public function agregarObjTmp($idArea, $desObjEsp, $anio) {

        $proUnisalDao = new ProUnisalTemplateDao($this->doctrine);
        $proUnisal = $proUnisalDao->obtenerObjTempAnio($anio);

        $areaClasificaDao = new AreaClasificacionDao($this->doctrine);
        $areaClasificacion = $areaClasificaDao->getAreaClasificacionEspecifico($idArea);

        $objEspecUnisal = new ObjetivoEspeUnisal();

        $objEspecUnisal->setAreaClaObj($areaClasificacion);
        $objEspecUnisal->setDescObjEspUni($desObjEsp);
        $objEspecUnisal->setPrograMonObj($proUnisal);

        $this->em->persist($objEspecUnisal);
        $proUnisal->addObjeEspeProgra($objEspecUnisal);
        $this->em->persist($proUnisal);
        $areaClasificacion->addObjetivosObjeArea($objEspecUnisal);
        $this->em->persist($areaClasificacion);
        $this->em->flush();
        $this->actualizaNomenclatura($proUnisal->getCodProUniTem());
    }

    public function editarObjTmp($idObj, $desObjEsp) {

        $objEspecUnisal = $this->getObjetivoEspeUnisalEspecifico($idObj);
        $objEspecUnisal->setDescObjEspUni($desObjEsp);

        $this->em->persist($objEspecUnisal);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function actualizaNomenclatura($idProUnisal) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT "FN_ACTUALIZA_NOMENCLATURA"(?) resp', $rsm);
        $query->setParameter(1, $idProUnisal);

        $x = $query->getSingleScalarResult();
    }

}

?>
