<?php
namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;

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

        $objTmp = $this->em->createQuery("SELECT pu
                                          FROM MinSalSidPlaTemplateUnisalBundle:ProUnisalTemplate pu
                                          WHERE pu.anioProUniTem = '" . $anio . "'");
        return $objTmp->getResult();
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

}

?>
