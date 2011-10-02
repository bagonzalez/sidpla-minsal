<?php

namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\EntityDao\TipoPeriodoDao;
use MinSal\SidPla\PaoBundle\EntityDao\PeriodoPaoDao;
use MinSal\SidPla\PaoBundle\Entity\PeriodoPao;
//Para saber que unidad organizativa a la que pertenece y mostrar los periodos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionPaoPeriodoPaoController extends Controller {

    public function mantenimientoPeriodoPaoAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        //Obtener la unidad a la que pertence el usuario
        $usuario = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();


        $tipoPeriodoDao = new TipoPeriodoDao($this->getDoctrine());
        $combobox = $tipoPeriodoDao->obtenerTiposPeriodos();

        return $this->render('MinSalSidPlaPaoBundle:PeriodoPao:manttPeriodoPao.html.twig'
                        , array('opciones' => $opciones, 'combotipoperiodos' => $combobox, 'idUnidad' => $idUnidad));
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

        $paoElaboracion = new Pao();
        $paoElaboracion = $unidaDao->getPaoAnio($idUnidad, $anio);

        return $paoElaboracion;
    }

    public function consultarPeriodoPaoJSONAction() {

        $periodoPaoDao = new PeriodoPaoDao($this->getDoctrine());
        $anio = $this->getRequest()->get('anio');

        if ($anio == 0)
            $anio = date("Y");

        $pao = $this->obtenerPao($anio);

        $periodoPao = $pao->getPeriodoCalendarizacion();

        $aux = new PeriodoPao();
        $i = 0;

        foreach ($periodoPao as $aux) {
            $rows[$i]['id'] = $aux->getCodPerPao();
            $rows[$i]['cell'] = array($aux->getCodPerPao(),
                $aux->gettipPeriodoPerPao()->getNomTipPer(),
                DATE_FORMAT($aux->getFechIniPerPao(), 'd/m/Y'),
                DATE_FORMAT($aux->getFechFinPerPao(), 'd/m/Y'),
                $aux->getActivoPerPao()
            );
            if ($aux->getActivoPerPao())
                $rows[$i]['cell'][4] = 'SI';
            else
                $rows[$i]['cell'][4] = 'NO';
            $i++;
        }

        $numfilas = count($periodoPao);
        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ',' ');
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

    public function manttPeriodoPaoAction() {
        $request = $this->getRequest();

        $codPerPao = $request->get('id');
        $tipoPeriodoCodigo = $request->get('nombre');
        $dia = substr($request->get('fechini'), 0, 2);
        $mes = substr($request->get('fechini'), 3, 2);
        $anio = substr($request->get('fechini'), 6, 4);
        $fechIniPerPao = $anio . '-' . $mes . '-' . $dia;
        $dia = substr($request->get('fechfin'), 0, 2);
        $mes = substr($request->get('fechfin'), 3, 2);
        $anio = substr($request->get('fechfin'), 6, 4);
        $fechFinPerPao = $anio . '-' . $mes . '-' . $dia;


        $operacion = $request->get('oper');

        $periodoPaoDao = new PeriodoPaoDao($this->getDoctrine());

        $periodoPaoDao->editarPeriodoOficial($codPerPao, $tipoPeriodoCodigo, $fechIniPerPao, $fechFinPerPao);



        return new Response("{sc:true,msg:''}");
    }

}

?>
