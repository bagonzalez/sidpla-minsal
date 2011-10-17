<?php

namespace MinSal\SidPla\TemplateUnisalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\AreaClasificacionDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\AreaClasificacion;

class AccionAreaClasificacionController extends Controller {

    public function mantenimientoAreasClasificacionAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaTemplateUnisalBundle:AreaClasificacion:showAreaClasificacion.html.twig'
                        , array('opciones' => $opciones));
    }

    public function consultarAreaClasificacionJSONAction() {

        $AreaClasDao = new AreaClasificacionDao($this->getDoctrine());
        $AreaClasificacion = $AreaClasDao->getAreaClasificacions();

        $numfilas = count($AreaClasificacion);

        $aux = new AreaClasificacion();
        $i = 0;

        foreach ($AreaClasificacion as $aux) {
            $rows[$i]['id'] = $aux->getCodArea();
            $rows[$i]['cell'] = array($aux->getCodArea(),
                $aux->getNombreArea()
            );
            $i++;
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

    public function manttAreaClasificacionAction() {
        $request = $this->getRequest();

        $nombreArea=$request->get('nombre');
        $codigo = $request->get('id');

        $operacion = $request->get('oper');

        $AreaClasificacionDao = new AreaClasificacionDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $AreaClasificacionDao->editAreaClas($codigo,$nombreArea);
                break;
            case 'del':
               $AreaClasificacionDao->delAreaClas($codigo);
                break;
            case 'add':
                $AreaClasificacionDao->addAreaClas($nombreArea);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>