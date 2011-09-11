<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;
use Doctrine\ORM\Query\ResultSetMapping;

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
       $periodoOficial = $this->repositorio->findAll();
       return  $periodoOficial;
        
        /* $PeriodosOficiales = $this->em->createQuery("select po
                                                 from MinSalSidPlaPaoBundle:PeriodoOficial po 
                                                 order by po.idPerOfi ASC");
        return $PeriodosOficiales->getResult();*/
    }
    /*
      public function getTipoPeriodoEspecifico($codigo) {
        $tiposPeriodos = $this->repositorio->find($codigo);
        return  $tiposPeriodos;
    }

    
     
     
     
    public function addTipoPeriodo($nomTipPer, $descTipPer,$actTipPer) {

        $tipoPeriodo= new TipoPeriodo();
         
        $tipoPeriodo->setActivoTipPer($actTipPer);
        $tipoPeriodo->setDescTipPer($descTipPer);
        $tipoPeriodo->setNomTipPer($nomTipPer);
        $tipoPeriodo->setUsuarioTipPer(true);

      
        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }

    public function editTipoPeriodo($codTipPer, $nomTipPer, $descTipPer,$actTipPer) {
        
        $tipoPeriodo= $this->getTipoPeriodoEspecifico($codTipPer);
        $tipoPeriodo->setDescTipPer($descTipPer);
        $tipoPeriodo->setNomTipPer($nomTipPer);
        $tipoPeriodo->setActivoTipPer($actTipPer);
        
        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
    public function delTipoPeriodo($codigo) {

        $notificacionSistema = $this->repositorio->find($codigo);

        $this->em->remove($notificacionSistema);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }
*/

}

?>


