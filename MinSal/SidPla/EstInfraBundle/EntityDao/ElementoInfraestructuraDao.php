<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura;
use MinSal\SidPla\EstInfraBundle\EntityDao\UnidadMedidaDao;
use MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida;

use Doctrine\ORM\Query\ResultSetMapping;

class ElementoInfraestructuraDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaEstInfraBundle:ElementoInfraestructura');
    }

    /*
     * Obtiene todos los elementos de infraestructura
     */

    public function getElementoInfraestructura() {
        $elementoinfraestructura = $this->em->createQuery("select einfra
                                                 from MinSalSidPlaEstInfraBundle:ElementoInfraestructura einfra
                                                 order by einfra.IdElemInfra ASC");
        return $elementoinfraestructura->getResult();
    }

    
    /*
     * Obtiene un elemento infraestructura especifico
     */
    public function getElementoInfraestructuraEspecifico($codigo) {
        $elementoinfraestructura = $this->repositorio->find($codigo);
        return $elementoinfraestructura;
    }

    /*
     * Agregar elemento de infraestructura
     */

    public function agregarElementoInfra($nomElemInfra, $abreElemInfra, $descElemInfra) {

        $elemInfra = new ElementoInfraestructura();
        $elemInfra->setNomElemInfra($nomElemInfra);
        $elemInfra->setElemInfraDescrip($descElemInfra);
        
        $unidadMedidaDao=new UnidadMedidaDao($this->doctrine);
        $unidadMedida=$unidadMedidaDao->getUnidadMedidaEspecifica($abreElemInfra);
        $elemInfra->setCodUnidadMed($unidadMedida);
        
        $this->em->persist($elemInfra);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar elementos de infraestructura termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Editar elemento de infraestructura
     */

    public function editarElementoInfra($codElemInfra, $nomElemInfra, $abreElemInfra, $descElemInfra) {

        $elemInfra= $this->getElementoInfraestructuraEspecifico($codElemInfra);
        $elemInfra->setNomElemInfra($nomElemInfra);
     
        $unidadMedidaDao=new UnidadMedidaDao($this->doctrine);
        $unidadMedida=$unidadMedidaDao->getUnidadMedidaEspecifica($abreElemInfra);
        $elemInfra->setCodUnidadMed($unidadMedida);
        
        
        $elemInfra->setElemInfraDescrip($descElemInfra);
        

        $this->em->persist($elemInfra);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el elemento de infraestructura termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Eliminar elemento de infraestrutura
     */

    public function eliminarElementoInfra($codigo) {

        $elementoinfra = $this->repositorio->find($codigo);

        $this->em->remove($elementoinfra);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

}
?>

