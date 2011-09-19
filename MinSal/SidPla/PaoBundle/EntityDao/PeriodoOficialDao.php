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

    
    public function getPeriodoOficialEspecifico($codigo) {
        $periodoOficial = $this->repositorio->find($codigo);
        return $periodoOficial;
    }
    
    public function agregarPeriodoOficial($tipPerioPerOfi,$fechIniPerOfi,$fechFinPerOfi,$anioPerOfi,$activoPerOfi) {

        $periodoOficial= new PeriodoOficial();
        
        $periodoOficial->setActivoPerOfi($activoPerOfi);
        $periodoOficial->setAnioPerOfi($anioPerOfi);
        $periodoOficial->setFechFinPerOfi($fechFinPerOfi);
        $periodoOficial->setFechIniPerOfi($fechIniPerOfi);
        $idTipoPeriodo=(int) $tipPerioPerOfi;
        
        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
               
        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoEspecifico($idTipoPeriodo);
        $periodoOficial->settipPerioPerOfi($tipoPeriodo);

        $this->em->persist($periodoOficial);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
        public function editarPeriodoOficial($codPerOfi,$tipPerioPerOfi,$fechIniPerOfi,$fechFinPerOfi,$anioPerOfi,$activoPerOfi) {

        $periodoOficial= $this->getPeriodoOficialEspecifico($codPerOfi);
        
        $periodoOficial->setActivoPerOfi($activoPerOfi);
        $periodoOficial->setAnioPerOfi($anioPerOfi);
        $periodoOficial->setFechFinPerOfi($fechFinPerOfi);
        $periodoOficial->setFechIniPerOfi($fechIniPerOfi);
        $idTipoPeriodo=(int) $tipPerioPerOfi;
        
        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
               
        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoEspecifico($idTipoPeriodo);
        $periodoOficial->settipPerioPerOfi($tipoPeriodo);

        $this->em->persist($periodoOficial);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
        public function eliminarPeriodoOficial($codPerOfi) {

        $periodoOficial= $this->getPeriodoOficialEspecifico($codPerOfi);

        $this->em->remove($periodoOficial);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
    

}

?>