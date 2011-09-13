<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;
use Doctrine\ORM\Query\ResultSetMapping;
//Para obtener el listado de Tipos de Periodos Habilitados
use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;
use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;

class PeriodoOficialDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPaoBundle:PeriodoOficial');
    }

    public function getPeriodoOficial() {
        $PeriodosOficiales = $this->em->createQuery("select po
                                                 from MinSalSidPlaPaoBundle:PeriodoOficial po 
                                                 order by po.idPerOfi ASC");
        return $PeriodosOficiales->getResult();
    }

    public function obtenerTiposPeriodos() {

        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoActivo();

        $aux = new TipoPeriodo();
        $n = $tipoPeriodoDao->cuentosTiposPeriodosActivos();
        $i = 1;
        $cadena = '';
        foreach ($tipoPeriodo as $aux) {
            if ($i < $n)
                $cadena .=$aux->getIdTipPer().":".$aux->getNomTipPer().';';
            else
                $cadena .=$aux->getIdTipPer().":".$aux->getNomTipPer();
            $i++;
        }

        return $cadena;
    }
    
    public function addPeriodoOficial($nomTipPer, $descTipPer, $actTipPer) {

        $periodoOficial= new PeriodoOficial();
        
        $periodoOficial->setActivoPerOfi($activoPerOfi);
        $periodoOficial->setAnioPerOfi($anioPerOfi);
        $periodoOficial->setFechFinPerOfi($fechFinPerOfi);
        $periodoOficial->setFechIniPerOfi($fechIniPerOfi);
        
        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
        $tipPerioPerOfi = $tipoPeriodoDao->getTipoPeriodoEspecifico($codTipoPeriodo);
        $periodoOficial->settipPerioPerOfi($tipPerioPerOfi);

        


        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }

}

?>