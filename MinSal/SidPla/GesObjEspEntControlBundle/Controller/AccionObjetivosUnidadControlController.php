<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;

class AccionObjetivosUnidadControlController extends Controller {

    public function consultarObjetivosEspecificosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        $objTmp = $objTmpDao->obtenerObjTempAnio(date('Y'));

        $objTmpAux = new ObjTemplate();
        $objEspTmps = new ObjTemplate();
        foreach ($objTmp as $objTmpAux) {
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
        }


        if (count($objEspTmps) == 0)
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', 
                    array('opciones' => $opciones));
        else
                return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', 
                array('opciones' => $opciones,'objetivos'=>$objEspTmps));
    }

   /* public function consultarObjetivosEspecificosEntControlAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $objEntControl = $request->get('objEntControl');

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        if ($objTmpDao->existeObjTmp($anio) == 0)
            $objTmpDao->agregarObjetivoTemplate($anio);
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();
        $rows = '';
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



        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }
*/
}

?>
