<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ActividadUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ResultadoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultadoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;

class AccionActividadUnisalTemplateController extends Controller {

    public function mostrarActUnisalTemplateAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $idResEsp = $request->get('idResEsp');

        $resulEspeDao = new ResultadoEspeUnisalDao($this->getDoctrine());
        $resulEspe = $resulEspeDao->getResultadoEspeUnisalEspecifico($idResEsp);

        $descResEspe = $resulEspe->getDescResEspUni();
        $actUnisalTemplate = $resulEspe->getActividadesTemplate();


        if (count($actUnisalTemplate) != 0)
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:manttActividadUnisalTemplate.html.twig', array('opciones' => $opciones, 'idObj' => $idObj, 'actUnisal' => $actUnisalTemplate, 'idResEsp' => $idResEsp, 'descResEsp' => $descResEspe));
        else
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:manttActividadUnisalTemplate.html.twig', array('opciones' => $opciones, 'idObj' => $idObj, 'idResEsp' => $idResEsp, 'descResEsp' => $descResEspe));
    }

    public function ingresarActUnisalTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();

        $idObj = $request->get('idObj');
        $objTemplateDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objTemplate = $objTemplateDao->getObjetivoEspeUnisalEspecifico($idObj);
        $descObj = $objTemplate->getDescObjEspUni();

        $idResEsp = $request->get('idResEsp');
        $descResEsp = $request->get('ResEspTmp');

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:gestionActividadUnisalTemplate.html.twig', array('opciones' => $opciones, 'idObj' => $idObj, 'descObj' => $descObj, 'idResEsp' => $idResEsp, 'descResEsp' => $descResEsp));
    }

    public function editarActUnisalTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        
        $objTemplateDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objTemplate = $objTemplateDao->getObjetivoEspeUnisalEspecifico($idObj);
        $descObj = $objTemplate->getDescObjEspUni();
        
        $idResEsp = $request->get('idResEsp');
        $descResEsp = $request->get('ResEspTmp');
        
        $idAct = $request->get('idAct');
        $actUnisalDao=new ActividadUnisalTemplateDao($this->getDoctrine());
        $actUnisal=new ActividadUnisalTemplate();
        
        $actUnisal=$actUnisalDao->getActividadUnisalEspecifico($idAct);
        $descAct = $actUnisal->getDescActUniTemp();
        $resAct = $actUnisal->getResponsableActUniTemp();
        $benAct = $actUnisal->getBeneActUniTemp();
        $cobAct = $actUnisal->getCoberActUniTemp();
        $conAct = $actUnisal->getConcenActUniTemp();
        $supAct = $actUnisal->getCondActUniTemp();
        $metAnuAct = $actUnisal->getMetaAnualActUniTemp();
        

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:gestionActividadUnisalTemplate.html.twig', 
                array('opciones' => $opciones, 'idObj'=>$idObj,'descObj'=>$descObj,'idResEsp'=>$idResEsp,'descResEsp'=>$descResEsp,
                      'idAct'=>$idAct,'descAct'=> $descAct,'benAct'=> $benAct,'cobAct'=> $cobAct,'conAct'=> $conAct,'supAct'=> $supAct, 'resAct'=>$resAct, 'metAnuAct'=>$metAnuAct
                    ));
    }

    public function manttActUnisalTemplateAction() {
        $request = $this->getRequest();

        $operacion = $request->get('oper');
        $idObj = $request->get('idObj');
        $idResEsp = $request->get('idResEsp');

        $idAct = $request->get('idAct');
        $descAct = $request->get('descAct');
        $resAct = $request->get('resAct');
        $benAct = $request->get('benAct');
        $cobAct = $request->get('cobAct');
        $conAct = $request->get('conAct');
        $supAct = $request->get('supAct');
        $metAnuAct = $request->get('metAnuAct');

        $ActUnisalTemplateDao = new ActividadUnisalTemplateDao($this->getDoctrine());


        switch ($operacion) {
            case 'add':
                $ActUnisalTemplateDao->agregarActividadUnisalTemplate($idResEsp, $descAct, $benAct, $cobAct, $conAct, $supAct, $resAct, $metAnuAct);
                break;
            case 'edit':
                $ActUnisalTemplateDao->editarActividadUnisalTemplate($idAct, $descAct, $benAct, $cobAct, $conAct, $supAct, $resAct, $metAnuAct);
                break;
        }

        return $this->mostrarActUnisalTemplateAction();
    }

}
?>