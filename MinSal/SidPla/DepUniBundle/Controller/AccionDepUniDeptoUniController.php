<?php

namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AccionDepUniDeptoUniController {

    public function consultarEvaluacionElementoJSONAction() {
        $idInfra = $this->getRequest()->get('idInfra');

        $infraEvaluadaDao = new InfraestructuraEvaluadaDao($this->getDoctrine());
        $infraEvaluada = $infraEvaluadaDao->getInfraEvaEspecifica($idInfra); //obtenego la infraestructura evaluada

        $evaluacionElemento = $infraEvaluada->getevaEleInfra(); //obtengo todos los valores de la Evaluacion Infraestructura Asociada a la PAO

        $aux = new EvaluacionElementoInfra();
        $i = 0;

        foreach ($evaluacionElemento as $aux) {
            $rows[$i]['id'] = $aux->getIdEvaEleInfra();
            $rows[$i]['cell'] = array($aux->getIdEvaEleInfra(),
                $aux->getElemInfCodigo()->getNomElemInfra(),
                $aux->getEstInfCodigo()->getNomEstado(),
                $aux->getCantElemt(),
                $aux->getElemInfCodigo()->getCodUnidadMed()->getAbreUnidMed()
            );
            $i++;
        }

        $numfilas = count($evaluacionElemento);

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ');
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

    public function obtenerUniOrg() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        $paoSeleccionada = new Pao();
        $paoSeleccionada = $unidaDao->getPaoAnio($idUnidad, $anio);

        return $paoSeleccionada;
    }

}

?>
