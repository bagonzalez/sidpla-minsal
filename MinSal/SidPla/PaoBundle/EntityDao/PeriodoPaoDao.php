<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\PeriodoPao;
use Doctrine\ORM\Query\ResultSetMapping;

//Para obtener el listado de Tipos de Periodos Habilitados
use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;
use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;

//Para obtener la PAO relacionada
use MinSal\SidPla\PaoBundle\EntityDao\PaoDao;
use MinSal\SidPla\PaoBundle\Entity\Pao;


class PeriodoPaoDao {
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPaoBundle:PeriodoPao');
    }

    public function getPeriodoPao($anio) {
        
        $paoDao=new PaoDao($this->doctrine);
        $paos=$paoDao->obtenerPaoAnio($anio);
        
        
        
        $periodoPao = $this->em->createQuery("select pp
                                              from MinSalSidPlaPaoBundle:PeriodoPao pp
                                              where pp.paoPerPao IN (".$paos.") 
                                              order by pp.codPerPao ASC");
        return $periodoPao->getResult();
    }

    
    public function getPeriodoPaoEspecifico($codigo) {
        $periodoPao = $this->repositorio->find($codigo);
        return $periodoPao;
    }
}

?>
