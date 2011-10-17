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

   
    public function getPeriodoPaoEspecifico($codigo) {
        $periodoPao = $this->repositorio->find($codigo);
        return $periodoPao;
    }
    
    public function editarPeriodoOficial($codPerPao,$tipPerioPerPao,$fechIniPerPao,$fechFinPerPao) {

        $periodoPao= $this->getPeriodoPaoEspecifico($codPerPao);
        
        $periodoPao->setFechIniPerPao($fechIniPerPao);
        $periodoPao->setFechFinPerPao($fechFinPerPao);
        $idTipoPeriodo=(int) $tipPerioPerPao;
        
        $tipoPeriodoDao = new TipoPeriodoDao($this->doctrine);
               
        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodoEspecifico($idTipoPeriodo);
        $periodoPao->setTipPeriodoPerPao($tipoPeriodo);
        

        $this->em->persist($periodoPao);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
     public function getMinFechaPao($idPao) {         
      
         $qb = $this->em->createQueryBuilder();
         $qb->select($qb->expr()->min('p.fechIniPerPao'))
            ->from('MinSalSidPlaPaoBundle:PeriodoPao', 'p')
            ->join('p.paoPerPao','pao')
            ->where('pao.idPao = ?1')            
            ->setParameter(1, $idPao);
         
         $query = $qb->getQuery();
         $result = $query->getResult();
             
        return $result;
    }
    
     public function getMaxFechaPao($idPao) {         
      
         $qb = $this->em->createQueryBuilder();
         $qb->select($qb->expr()->max('p.fechIniPerPao'))
            ->from('MinSalSidPlaPaoBundle:PeriodoPao', 'p')
            ->join('p.paoPerPao','pao')
            ->where('pao.idPao = ?1')            
            ->setParameter(1, $idPao);
         
         $query = $qb->getQuery();
         $result = $query->getResult();
             
        return $result;
    }
    
    public function getMinFechaSeguimientoPao($idPao) {         
      
         $qb = $this->em->createQueryBuilder();
         $qb->select($qb->expr()->min('p.fechIniPerPao'))
            ->from('MinSalSidPlaPaoBundle:PeriodoPao', 'p')
            ->join('p.paoPerPao','pao')
            ->join('p.tipPeriodoPerPao','tipop')      
            ->where('pao.idPao = ?1', 'tipop.idTipPer=3')            
            ->setParameter(1, $idPao);
         
         $query = $qb->getQuery();
         $result = $query->getResult();
             
        return $result;
    }
    
    
    public function getMaxFechaSeguimientoPao($idPao) {         
      
         $qb = $this->em->createQueryBuilder();
         $qb->select($qb->expr()->min('p.fechIniPerPao'))
            ->from('MinSalSidPlaPaoBundle:PeriodoPao', 'p')
            ->join('p.paoPerPao','pao')            
            ->join('p.tipPeriodoPerPao','tipop')      
            ->where('pao.idPao = ?1', 'tipop.idTipPer=3')            
            ->setParameter(1, $idPao);
         
         $query = $qb->getQuery();
         $result = $query->getResult();
             
        return $result;
    }
    
}

?>
