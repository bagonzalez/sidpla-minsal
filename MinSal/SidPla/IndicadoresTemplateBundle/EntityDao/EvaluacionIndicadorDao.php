<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvaluacionIndicadorDao
 *
 * @author edwin
 */
namespace MinSal\SidPla\IndicadoresTemplateBundle\EntityDao;
use MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador;
class EvaluacionIndicadorDao {
   var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaIndicadoresTemplateBundle:EvaluacionIndicador');
    }

    public function getEvaluacionIndicador($codigo) {
        $EvaluacionIndicador = $this->repositorio->find($codigo);
        return $EvaluacionIndicador;
    }
    
    public function editarEvaluacionIndicador($idEvaIndSal,$valor) {


        $EvaindicadorSalud = $this->getEvaluacionIndicador($idEvaIndSal);
        $EvaindicadorSalud->setResEvaInd($valor);
        $EvaindicadorSalud->setFechEvaInd(date("Y-m-d"));
       
      
        
        $this->em->persist($EvaindicadorSalud);
       
        $this->em->flush();

        $matrizMensajes = array('El proceso de editar la evaluacion del indicador termino con exito ');

        return $matrizMensajes;
    }
    
    
}

?>
