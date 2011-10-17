<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion;

class AreaClasificacionDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:AreaClasificacion');
    }

    public function getAreaClasificacionEspecifico($codigo) {
        $areaClasifica = $this->repositorio->find($codigo);
        return $areaClasifica;
    }

    public function getAreaClasificacions() {
        $areaClasifica = $this->repositorio->findAll();
        return $areaClasifica;
    }

    public function addAreaClas($nombreArea) {

        $AreasClasificacion = new AreaClasificacion();

        $AreasClasificacion->setNombreArea($nombreArea);

        $this->em->persist($AreasClasificacion);
        $this->em->flush();
        $matrizMensajes = array('Proceso de almacenar Area de Clasificacion termino con exito',
            'Area clasificacion' . $AreasClasificacion->getCodArea());

        return $matrizMensajes;
    }

    public function editAreaClas($id, $nombreArea) {

        $AreasClasificacion = $this->getAreaClasificacionEspecifico($id);


        $AreasClasificacion->setNombreArea($nombreArea);

        $this->em->persist($AreasClasificacion);
        $this->em->flush();
        $matrizMensajes = array('Area de Clasificacion editada con exito', 'Area de clasificacion' . $AreasClasificacion->getCodArea());

        return $matrizMensajes;
    }

    public function delAreaClas($id) {

        $AreasClasificacion = $this->getAreaClasificacionEspecifico($id);

        $this->em->remove($AreasClasificacion);
        $this->em->flush();

        $matrizMensajes = array('Area de Clasificacion eliminada con exito', 'Area de clasificacion' . $AreasClasificacion->getCodArea());

        return $matrizMensajes;
    }

}

?>
