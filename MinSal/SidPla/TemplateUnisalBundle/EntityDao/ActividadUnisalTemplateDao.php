<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ResultadoEspeUnisalDao;

class ActividadUnisalTemplateDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate');
    }

    public function getActividadUnisalEspecifico($codigo) {
        $actividadUnisal = $this->repositorio->find($codigo);
        return $actividadUnisal;
    }
    
    public function agregarActividadUnisalTemplate($idResEspe, $descActUnisal,$beneActUniTemp,$coberActUniTemp,$concenActUniTemp,$condActUniTemp,$responsableActUniTemp,$metaAnualActUniTemp) {

        $resEspeDao = new ResultadoEspeUnisalDao($this->doctrine);
        $resEspe = $resEspeDao->getResultadoEspeUnisalEspecifico($idResEspe);

        $actividadUnisalTemplate = new ActividadUnisalTemplate();
        $actividadUnisalTemplate->setBeneActUniTemp($beneActUniTemp);
        $actividadUnisalTemplate->setCoberActUniTemp($coberActUniTemp);
        $actividadUnisalTemplate->setConcenActUniTemp($concenActUniTemp);
        $actividadUnisalTemplate->setCondActUniTemp($condActUniTemp);
        $actividadUnisalTemplate->setResponsableActUniTemp($responsableActUniTemp);
        $actividadUnisalTemplate->setResulEspeTemAct($resEspe);
        $actividadUnisalTemplate->setDescActUniTemp($descActUnisal);
        $actividadUnisalTemplate->setMetaAnualActUniTemp($metaAnualActUniTemp);
        
        $this->em->persist($actividadUnisalTemplate);
        $resEspe->addActividadesTemplate($actividadUnisalTemplate);
        $this->em->persist($resEspe);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function editarActividadUnisalTemplate($idAct, $descActUnisal,$beneActUniTemp,$coberActUniTemp,$concenActUniTemp,$condActUniTemp,$responsableActUniTemp,$metaAnualActUniTemp) {

        $actividadUnisalTemplate = $this->getActividadUnisalEspecifico($idAct);
        
        $actividadUnisalTemplate->setBeneActUniTemp($beneActUniTemp);
        $actividadUnisalTemplate->setCoberActUniTemp($coberActUniTemp);
        $actividadUnisalTemplate->setConcenActUniTemp($concenActUniTemp);
        $actividadUnisalTemplate->setCondActUniTemp($condActUniTemp);
        $actividadUnisalTemplate->setResponsableActUniTemp($responsableActUniTemp);
        $actividadUnisalTemplate->setDescActUniTemp($descActUnisal);
        $actividadUnisalTemplate->setMetaAnualActUniTemp($metaAnualActUniTemp);
        
        $this->em->persist($actividadUnisalTemplate);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

}

?>
