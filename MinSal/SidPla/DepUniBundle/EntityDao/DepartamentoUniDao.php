<?php

namespace MinSal\SidPla\DepUniBundle\EntityDao;

use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class DepartamentoUniDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaDepUniBundle:DepartamentoUni');
    }

    public function getDeptoUni() {
        $deptoUni = $this->repositorio->findAll();
        return $deptoUni->getResult();
    }

    public function getDeptoUniEspecifico($codigo) {
        $deptoUni = $this->repositorio->find($codigo);
        return $deptoUni;
    }

    public function agregarDeptoUni($nombreDeptoUni, $uniOrg) {

        $deptoUni = new DepartamentoUni();
        $deptoUni->setNombreDepto($nombreDeptoUni);
        $deptoUni->setUniOrgDep($uniOrg);

        $this->em->persist($deptoUni);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar la unidad del departamento  termino con exito');

        return $matrizMensajes;
    }

    public function editarDeptoUni($codigoDeptoUni, $nombreDeptoUni, $uniOrg) {

        $deptoUni = $this->getDeptoUniEspecifico($codigoDeptoUni);
        $deptoUni->setNombreDepto($nombreDeptoUni);
        $deptoUni->setUniOrgDep($uniOrg);

        $this->em->persist($deptoUni);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar la unidad del departamento termino con exito');

        return $matrizMensajes;
    }

    public function eliminarDeptoUni($codigoDeptoUni) {

        $deptoUni = $this->getDeptoUniEspecifico($codigoDeptoUni);

        $this->em->remove($deptoUni);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar la unidad del departamento termino con exito');

        return $matrizMensajes;
    }

    /* Para otras entidades */

    public function obtenerDeptoUni($uniOrg) {
        $cadena = "";

        $DeptoUni = $uniOrg->getDepartUnidades();
        $aux = new DepartamentoUni;
        $n = count($DeptoUni);

        $i = 1;

        foreach ($DeptoUni as $aux) {
            if ($i < $n)
                $cadena.=$aux->getCodDeptoUnidad() . ":" . $aux->getNombreDepto() . ';';
            else
                $cadena.=$aux->getCodDeptoUnidad() . ":" . $aux->getNombreDepto();
            $i++;
        }

        return $cadena;
    }



}

?>
