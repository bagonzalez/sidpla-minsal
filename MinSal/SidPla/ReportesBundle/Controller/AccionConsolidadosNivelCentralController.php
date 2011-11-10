<?php

namespace MinSal\SidPla\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use Doctrine\Common\Collections\ArrayCollection;


class AccionConsolidadosNivelCentralController extends Controller {

    public function showConsolidadosNivelCentralAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaReportesBundle:Consolidados:reportConsolidosPersonalizados.html.twig', array('opciones' => $opciones));
    }

    public function reportesUniSalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaReportesBundle:Consolidados:reportesUniSal.html.twig', array('opciones' => $opciones));
    }
    
    public function reportesUniSalJSONAction() {
        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidades = $unidadOrgDao->obtenerUniSal();

        $numfilas = count($unidades);

        $aux = new UnidadOrganizativa();
        $i = 0;
        
        foreach ($unidades as $aux) {
            $rows[$i]['id'] =$aux->getIdUnidadOrg();
            $rows[$i]['cell'] = array($aux->getNombreUnidad(),
                $aux->getIdUnidadOrg()
            );            
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
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
    
    public function reporteSeleccionadoJSONAction() {
        $request = $this->getRequest();
        $id = $request->get('idUniSal');
                
        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = $unidadOrgDao->getUnidadOrg($id);

        $numfilas = count($unidad);

        $i = 0;
        $paoSegumiento = new Pao();
        $paoSegumiento = $unidadOrgDao->getPaoSeguimiento($id);
        
        $rows[$i]['id']=$id;
        $rows[$i]['cell'][0]=$unidad->getNombreUnidad();
        $rows[$i]['cell'][1]=$unidad->getIdUnidadOrg();
        $rows[$i]['cell'][2]=$paoSegumiento->getCesopoblacion()->getIdCensoPoblacion();
        $rows[$i]['cell'][3]=$paoSegumiento->getJustificacion()->getIdJustificacion();
        $rows[$i]['cell'][4]=$paoSegumiento->getInfraEvaluadaPao()->getIdInfraEva();
        $rows[$i]['cell'][5]=$paoSegumiento->getEvaluacionResultado()->getEvaIndi();
        $rows[$i]['cell'][6]=$paoSegumiento->getIdPao();
         
        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
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

?>
