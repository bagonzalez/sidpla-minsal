<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjespTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;

class AccionAdminObjetivosEspecificosTemplateController extends Controller {

    public function consultarObjetivosEspecificosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $objTmpAux = new ObjTemplate();
        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        $i=0;
        //DEL ANIO ACTUAL
        if ($objTmpDao->existeObjTmp(date('Y')) == 0)
            $objTmpDao->agregarObjetivoTemplate(date('Y'));
        $objTmp = $objTmpDao->obtenerObjTempAnio(date('Y'));
        $objTemplates=array();

        foreach ($objTmp as $objTmpAux) {
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
            $aux = new ObjespTemplate();
            $numfilas = count($objEspTmps);

            foreach ($objEspTmps as $aux) {
                $objTemplates[0][$i] =$aux;
                $i++;
            }
            
        }
        
        //DEL ANIO SIGUIENTE
        $i=0;
        if ($objTmpDao->existeObjTmp(date('Y')+1) == 0)
            $objTmpDao->agregarObjetivoTemplate(date('Y')+1);
        $objTmp = $objTmpDao->obtenerObjTempAnio(date('Y')+1);

        foreach ($objTmp as $objTmpAux) {
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
            $aux = new ObjespTemplate();
            $numfilas = count($objEspTmps);

            foreach ($objEspTmps as $aux) {
                $objTemplates[1][$i] =$aux;   
                $i++;
            }
            
        }

        
        if(count($objTemplates)==0)
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:manttObjetivosEspecificos.html.twig', 
                array('opciones' => $opciones));
        else
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:manttObjetivosEspecificos.html.twig', 
                array('opciones' => $opciones,'objTemplates'=>$objTemplates));
    }

     public function ingresarObjEspTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:agregarObjEspTemplate.html.twig', array('opciones' => $opciones, 'anio' => $anio));
    }

    public function editarObjEspTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfilaobj');
        $anio = $request->get('anio');

        $objEspDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objEsp = $objEspDao->getObjetEspecif($idfila);


        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:editarObjEspTemplate.html.twig', array('opciones' => $opciones, 'id' => $idfila, 'objEsp' => $objEsp->getDescripcion(), 'anio' => $anio));
    }

    public function manttObjEspTemplateAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $operacion = $request->get('oper');
        $objDesc = $request->get('objEspTmp');
        $codObjEsp = $request->get('idfilaobj');
        $id = $request->get('id');

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();

        foreach ($objTmp as $objTmpAux) {
            switch ($operacion) {
                case 'add':
                    $objTmpDao->agregarObjTmp($objDesc, $objTmpAux);
                    break;
                case 'edit':
                    $objTmpDao->editarObjTmp($objDesc, $codObjEsp);
                    break;
            }
        }
        return $this->consultarObjetivosEspecificosTemplateAction();
    }

    public function manttObjEspTemplatedosAction() {

        $request = $this->getRequest();
        $id = $request->get('id');
        $operacion = $request->get('oper');
        $objDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objDao->delObjEspec($id);
        return new Response("{sc:true,msg:''}");
    }

}

?>
