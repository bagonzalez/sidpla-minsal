<?php

namespace MinSal\SidPla\IndicadoresTemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\IndicadoresTemplateBundle\Entity\TipoIndicador;
use MinSal\SidPla\IndicadoresTemplateBundle\EntityDao\TipoIndicadorDao;

class AccionTipoIndicadorController extends Controller {

    public function mostrarTipoIndicadoresAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idObj = $request->get('idObj');
        $idIndSal = $request->get('idIndSal');

        if ($idIndSal == null)
            return $this->render('MinSalSidPlaIndicadoresTemplateBundle:TipoIndicador:manttTipoIndicador.html.twig', 
                    array('opciones' => $opciones, 'idObj'=>$idObj ));
        else
            return $this->render('MinSalSidPlaIndicadoresTemplateBundle:TipoIndicador:manttTipoIndicador.html.twig', 
                    array('opciones' => $opciones, 'idObj' =>$idObj, 'idIndSal'=> $idIndSal));
    }

    public function consultarTipoIndicadorJSONAction() {

        $tipoIndicadorDao = new TipoIndicadorDao($this->getDoctrine());
        $tipoIndicador = $tipoIndicadorDao->getTipoIndicador();


        $numfilas = count($tipoIndicador);

        $aux = new TipoIndicador();
        $i = 0;

        foreach ($tipoIndicador as $aux) {
            $rows[$i]['id'] = $aux->getCodTipIndi();
            $rows[$i]['cell'] = array($aux->getCodTipIndi(),
                $aux->getNombreTipIndi()
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

    public function manttTipoIndicadorEdicionAction() {
        $request = $this->getRequest();

        $nombre = $request->get('nombre');
        $codigo = $request->get('id');

        $operacion = $request->get('oper');

        $tipoIndicadorDao = new TipoIndicadorDao($this->getDoctrine());

        switch ($operacion) {
            case 'add':
                $tipoIndicadorDao->agregarTipoIndicador($nombre);
                break;
            case 'edit':
                $tipoIndicadorDao->editarTipoIndicador($codigo, $nombre);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
