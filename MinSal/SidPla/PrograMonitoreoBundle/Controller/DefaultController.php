<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaPrograMonitoreoBundle:Default:index.html.twig', array('opciones' => $opciones));
    }

    public function supervisaUnidadesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaPrograMonitoreoBundle:Default:supervisarUnidadesPorPlanificacion.html.twig', array('opciones' => $opciones));
    }

    public function supervisaUnidadesJSONAction() {

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidades = $unidadOrgDao->obtenerUniSalSibasiRegion();

        $numfilas = count($unidades);

        $aux = new UnidadOrganizativa();
        $i = 0;

        foreach ($unidades as $aux) {
            $rows[$i]['cell'] = array($aux->getNombreUnidad(),
                $aux->getIdUnidadOrg()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
          //  $rows[0]['id'] = 0;
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

}
