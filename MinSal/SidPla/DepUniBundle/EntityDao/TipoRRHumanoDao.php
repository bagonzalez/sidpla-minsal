<?php

namespace MinSal\SidPla\DepUniBundle\EntityDao;

use MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano;
use Doctrine\ORM\Query\ResultSetMapping;

class TipoRRHumanoDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaDepUniBundle:TipoRRHumano');
    }

    /*
     * Obtiene todos los tipos de recursos humanos
     */

    public function getTipoRRHH() {
        $notificaciones = $this->repositorio->findAll();
        return $notificaciones;
    }

    /*
     * Agregar Tipo Recurso Humano
     */

    public function getTipoRRHHEspecifico($codigo) {
        $tipoRRHH = $this->repositorio->find($codigo);
        return $tipoRRHH;
    }

    public function agregarTipoRRHH($nombreTipo) {

        $tipoRRHH = new TipoRRHumano();
        $tipoRRHH->setDescripRRHH($nombreTipo);

        $this->em->persist($tipoRRHH);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el tipo recurso humano termino con exito');

        return $matrizMensajes;
    }

    public function editarTipoRRHH($codTipo, $nombreTipo) {

        $tipoRRHH = $this->getTipoRRHHEspecifico($codTipo);
        $tipoRRHH->setDescripRRHH($nombreTipo);

        $this->em->persist($tipoRRHH);
        $this->em->flush();
        $matrizMensajes = array('El proceso de editar el tipo recurso humano termino con exito');

        return $matrizMensajes;
    }

    public function eliminarTipoRRHH($codTipo) {

        $tipoRRHH = $this->getTipoRRHHEspecifico($codTipo);
        
        $this->em->remove($tipoRRHH);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar el tipo recurso humano termino con exito');

        return $matrizMensajes;
    }
    
        /*Para otras entidades*/
    public function obtenerRRHHcadena() {
        $cadena = "";
               
        $tipoRRHH = $this->getTipoRRHH();
        
        $aux = new TipoRRHumano();
        $n = count($tipoRRHH);
        
        $i = 1;
        
        foreach ($tipoRRHH as $aux) {
            if ($i < $n)
                $cadena.=$aux->getCodTipoRRHH().":".$aux->getDescripRRHH().';';
            else
                $cadena.=$aux->getCodTipoRRHH().":".$aux->getDescripRRHH();
            $i++;
        }

        return $cadena;
    }

}

?>
