<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//Entidades necesarias para las consultas
use MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra;
use MinSal\SidPla\EstInfraBundle\EntityDao\EvaluacionElementoInfraDao;
use MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada;
use MinSal\SidPla\EstInfraBundle\EntityDao\InfraestructuraEvaluadaDao;
use \MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura;
use MinSal\SidPla\EstInfraBundle\EntityDao\UnidadMedidaDao;
use MinSal\SidPla\EstInfraBundle\EntityDao\ElementoInfraestructuraDao;
use MinSal\SidPla\EstInfraBundle\EntityDao\EstadoInfraestructuraDao;
//Para saber que unidad organizativa a la que pertenece y mostrar los elementos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionEstInfraEvaluacionElementoInfraController extends Controller {

    public function mantenimientoEvaluacionElementoInfraAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        //ComboUnidad de Medida
        $unidadMedidadDao = new UnidadMedidaDao($this->getDoctrine());
        $comboUniMed = $unidadMedidadDao->obtenerUnidadMedida();

        //ComboElementoInfraestructura
        $elementoInfraestructuraDao = new ElementoInfraestructuraDao($this->getDoctrine());
        $comboElementoInfra = $elementoInfraestructuraDao->obtenerElementoInfraestructura();

        //ComboEstadosInfraestructura
        $estadoInfraestructuraDao = new EstadoInfraestructuraDao($this->getDoctrine());
        $comboEstadoInfraestructura = $estadoInfraestructuraDao->obtenerEstadoInfraestructura();

        $pao = $this->obtenerPao(date("Y")); //Obtenego la PAO de la Unidad y el Anio que quiero

        $infraEvaluada = $pao->getinfraEvaluadaPao()->getIdInfraEva();

        return $this->render('MinSalSidPlaEstInfraBundle:EvaluacionElementoInfraestructura:manttEvaluacionElementoInfraestrutura.html.twig'
                        , array('opciones' => $opciones, 'unidadMedida' => $comboUniMed, 'elementoInfra' => $comboElementoInfra,
                    'estadosInfra' => $comboEstadoInfraestructura, 'idInfra' => $infraEvaluada));
    }

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
                $aux->getCantTot(),
                $aux->getElemInfCodigo()->getCodUnidadMed()->getAbreUnidMed()
            );
            $i++;
        }

        $numfilas = count($evaluacionElemento);
        
        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ',' ',' ');
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

    public function manttEvaluacionElementoAction() {
        $request = $this->getRequest();

        $codEvaElemento = $request->get('id');

        $estInfCodigo = $request->get('estado');
        $cantEvaElemento = (float) $request->get('cantidad');
        $canTot=(float) $request->get('cantidadtot');
        
        $evaElementoDao = new EvaluacionElementoInfraDao($this->getDoctrine());
        $evaElementoDao->editarEvaluacionElemento($codEvaElemento, $estInfCodigo, $cantEvaElemento,$canTot);



        return new Response("{sc:true,msg:''}");
    }

    public function obtenerPao($anio) {

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

    /* Agregar Elementos */

    public function seleccionaElementosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idInfra = $request->get('idInfra');

        return $this->render('MinSalSidPlaEstInfraBundle:EvaluacionElementoInfraestructura:seleccionElementInfra.html.twig'
                        , array('opciones' => $opciones, 'idInfra' => $idInfra));
    }

    public function consultarAsignadosJSONAction() {
        $idInfra = $this->getRequest()->get('idInfra');

        $infraEvaluadaDao = new InfraestructuraEvaluadaDao($this->getDoctrine());
        $infraEvaluada = $infraEvaluadaDao->getInfraEvaEspecifica($idInfra); //obtenego la infraestructura evaluada

        $evaluacionElemento = $infraEvaluada->getevaEleInfra(); //obtengo todos los valores de la Evaluacion Infraestructura Asociada a la PAO

        $aux = new EvaluacionElementoInfra();
        $i = 0;

        foreach ($evaluacionElemento as $aux) {
            $rows[$i]['id'] = $aux->getElemInfCodigo()->getIdElemInfra();
            $rows[$i]['cell'] = array($aux->getElemInfCodigo()->getIdElemInfra(),
                $aux->getElemInfCodigo()->getNomElemInfra()
            );
            $i++;
        }

        $numfilas = count($evaluacionElemento);
        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 25) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';



        $response = new Response($jsonresponse);
        return $response;
    }

    public function consultarDisponiblesJSONAction() {
        $idInfra = $this->getRequest()->get('idInfra');

        $elementoInfraDao = new EvaluacionElementoInfraDao($this->getDoctrine());
        $elementosDisponibles = $elementoInfraDao->consultarElementosDisponibles($idInfra);
        $aux = new ElementoInfraestructura();
        $i = 0;

        foreach ($elementosDisponibles as $aux) {
            $rows[$i]['id'] = $aux->getIdElemInfra();
            $rows[$i]['cell'] = array($aux->getIdElemInfra(),
                $aux->getNomElemInfra()
            );
            $i++;
        }

        $numfilas = count($elementosDisponibles);
       if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 25) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);
        return $response;
    }

    public function asignarElemSelecAction() {
        $request = $this->getRequest();

        $idElementoInfra = $request->get('id');
        $idInfra = $request->get('idInfra');
        $operacion = $request->get('oper');
        $evaElementoDao = new EvaluacionElementoInfraDao($this->getDoctrine());

        $evaElementoDao->agregarElementoAEvaluacion($idElementoInfra, $idInfra);
 
        return $this->consultarAsignadosJSONAction();
    }
    
        public function quitarElemSelecAction() {
        $request = $this->getRequest();

        $idElementoInfra = $request->get('id');
        $idInfra = $request->get('idInfra');
        $operacion = $request->get('oper');
        $evaElementoDao = new EvaluacionElementoInfraDao($this->getDoctrine());

        $evaElementoDao->quitarElementoDeEvaluacion($idElementoInfra, $idInfra);
       
        return $this->consultarAsignadosJSONAction();
    }

}

?>
