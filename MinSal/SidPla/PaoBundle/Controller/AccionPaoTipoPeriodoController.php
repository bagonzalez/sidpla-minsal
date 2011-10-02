<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;
use MinSal\SidPla\PaoBundle\Entity\TipoPeriodo;

class AccionPaoTipoPeriodoController extends Controller {

    public function mantenimientoTipoPeriodoAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $tipoPeriodoDao = new TipoPeriodoDao($this->getDoctrine());
        $combobox = $tipoPeriodoDao->obtenerTiposPeriodos();

        return $this->render('MinSalSidPlaPaoBundle:TipoPeriodoPao:manttTipoPeriodo.html.twig'
                        , array('opciones' => $opciones, 'combotipoperiodos' => $combobox));
    }

    public function consultarTipoPeriodoJSONAction() {

        $tipoPeriodoDao = new TipoPeriodoDao($this->getDoctrine());
        $tipoPeriodo = $tipoPeriodoDao->getTipoPeriodo();

        $numfilas = count($tipoPeriodo);

        $aux = new TipoPeriodo();
        $i = 0;
        foreach ($tipoPeriodo as $aux) {
            $rows[$i]['id'] = $aux->getIdTipPer();
            $rows[$i]['cell'] = array($aux->getIdTipPer(),
                $aux->getNomTipPer(),
                $aux->getActivoTipPer(),
                $aux->getDescTipPer()
            );
            if ($aux->getActivoTipPer())
                $rows[$i]['cell'][2] = 'SI';
            else
                $rows[$i]['cell'][2] = 'NO';
            $i++;
        }

         if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ');
        }
        
        $datos = json_encode($rows);
        $pages = floor($numfilas / 10)+1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);
        return $response;
    }

    public function manttTipoPeriodoAction() {
        $request = $this->getRequest();

        $codTipoPer = $request->get('id');
        $nomTipoPer = $request->get('nombre');
        $descTipoPer = $request->get('descripcion');
        if ($request->get('activo') == 'SI')
            $actTipoPer = true;
        else
            $actTipoPer = false;

        $operacion = $request->get('oper');

        $tipoPeriodoDao = new TipoPeriodoDao($this->getDoctrine());

        switch ($operacion) {
            case 'edit':
                $tipoPeriodoDao->editarTipoPeriodo($codTipoPer, $nomTipoPer, $descTipoPer, $actTipoPer);
                break;
            case 'del':
                $tipoPeriodoDao->eliminarTipoPeriodo($codTipoPer);
                break;
            case 'add':
                $tipoPeriodoDao->agregarTipoPeriodo($nomTipoPer, $descTipoPer, $actTipoPer);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
