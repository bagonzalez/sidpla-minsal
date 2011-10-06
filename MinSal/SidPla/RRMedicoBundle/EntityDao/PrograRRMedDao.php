<?php

namespace MinSal\SidPla\RRMedicoBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed;

class PrograRRMedDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaRRMedicoBundle:PrograRRMed');
    }

    /*
     * Obtiene una Resultado RRMed
     */

    public function getPrograEspecifico($codigo) {
        $prograRRMed = $this->repositorio->find($codigo);
        return $prograRRMed;
    }

    public function editarPrograRRMed($codProgra) {
        $prograRRMed = new PrograRRMed();
        $prograRRMed = $this->getPrograEspecifico($codProgra);

        $prograRRMed->setTotalMinutos(14);
        $prograRRMed->setTotaHoras($this->cuantosHoras($codProgra));
        $prograRRMed->setTotalConsul($this->cuantosConsultas($codProgra));

        $this->em->persist($prograRRMed);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar editar el resultado programacion recurso termino con exito');

        return $matrizMensajes;
    }

    public function cuantosHoras($codProgra) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('horas', 'horas');
        $query = $this->em->createNativeQuery('SELECT sum(resprorec_totalhorasrecurso) horas
                                               FROM sidpla_resultadoprogrecurso
                                               WHERE prorecmed_codigo = ?
                                               Group BY prorecmed_codigo', $rsm);
        $query->setParameter(1, $codProgra);

        $x = $query->getResult();
        if (count($x) == 0)
            return 0;
        else
            return $x[0]['horas'];
    }

    public function cuantosConsultas($codProgra) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('consul', 'consul');
        $query = $this->em->createNativeQuery('SELECT sum (resprorec_consultasdisponibles) consul
                                               FROM sidpla_resultadoprogrecurso
                                               WHERE prorecmed_codigo = ?
                                               Group BY prorecmed_codigo', $rsm);
        $query->setParameter(1, $codProgra);

        $x = $query->getResult();
        if (count($x) == 0)
            return 0;
        else
            return $x[0]['consul'];
    }

}

?>
