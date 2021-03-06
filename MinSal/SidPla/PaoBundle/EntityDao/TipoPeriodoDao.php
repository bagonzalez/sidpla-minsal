<?php

namespace MinSal\SidPla\PaoBundle\EntityDao;

use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;
use Doctrine\ORM\Query\ResultSetMapping;

class TipoPeriodoDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPaoBundle:TipoPeriodo');
    }

    /*
     * Obtiene todos los tipos de periodos
     */

    public function getTipoPeriodo() {
        $tiposPeriodos = $this->em->createQuery("select t
                                                 from MinSalSidPlaPaoBundle:TipoPeriodo t 
                                                 order by t.idTipPer ASC");
        return $tiposPeriodos->getResult();
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

    public function cuantosTiposPeriodosActivos() {
        $cuantos = $this->em->createQuery("select count(t) c
                                                 from MinSalSidPlaPaoBundle:TipoPeriodo t
                                                 where t.activoTipPer=true");
        return $cuantos->getSingleScalarResult();
    }

    public function obtenerTiposPeriodos() {

        $tipoPeriodo = $this->getTipoPeriodoActivo();

        $aux = new TipoPeriodo();
        $n = $this->cuantosTiposPeriodosActivos();
        $i = 1;
        $cadena = '';
        foreach ($tipoPeriodo as $aux) {
            if ($i < $n)
                $cadena .=$aux->getIdTipPer() . ":" . $aux->getNomTipPer() . ';';
            else
                $cadena .=$aux->getIdTipPer() . ":" . $aux->getNomTipPer();
            $i++;
        }

        return $cadena;
    }

    /*
     * Agregar Tipo Perido 
     */

    public function agregarTipoPeriodo($nomTipPer, $descTipPer, $actTipPer) {

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

    public function editarTipoPeriodo($codTipPer, $nomTipPer, $descTipPer, $actTipPer) {

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

    public function eliminarTipoPeriodo($codigo) {

        $notificacionSistema = $this->repositorio->find($codigo);

        $this->em->remove($notificacionSistema);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

}
?>

