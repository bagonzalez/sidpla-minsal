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

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones));
    }

    public function consultarObjetivosEspecificosTemplateJSONAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        if($objTmpDao->existeObjTmp($anio)==0)
            $objTmpDao->agregarObjetivoTemplate ($anio);
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();
        foreach ($objTmp as $objTmpAux) {
            $i = 0;
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
            $aux = new ObjespTemplate();
            $numfilas = count($objEspTmps);

            foreach ($objEspTmps as $aux) {
                $rows[$i]['id'] = $aux->getIdObjEspec()->getIdObjEspec();
                $rows[$i]['cell'] = array($aux->getIdObjEspec()->getIdObjEspec(),
                    $aux->getIdObjEspec()->getDescripcion(),
                    $aux->getIdObjEspTempl()
                );
                $i++;
            }
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function ingresarObjEspTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $anio = $request->get('anio');

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:agregarObjEspTemplate.html.twig', 
                array('opciones' => $opciones, 'anio' => $anio));
    }
    
    public function editarObjEspTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfilaobj');
        $anio = $request->get('anio');
        
        $objEspDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objEsp=$objEspDao->getObjetEspecif($idfila);
        
        
        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:editarObjEspTemplate.html.twig', 
                array('opciones' => $opciones,'id'=>$idfila,'objEsp'=>$objEsp->getDescripcion(),'anio' => $anio));
    }

    public function manttObjEspTemplateAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $operacion = $request->get('oper');
        $objDesc = $request->get('objEspTmp');
        $codObjEsp=$request->get('idfilaobj');

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
    }

?>
