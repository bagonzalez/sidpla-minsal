<?php
namespace MinSal\SidPla\IndicadoresTemplateBundle\EntityDao;

use MinSal\SidPla\IndicadoresTemplateBundle\Entity\IndicadorSalud;
use MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador;

use MinSal\SidPla\IndicadoresTemplateBundle\EntityDao\IndicadorSaludDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;

class IndicadorSaludDao {
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaIndicadoresTemplateBundle:IndicadorSalud');
    }

    public function getIndicadorSaludEspecifico($codigo) {
        $indicadorSalud = $this->repositorio->find($codigo);
        return $indicadorSalud;
    }

    public function agregarIndicadorSalud($idObj,$idTipInd, $nombreIndSalud,$form1IndSalud,$form2IndSalud,$tipoEvalua, $numIndicadores) {

        $objEspUnidalDao = new ObjetivoEspeUnisalDao($this->doctrine);
        $objEspUnidal = $objEspUnidalDao->getObjetivoEspeUnisalEspecifico($idObj);
        
        
        $tipoIndicadorDao = new TipoIndicadorDao($this->doctrine);
        $tipoIndicador = $tipoIndicadorDao->getTipoIndicadorEspecifico($idTipInd);

        $indicadorSalud = new IndicadorSalud();
        $indicadorSalud->setForm1IndSalud($form1IndSalud);
        $indicadorSalud->setForm2IndSalud($form2IndSalud);
        $indicadorSalud->setNombreIndSalud($nombreIndSalud);
        $indicadorSalud->setTipoEvalua($tipoEvalua);
        $indicadorSalud->setCorrelativo($numIndicadores);
        
        $indicadorSalud->setTipoIndicador($tipoIndicador);
        $indicadorSalud->setObjEspUnisal($objEspUnidal);
        
        $this->em->persist($indicadorSalud);
        $objEspUnidal->addIndicadoresSalud($indicadorSalud);
        $tipoIndicador->addIndicadoresAsoc($indicadorSalud);
        $this->em->persist($objEspUnidal);
        $this->em->persist($tipoIndicador);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function editarIndicadorSalud($idIndSal,$idTipInd, $nombreIndSalud,$form1IndSalud,$form2IndSalud,$tipoEvalua, $correlativo) {

        $tipoIndicadorDao = new TipoIndicadorDao($this->doctrine);
        $tipoIndicador = $tipoIndicadorDao->getTipoIndicadorEspecifico($idTipInd);

        $indicadorSalud = $this->getIndicadorSaludEspecifico($idIndSal);
        $indicadorSalud->setForm1IndSalud($form1IndSalud);
        $indicadorSalud->setForm2IndSalud($form2IndSalud);
        $indicadorSalud->setNombreIndSalud($nombreIndSalud);
        $indicadorSalud->setTipoEvalua($tipoEvalua);
        $indicadorSalud->setCorrelativo($correlativo);
        
        $indicadorSalud->setTipoIndicador($tipoIndicador);
        
        
        $this->em->persist($indicadorSalud);
        $tipoIndicador->addIndicadoresAsoc($indicadorSalud);
        $this->em->persist($tipoIndicador);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

}

?>
