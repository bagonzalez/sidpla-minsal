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

        if ($proUnisalDao->existePlantilla(date('Y')) == 0)
            $proUnisalDao->agregarPlantilla(date('Y'));
        $proUnisalResActual = $proUnisalDao->obtenerObjTempAnio(date('Y'));

        if ($proUnisalDao->existePlantilla(date('Y') + 1) == 0)
            $proUnisalDao->agregarPlantilla(date('Y') + 1);
        $proUnisalResSiguiente = $proUnisalDao->obtenerObjTempAnio(date('Y') + 1);
        if ($proUnisalDao->hayObjetivosEnPlantilla($proUnisalResSiguiente->getCodProUniTem())==0)
            $muestra = 1;
        else
            $muestra = 0;
        $areaClasificaDao = new AreaClasificacionDao($this->getDoctrine());
        $areas = $areaClasificaDao->getAreaClasificacions();
        $objTemplateDao = new ObjetivoEspeUnisalDao($this->getDoctrine());

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:manttObjetivoEspecificoUnisal.html.twig', array('opciones' => $opciones, 'proUnisalActual' => $proUnisalResActual, 'objTemplateDao' => $objTemplateDao,
                    'proUnisalSiguiente' => $proUnisalResSiguiente, 'areas' => $areas,'muestra'=>$muestra));
    }

    public function ingresarObjetivoEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $idArea = $request->get('idArea');

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig', array('opciones' => $opciones, 'anio' => $anio, 'idArea' => $idArea));
    }

    public function editarObjetivoEspeUnisalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $idObj = $request->get('idObj');
        $idArea = $request->get('idArea');

        $objEspUnisalDao = new ObjetivoEspeUnisalDao($this->getDoctrine());
        $objEspUnisal = $objEspUnisalDao->getObjetivoEspeUnisalEspecifico($idObj);

        $descObj = $objEspUnisal->getDescObjEspUni();

        return $this->render('MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig', array('opciones' => $opciones, 'anio' => $anio, 'idArea' => $idArea, 'idObj' => $idObj, 'descObj' => $descObj));
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
    
    public function crearPlantillaAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');
        
        $proUnisalDao = new ProUnisalTemplateDao($this->getDoctrine());
        $proUnisal = $proUnisalDao->obtenerObjTempAnio($anio);
        $idPlantilla=$proUnisal->getCodProUniTem();
        $proUnisalDao->crearPlantilla(($anio-1), $idPlantilla);
        
        return $this->mostrarObjEspeUnisalAction();
    }
}

?>
