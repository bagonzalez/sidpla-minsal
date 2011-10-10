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

class AccionAdminObjetivosEspecificosTemplateController extends Controller {

    public function consultarObjetivosEspecificosTemplateAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones));
    }

    public function consultarObjetivosEspecificosTemplateJSONAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');


        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
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
                    $aux->getIdObjEspec()->getDescripcion()
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

    public function manttObjetivosEspecificosTemplateAction() {

        $request = $this->getRequest();

        $objetivo = $request->get('objetivo');
        $id = $request->get('id');
        $idCaractOrg = "";
        //$request->get('idCaractOrg');

        $operacion = $request->get('oper');

        $objDao = new ObjetivoEspecificoDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $objDao->editObjEspec($objetivo, $id);
        }

        if ($operacion == 'del') {
            $objDao->delObjEspec($id);
        }

        if ($operacion == 'add') {
            $catOrgDao = new CaractOrgDao($this->getDoctrine());

            $paoElaboracion = $this->obtenerPaoElaboracionAction();
            $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();

            $catOrgDao->agregarObjEspec($objetivo, $idCaractOrg, $programacionMonitoreo);
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
