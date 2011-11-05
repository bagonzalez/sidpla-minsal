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

    public function obtenerPorArea($codArea, $objetivosEspecificos) {
        $objEspe = new ObjetivoEspeUnisal();
        $i = 0;
        foreach ($objetivosEspecificos as $objEspe) {
            if ($objEspe->getAreaClaObj()->getCodArea() == $codArea) {
                $aux[$i] = $objEspe;
                $i++;
            }
        }
        if (isset($aux))
            return $aux;
        else
            return 0;
    }

    public function agregarObjTmp($idArea, $desObjEsp, $anio) {
        $proUnisalDao = new ProUnisalTemplateDao($this->doctrine);
        $proUnisalRes = $proUnisalDao->obtenerObjTempAnio($anio);

        $proUnisal = new ProUnisalTemplate();

        foreach ($proUnisalRes as $proUnisal) {
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

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');
       
        return $matrizMensajes;
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
