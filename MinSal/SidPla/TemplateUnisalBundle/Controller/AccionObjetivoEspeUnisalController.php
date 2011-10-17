<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ProUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ObjetivoEspeUnisalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\AreaClasificacionDao;

class AccionObjetivoEspeUnisalController extends Controller {

    public function mostrarObjEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $proUnisalDao = new ProUnisalTemplateDao($this->getDoctrine());
        $proUnisalRes = $proUnisalDao->obtenerObjTempAnio(2011);

        $proUnisal = new ProUnisalTemplate();

        $objTemplateDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $areaClasificaDao = new AreaClasificacionDao($this->getDoctrine());


        foreach ($proUnisalRes as $proUnisal) {

            $objTemplaAnio = $proUnisal->getObjeEspeProgra();
            $objTempla = $objTemplateDao->obtenerPorArea(1, $objTemplaAnio);
        }
        
        if (is_array($objTempla))
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:manttObjetivoEspecificoUnisal.html.twig', 
                    array('opciones' => $opciones, 'ObjetivosEspecificos' => $objTempla, 'areas' => $areaClasificaDao->getAreaClasificacions()));
        else
            return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:manttObjetivoEspecificoUnisal.html.twig', 
                    array('opciones' => $opciones, 'areas' => $areaClasificaDao->getAreaClasificacions()));
    }

    public function ingresarObjetivoEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $idArea = $request->get('idArea');

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig', 
                array('opciones' => $opciones, 'anio' => $anio,'idArea'=>$idArea));
    }
    
   public function editarObjetivoEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $idObj = $request->get('idObj');
        $idArea = $request->get('idArea');
        
        $objEspUnisalDao=new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objEspUnisal=$objEspUnisalDao->getObjetivoEspeUnisalEspecifico($idObj);
        
        $descObj=$objEspUnisal->getDescObjEspUni();

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig', 
                array('opciones' => $opciones, 'anio' => $anio,'idArea'=>$idArea,'idObj'=>$idObj,'descObj'=>$descObj));
    }

    public function manttObjetivoEspeUnisalAction() {
        $request = $this->getRequest();

        $anio = $request->get('anio');
        $operacion = $request->get('oper');
        $idArea = $request->get('idArea');
        $desObjEsp = $request->get('objEspTmp');
        $idObj = $request->get('idObj'); 

        $objTemplateDao = new ObjetivoEspeUnisalDao($this->getDoctrine());

        
        switch ($operacion) {
            case 'add':
                $objTemplateDao->agregarObjTmp($idArea, $desObjEsp, $anio);
                
                break;
            case 'edit':
                $objTemplateDao->editarObjTmp($idObj, $desObjEsp);
            break;
        }

        return $this->mostrarObjEspeUnisalAction();
    }

}

?>
