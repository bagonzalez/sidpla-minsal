<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\EstadoInfraestructura;
use Doctrine\ORM\Query\ResultSetMapping;

class EstadoInfraestructuraDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaEstInfraBundle:EstadoInfraestructura');
    }

    /*
     * Obtiene todos los elementos de infraestructura
     */

    public function getEstadoInfraestructura() {
        $estadoInfraestructura = $this->em->createQuery("select einfra
                                                 from MinSalSidPlaEstInfraBundle:EstadoInfraestructura einfra
                                                 order by einfra.id ASC");
        return $estadoInfraestructura->getResult();
    }

    /*
     * Obtiene un elemento infraestructura especifico
     */

    public function getEstadoInfraestructuraEspecifico($codigo) {
        $estadoInfraestructura = $this->repositorio->find($codigo);
        return $estadoInfraestructura;
    }

    public function obtenerEstadoInfraestructura() {

        $estadoInfraestructura= $this->getEstadoInfraestructura();
        

        $aux = new EstadoInfraestructura();
        $n = $this->cuantosEstadosInfraestructura();
        $i = 1;
        $cadena = '';
        foreach ($estadoInfraestructura as $aux) {
            if ($i < $n)
                $cadena.=$aux->getId().":" . $aux->getNomEstado(). ';';
            else
                $cadena .=$aux->getId().":" . $aux->getNomEstado();
            $i++;
        }

        return $cadena;
    }

    public function cuantosEstadosInfraestructura() {
        $estadoInfraestructura = $this->em->createQuery("select count(ei)
                                                 from MinSalSidPlaEstInfraBundle:EstadoInfraestructura ei");
        
        return $estadoInfraestructura->getSingleScalarResult();
    }

}

?>
