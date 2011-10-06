<?php

namespace MinSal\SidPla\RRMedicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed;
use MinSal\SidPla\RRMedicoBundle\EntityDao\ResulPrograRRMedDao;
use MinSal\SidPla\RRMedicoBundle\EntityDao\TipoHorarioDao;
use MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed;
//Para saber que unidad organizativa a la que pertenece y mostrar los periodos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionRRMedicoResulPrograRRMedController extends Controller {

    public function consultarResulPrograRRMedAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:manttResultPrograRRMed.html.twig'
                        , array('opciones' => $opciones, 'turno' => 1));
    }

    public function consultarResulPrograRRMedJSONAction() {
        $request = $this->getRequest();

        $anio = $this->getRequest()->get('anio');
        $turno = $this->getRequest()->get('turno');

        if ($anio == 0)
            $anio = date("Y");

        $pao = $this->obtenerPao($anio);

        $resulProgRRDao = new ResulPrograRRMedDao($this->getDoctrine());

        $prograRRMed = $pao->getProgramacionesRRMed();
        $aux = new PrograRRMed();



        $numfilas = 0;
        foreach ($prograRRMed as $aux) {
            if ($aux->getTurnoProg() == $turno) {
                $i = 0;

                $resulRRMed = $aux->getResProRRMed();
                $numfilas = count($resulRRMed);
                $aux2 = new ResulPrograRRMed();

                foreach ($resulRRMed as $aux2) {
                    $rows[$i]['id'] = $aux2->getCodResproRR();
                    $min = $resulProgRRDao->calcularMin($aux2->getCantRRMedDispo(), $aux2->gettipoHorario()->getTipoCantidadHor(), $turno);
                    $rows[$i]['cell'] = array($aux2->getCodResproRR(),
                        $aux2->gettipoHorario()->getTipoHorDes(),
                        $aux2->getCantRRMedDispo(),
                        $aux2->getTotalHorasRR(),
                        $min,
                        $aux2->getConsulasDispo()
                    );

                    $i++;
                }
            }
        }

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

    public function manttResulPrograRRMedAction() {
        $request = $this->getRequest();

        $cant = $this->getRequest()->get('cantidad');
        $codResulProga = $this->getRequest()->get('id');

        $resulProgRRDao = new ResulPrograRRMedDao($this->getDoctrine());

        $resulProgRRDao->editarResulPrograRRMed($codResulProga, $cant);


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

        $pao = new Pao();
        $pao = $unidaDao->getPaoAnio($idUnidad, $anio);

        return $pao;
    }

    public function obtenerProgramacionJSONAction() {
        $request = $this->getRequest();
        $numfilas = 0;
        $turno = $this->getRequest()->get('turno');
        $pao = $this->obtenerPao(date("Y"));

        $resulProgRRDao = new ResulPrograRRMedDao($this->getDoctrine());

        $prograRRMed = $pao->getProgramacionesRRMed();
        $aux = new PrograRRMed();

        
        $numfilas = count($prograRRMed);
        foreach ($prograRRMed as $aux) {
            if ($aux->getTurnoProg()== $turno) {
                $rows[0]['id'] = $aux->getCodPrograRRMed();
                $rows[0]['cell'] = array($aux->getTotalMinutos(),
                    $aux->getTotaHoras(),
                    $aux->getTotalConsul()
                );
            }
        }

        if ($numfilas == 0) {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ');
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

}

?>
