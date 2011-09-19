<?php

namespace MinSal\SidPla\EstInfraBundle\EntityDao;

use MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida;
use Doctrine\ORM\Query\ResultSetMapping;

class UnidadMedidaDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaEstInfraBundle:UnidadMedida');
    }

    /*
     * Obtiene todos los tipos de periodos
     */

    public function getUnidadMedida() {
        $unidadmedida = $this->em->createQuery("select um
                                                 from MinSalSidPlaEstInfraBundle:UnidadMedida um
                                                 order by um.idUnidMed ASC");
        return $unidadmedida->getResult();
    }

    /*
     * Obtiene una unidad de medida especifica
     */
    public function getUnidadMedidaEspecifica($codigo) {
        $unidadMedida = $this->repositorio->find($codigo);
        return $unidadMedida;
    }
    
       /*
     * Agregar Unidad de Medida 
     */

    public function agregarUnidadMedida($nomUnidmed,$abreUnidMed ,$tipoUnidmed, $descUnidmed) {

        $unidadmedida= new UnidadMedida();

        $unidadmedida->setNomUnidMed($nomUnidmed);
        $unidadmedida->setAbreUnidMed($abreUnidMed);
        $unidadmedida->setTipoUnidMed($tipoUnidmed);
        $unidadmedida->setDescripUnidMed($descUnidmed);
            


        $this->em->persist($unidadmedida);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar la Unidad de medida termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Editar un tipo de periodo
     */

    public function editarUnidadMedida($codUnidmed, $nomUnidmed,$abreUnidMed ,$tipoUnidmed, $descUnidmed) {

        $unidadMedida = $this->getUnidadMedidaEspecifica($codUnidmed);
        $unidadMedida->setNomUnidMed($nomUnidmed);
        $unidadMedida->setAbreUnidMed($abreUnidMed);
        $unidadMedida->setTipoUnidMed($tipoUnidmed);
        $unidadMedida->setDescripUnidMed($descUnidmed);
        $this->em->persist($unidadMedida);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo de periodo termino con exito');

        return $matrizMensajes;
    }
    
    /*
     * Eliminar un tipo de periodo
     */

    public function eliminarUnidadMedida($codigo) {

      $unidadMedida = $this->getUnidadMedidaEspecifica($codigo);

        $this->em->remove($unidadMedida);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    }

}
?>

