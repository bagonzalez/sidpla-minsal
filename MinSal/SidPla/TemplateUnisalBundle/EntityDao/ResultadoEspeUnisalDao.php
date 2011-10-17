<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal;
use \MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use \MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;

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

    public function agregarResultadoEsperado($idObj, $desRespEsp) {

        $objEspUnidal = new ObjetivoEspeUnisal();

        $objEspUnidalDao = new ObjetivoEspeUnisalDao($this->doctrine);
        $objEspUnidal = $objEspUnidalDao->getObjetivoEspeUnisalEspecifico($idObj);

        $resultaEspeUnisal = new ResultadoEspeUnisal();
        $resultaEspeUnisal->setDescResEspUni($desRespEsp);
        $resultaEspeUnisal->setObjEspRET($objEspUnidal);
        $this->em->persist($resultaEspeUnisal);
        $objEspUnidal->addResultEspObjT($resultaEspeUnisal);
        $this->em->persist($objEspUnidal);
        $this->em->flush();

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
