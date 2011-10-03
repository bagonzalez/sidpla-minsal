<?php

namespace MinSal\SidPla\DepUniBundle\EntityDao;

use MinSal\SidPla\DepUniBundle\Entity\RecursoHumano;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;
use MinSal\SidPla\DepUniBundle\EntityDao\DepartamentoUniDao;
use MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano;
use MinSal\SidPla\DepUniBundle\EntityDao\TipoRRHumanoDao;

class RecursoHumanoDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaDepUniBundle:RecursoHumano');
    }

    public function getRRHHEspecifico($codigo) {
        $RRHH = $this->repositorio->find($codigo);
        return $RRHH;
    }

    public function agregarRRHH($codDepUni, $codTipoRRHH, $cantRRHH, $descRRHH) {

        $depUniDao = new DepartamentoUniDao($this->doctrine);
        $depUni = $depUniDao->getDeptoUniEspecifico((int) $codDepUni);

        $tipoRRHHDao = new TipoRRHumanoDao($this->doctrine);
        $tipoRRHH = $tipoRRHHDao->getTipoRRHHEspecifico((int) $codTipoRRHH);

        $rrHH = new RecursoHumano();

        $rrHH->setCantidad($cantRRHH);
        $rrHH->setDeptoUnidadRRHH($depUni);
        $rrHH->setDescripcion($descRRHH);
        $rrHH->setTipoRRHH($tipoRRHH);

        $this->em->persist($rrHH);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el recurso humano termino con exito');

        return $matrizMensajes;
    }

    public function editarRRHH($codRRHH, $codDepUni, $codTipoRRHH, $cantRRHH, $descRRHH) {

        $depUniDao = new DepartamentoUniDao($this->doctrine);
        $depUni = $depUniDao->getDeptoUniEspecifico($codDepUni);

        $tipoRRHHDao = new TipoRRHumanoDao($this->doctrine);
        $tipoRRHH = $tipoRRHHDao->getTipoRRHHEspecifico($codTipoRRHH);

        $rrHH = $this->getRRHHEspecifico($codRRHH);

        $rrHH->setCantidad($cantRRHH);
        $rrHH->setDeptoUnidadRRHH($depUni);
        $rrHH->setDescripcion($descRRHH);
        $rrHH->setTipoRRHH($tipoRRHH);

        $this->em->persist($rrHH);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el recurso humano termino con exito');

        return $matrizMensajes;
    }

    public function eliminarRRHH($codRRHH) {

        $RRHH = $this->getRRHHEspecifico($codRRHH);

        $this->em->remove($RRHH);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar el tipo recurso humano termino con exito');

        return $matrizMensajes;
    }

    /* Obtener la suma del recurso humano de un determinado departamento */

    public function cuantoRRHH($codDepto) {
             
        $rsm = new ResultSetMapping;
        //$rsm->addEntityResult('MinSalSidPlaDepUniBundle:RecursoHumano', 'rh');
        //$rsm->addScalarResult('rechum_cantidad', 'cantidad');
        $query = $this->em->createNativeQuery('SELECT sum(rechum_cantidad)
                                               FROM sidpla_recursohumano
                                               WHERE depuni_codigo=?
                                               GROUP BY depuni_codigo', $rsm);
        $query->setParameter(1, $codDepto);
                
        return $query->getResult();
    }

}

?>
