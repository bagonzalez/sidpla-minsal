<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura;
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
     * Obtiene todos los tipos de periodos
     */

    public function getElementoInfraestructura() {
        $elementoinfraestructura = $this->em->createQuery("select einfra
                                                 from MinSalSidPlaEstInfraBundle:ElementoInfraestructura einfra
                                                 order by einfra.idElemInfra ASC");
        return $elementoinfraestructura->getResult();
    }

    /*
     * Obtener Tipos de Periodos Activos
  */

    public function getTipoPeriodoActivo() {
        $tiposPeriodos = $this->em->createQuery("select t
                                                 from MinSalSidPlaPaoBundle:TipoPeriodo t
                                                 where t.activoTipPer=true
                                                 order by t.idTipPer ASC");
        return $tiposPeriodos->getResult();
    }

    /*
     * Obtiene un tipo de periodo especifico
     */
    public function getTipoPeriodoEspecifico($codigo) {
        $tiposPeriodos = $this->repositorio->find($codigo);
        return $tiposPeriodos;
    }
    
    public function cuentosTiposPeriodosActivos(){
        $cuantos = $this->em->createQuery("select count(t) c
                                                 from MinSalSidPlaPaoBundle:TipoPeriodo t
                                                 where t.activoTipPer=true");
        return $cuantos->getSingleScalarResult();
    }

    /*
     * Agregar Tipo Perido 
     */

    public function addTipoPeriodo($nomTipPer, $descTipPer, $actTipPer) {

        $tipoPeriodo = new TipoPeriodo();

        $tipoPeriodo->setActivoTipPer($actTipPer);
        $tipoPeriodo->setDescTipPer($descTipPer);
        $tipoPeriodo->setNomTipPer($nomTipPer);
        $tipoPeriodo->setUsuarioTipPer(true);


        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Editar un tipo de periodo
     */

    public function editTipoPeriodo($codTipPer, $nomTipPer, $descTipPer, $actTipPer) {

        $tipoPeriodo = $this->getTipoPeriodoEspecifico($codTipPer);
        $tipoPeriodo->setDescTipPer($descTipPer);
        $tipoPeriodo->setNomTipPer($nomTipPer);
        $tipoPeriodo->setActivoTipPer($actTipPer);

        $this->em->persist($tipoPeriodo);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Eliminar un tipo de periodo
     */

    public function delTipoPeriodo($codigo) {

        $notificacionSistema = $this->repositorio->find($codigo);

        $this->em->remove($notificacionSistema);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

}
?>

