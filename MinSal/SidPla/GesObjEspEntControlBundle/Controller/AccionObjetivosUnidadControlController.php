<?php

/*
  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */


namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;

/**
 * Description of AccionObjetivosUnidadControlController
 *
 * @author bagonzalez
 */
class AccionObjetivosUnidadControlController extends Controller {
    
     public function consultarObjetivosEspecificosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones));
    }
    
     public function consultarObjetivosEspecificosEntControlAction() {
        $request = $this->getRequest();
        $anio = $request->get('anio');
        $objEntControl = $request->get('objEntControl');

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        if($objTmpDao->existeObjTmp($anio)==0)
            $objTmpDao->agregarObjetivoTemplate ($anio);
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();
        $rows='';
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
    
    
}

?>
