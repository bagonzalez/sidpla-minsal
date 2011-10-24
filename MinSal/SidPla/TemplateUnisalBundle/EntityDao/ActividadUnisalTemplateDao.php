<?php

namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;
use Doctrine\ORM\Query\ResultSetMapping;

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

    public function agregarActividadUnisalTemplate($idResEspe, $descActUnisal, $beneActUniTemp, $coberActUniTemp, $concenActUniTemp, $condActUniTemp, $responsableActUniTemp, $metaAnualActUniTemp, $universo, $tipoTot) {

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
        $actividadUnisalTemplate->setUniverso($universo);
        $actividadUnisalTemplate->setTipoTotalUni($tipoTot);

        $this->em->persist($actividadUnisalTemplate);
        $resEspe->addActividadesTemplate($actividadUnisalTemplate);
        $this->em->persist($resEspe);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function editarActividadUnisalTemplate($idAct, $descActUnisal, $beneActUniTemp, $coberActUniTemp, $concenActUniTemp, $condActUniTemp, $responsableActUniTemp, $metaAnualActUniTemp, $universo, $tipoTot) {

        $actividadUnisalTemplate = $this->getActividadUnisalEspecifico($idAct);

        $actividadUnisalTemplate->setBeneActUniTemp($beneActUniTemp);
        $actividadUnisalTemplate->setCoberActUniTemp($coberActUniTemp);
        $actividadUnisalTemplate->setConcenActUniTemp($concenActUniTemp);
        $actividadUnisalTemplate->setCondActUniTemp($condActUniTemp);
        $actividadUnisalTemplate->setResponsableActUniTemp($responsableActUniTemp);
        $actividadUnisalTemplate->setDescActUniTemp($descActUnisal);
        $actividadUnisalTemplate->setMetaAnualActUniTemp($metaAnualActUniTemp);
        $actividadUnisalTemplate->setUniverso($universo);
        $actividadUnisalTemplate->setTipoTotalUni($tipoTot);

        $this->em->persist($actividadUnisalTemplate);
        $this->em->flush();

        $matrizMensajes = array('El proceso de ingresar Resultado Esperado termino con exito ');

        return $matrizMensajes;
    }

    public function cuantasActDefinidas($anio) {

        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('cuanto', 'cuanto');
        $query = $this->em->createNativeQuery('SELECT count( * ) cuanto
                                               FROM sidpla_prounisaltemplate, 
                                                    sidpla_objetivoespeunisal, 
                                                    sidpla_resultadoespeunisal, 
                                                    sidpla_actividadunisaltemplate
                                               WHERE sidpla_objetivoespeunisal.prounitem_codigo = sidpla_prounisaltemplate.prounitem_codigo AND
                                                     sidpla_objetivoespeunisal.objespuni_codigo = sidpla_resultadoespeunisal.objespuni_codigo AND
                                                     sidpla_actividadunisaltemplate.resulespuni_codigo = sidpla_resultadoespeunisal.resulespuni_codigo AND
                                                     sidpla_prounisaltemplate.prounitem_anio = ?', $rsm);
        $query->setParameter(1, $anio);

        $x = $query->getResult();
        
        return $x[0]['cuanto'];
    }

}

?>
