<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\EntityDao;

use MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador;

class TipoIndicadorDao {
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaIndicadoresTemplateBundle:TipoIndicador');
    }
    
    public function getTipoIndicadorEspecifico($codigo) {
        $TipoIndicador = $this->repositorio->find($codigo);
        return $TipoIndicador;
    }
    
    public function getTipoIndicador() {
        $TipoIndicador = $this->repositorio->findAll();
        return $TipoIndicador;
    }
    
    public function agregarTipoIndicador($nombre) {

        $tipoIndicador = new TipoIndicador();
        
        $tipoIndicador->setNombreTipIndi($nombre);
        $this->em->persist($tipoIndicador);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }
    
    public function editarTipoIndicador($idTipInd,$nombre) {

        $tipoIndicador = $this->getTipoIndicadorEspecifico($idTipInd);
        
        $tipoIndicador->setNombreTipIndi($nombre);
        $this->em->persist($tipoIndicador);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }
}

?>
