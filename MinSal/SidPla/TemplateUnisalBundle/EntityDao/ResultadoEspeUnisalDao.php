<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;
use Doctrine\ORM\Query\ResultSetMapping;

class ResultadoEspeUnisalDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal');
    }

    public function getResultadoEspeUnisalEspecifico($codigo) {
        $resulEspeUnisal = $this->repositorio->find($codigo);
        return $resulEspeUnisal;
    }

    public function resultadosPorObjetivo($idObjetivo) {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal', 'reu');
        $rsm->addFieldResult('reu', 'resulespuni_codigo', 'codResEspUni');
        $rsm->addFieldResult('reu', 'resulespuni_descripcion', 'descResEspUni');
        $rsm->addFieldResult('reu', 'resulespuni_nomenclatura', 'nomenResEspUni');
        $query = $this->em->createNativeQuery('SELECT 
                                                        reu.resulespuni_codigo, 
                                                        reu.resulespuni_descripcion, 
                                                        reu.resulespuni_nomenclatura
                                               FROM 
                                                        sidpla_objetivoespeunisal oeu, 
                                                        sidpla_resultadoespeunisal reu
                                               WHERE 
                                                        reu.objespuni_codigo = oeu.objespuni_codigo AND
                                                        oeu.objespuni_codigo = ?
                                               ORDER BY
                                                        reu.resulespuni_codigo ASC', $rsm);
        $query->setParameter(1, $idObjetivo);
        $resultados = $query->getResult();

        return $resultados;
    }

    public function agregarResultadoEsperado($idObj, $desRespEsp) {

        $objEspUnidalDao = new ObjetivoEspeUnisalDao($this->doctrine);
        $objEspUnidal = $objEspUnidalDao->getObjetivoEspeUnisalEspecifico($idObj);

        $resultaEspeUnisal = new ResultadoEspeUnisal();
        $resultaEspeUnisal->setDescResEspUni($desRespEsp);
        $resultaEspeUnisal->setObjEspRET($objEspUnidal);
        $this->em->persist($resultaEspeUnisal);
        $objEspUnidal->addResultEspObjT($resultaEspeUnisal);
        $this->em->persist($objEspUnidal);
        $this->em->flush();
        $objEspUnidalDao->actualizaNomenclatura($objEspUnidal->getPrograMonObj()->getCodProUniTem());
        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function editarResultadoEsperado($idRespEsp, $desRespEsp) {
        $resultaEspeUnisal = $this->getResultadoEspeUnisalEspecifico($idRespEsp);
        $resultaEspeUnisal->setDescResEspUni($desRespEsp);
        $this->em->persist($resultaEspeUnisal);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

}

?>
