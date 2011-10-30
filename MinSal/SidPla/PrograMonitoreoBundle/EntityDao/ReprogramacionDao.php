<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Collections\ArrayCollection;

class ReprogramacionDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPrograMonitoreoBundle:Reprogramacion');
    }

    public function getReprogramacionEspecifico($codigo) {
        $reprogramacion = $this->repositorio->find($codigo);
        return $reprogramacion;
    }
    /*
     public function agregarElementoInfra($nomElemInfra, $abreElemInfra, $descElemInfra) {

        $elemInfra = new ElementoInfraestructura();
        $elemInfra->setNomElemInfra($nomElemInfra);
        $elemInfra->setElemInfraDescrip($descElemInfra);

        $unidadMedidaDao = new UnidadMedidaDao($this->doctrine);
        $unidadMedida = $unidadMedidaDao->getUnidadMedidaEspecifica($abreElemInfra);
        $elemInfra->setCodUnidadMed($unidadMedida);

        $this->em->persist($elemInfra);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar elementos de infraestructura termino con exito');

        return $matrizMensajes;
    }


    public function editarElementoInfra($codElemInfra, $nomElemInfra, $abreElemInfra, $descElemInfra) {

        $elemInfra = $this->getElementoInfraestructuraEspecifico($codElemInfra);
        $elemInfra->setNomElemInfra($nomElemInfra);

        $unidadMedidaDao = new UnidadMedidaDao($this->doctrine);
        $unidadMedida = $unidadMedidaDao->getUnidadMedidaEspecifica($abreElemInfra);
        $elemInfra->setCodUnidadMed($unidadMedida);


        $elemInfra->setElemInfraDescrip($descElemInfra);


        $this->em->persist($elemInfra);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el elemento de infraestructura termino con exito');

        return $matrizMensajes;
    }

    public function eliminarElementoInfra($codigo) {

        $elementoinfra = $this->repositorio->find($codigo);

        $this->em->remove($elementoinfra);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    } 
     */

}

?>
