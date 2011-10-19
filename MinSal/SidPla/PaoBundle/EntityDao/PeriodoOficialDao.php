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

    public function getPeriodoOficial($anio) {
        $PeriodosOficiales = $this->em->createQuery("SELECT po
                                                 FROM MinSalSidPlaPaoBundle:PeriodoOficial po
                                                 WHERE po.anioPerOfi=" . $anio . " 
                                                 ORDER BY po.idPerOfi ASC");
        return $PeriodosOficiales->getResult();
    }

    public function getPeriodoOficialEspecifico($codigo) {
        $periodoOficial = $this->repositorio->find($codigo);
        return $periodoOficial;
    }

    public function agregarPeriodoOficial($tipPerioPerOfi, $fechIniPerOfi, $fechFinPerOfi, $anioPerOfi, $activoPerOfi) {

        $periodoOficial = new PeriodoOficial();

        $periodoOficial->setActivoPerOfi($activoPerOfi);
        $periodoOficial->setAnioPerOfi($anioPerOfi);
        if ($fechFinPerOfi != 0)
            $periodoOficial->setFechFinPerOfi($fechFinPerOfi);
        if ($fechIniPerOfi != 0)
            $periodoOficial->setFechIniPerOfi($fechIniPerOfi);
        $idTipoPeriodo = (int) $tipPerioPerOfi;

        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);

        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoEspecifico($idTipoPeriodo);
        $periodoOficial->settipPerioPerOfi($tipoPeriodo);

        $this->em->persist($periodoOficial);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }

    public function editarPeriodoOficial($codPerOfi, $tipPerioPerOfi, $fechIniPerOfi, $fechFinPerOfi, $anioPerOfi, $activoPerOfi) {

        $periodoOficial = $this->getPeriodoOficialEspecifico($codPerOfi);

        $periodoOficial->setActivoPerOfi($activoPerOfi);
        $periodoOficial->setAnioPerOfi($anioPerOfi);
        $periodoOficial->setFechFinPerOfi($fechFinPerOfi);
        $periodoOficial->setFechIniPerOfi($fechIniPerOfi);
        $idTipoPeriodo = (int) $tipPerioPerOfi;

        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);

        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoEspecifico($idTipoPeriodo);
        $periodoOficial->settipPerioPerOfi($tipoPeriodo);

        $this->em->persist($periodoOficial);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }

    public function eliminarPeriodoOficial($codPerOfi) {

        $periodoOficial = $this->getPeriodoOficialEspecifico($codPerOfi);

        $this->em->remove($periodoOficial);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

    public function existePeriodoOfi($anio) {
        $periodoOfic = $this->em->createQuery("SELECT count(po)
                                                FROM MinSalSidPlaPaoBundle:PeriodoOficial po
                                                WHERE po.anioPerOfi='" . $anio . "'");
        return $periodoOfic->getSingleScalarResult();
    }

    public function crearPeriodoOficial($anio) {

        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
        $aux = new TipoPeriodo();
        $tiposExistentes = $tipoPeriodoDao->getTipoPeriodo();

        foreach ($tiposExistentes as $aux) {
            $this->agregarPeriodoOficial($aux->getIdTipPer(), 0, 0, $anio, TRUE);
        }
    }

    public function crearPao($anio) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT "PRC_CREAR_PAO"(?) resp', $rsm);
        $query->setParameter(1, $anio);

        $x = $query->getResult();
    }

}

?>