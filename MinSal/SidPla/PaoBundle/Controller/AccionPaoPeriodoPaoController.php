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

//use MinSal\SidPla\PaoBundle\EntityDao\PeriodoOficialDao;
//use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;


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
                        , array('opciones' => $opciones, 'combotipoperiodos' => $combobox,'idUnidad'=>$idUnidad));
    }

    public function consultarPeriodoPaoJSONAction() {

        $periodoPaoDao = new PeriodoPaoDao($this->getDoctrine());
        $idUnidad= $this->getRequest()->get('idUnidad');
        $anio=$this->getRequest()->get('anio');
        
        $periodoPao = $periodoPaoDao->getPeriodoPao($anio);

        $aux = new PeriodoPao();
        $i = 0;

        foreach ($periodoPao as $aux) {
            $rows[$i]['id'] = $aux->getCodPerPao();
            $rows[$i]['cell'] = array($aux->getCodPerPao(),
                $aux->gettipPeriodoPerPao()->getNomTipPer(),
                DATE_FORMAT($aux->getFechIniPerPao(), 'd/m/Y'),
                DATE_FORMAT($aux->getFechFinPerPao(), 'd/m/Y'),
                $aux->getActivoPerPao(),
                $idUnidad
            );
            if ($aux->getActivoPerPao())
                $rows[$i]['cell'][4] = 'SI';
            else
                $rows[$i]['cell'][4] = 'NO';
            $i++;
        }

        $numfilas = count($periodoPao);
        if ($numfilas != 0)
            $datos = json_encode($rows);
        else
            $datos = '';


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
