<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use Doctrine\ORM\Query\ResultSetMapping;

class ProUnisalTemplateDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:ProUnisalTemplate');
    }

    public function obtenerObjTempAnio($anio) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('cod', 'cod');
        $query = $this->em->createNativeQuery('SELECT prounitem_codigo cod
                                               FROM sidpla_prounisaltemplate
                                               WHERE prounitem_anio = ?', $rsm);
        $query->setParameter(1, $anio);
        $x = $query->getSingleScalarResult();
        $proUnisal = $this->repositorio->find($x);
        return $proUnisal;
    }

    public function existePlantilla($anio) {
        $periodoOfic = $this->em->createQuery("SELECT count(pu)
                                               FROM MinSalSidPlaTemplateUnisalBundle:ProUnisalTemplate pu
                                               WHERE pu.anioProUniTem = '" . $anio . "'");
        return $periodoOfic->getSingleScalarResult();
    }

    public function agregarPlantilla($anio) {

        $proUnisal = new ProUnisalTemplate();
        $proUnisal->setAnioProUniTem($anio);
        $this->em->persist($proUnisal);
        $this->em->flush();


        $matrizMensajes = array('El proceso de ingresar termino con exito ');

        return $matrizMensajes;
    }

    public function hayObjetivosEnPlantilla($idProUnisal) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT count(*) resp
                                               FROM sidpla_prounisaltemplate, sidpla_objetivoespeunisal
                                               WHERE sidpla_objetivoespeunisal.prounitem_codigo = sidpla_prounisaltemplate.prounitem_codigo AND
                                                    sidpla_prounisaltemplate.prounitem_codigo = ?', $rsm);
        $query->setParameter(1, $idProUnisal);

        $x = $query->getSingleScalarResult();
        return $x;
    }
    
   public function crearPlantilla($anio,$idPlantilla) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT "FN_CREAR_PLANTILLAUNISAL"(?,?) resp', $rsm);
        $query->setParameter(1, $anio);
        $query->setParameter(2, $idPlantilla);

        $x = $query->getSingleScalarResult();
        
       
    }

}

?>
