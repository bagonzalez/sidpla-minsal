<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\EstInfraBundle\EntityDao\ElementoInfraestructuraDao;
use MinSal\SidPla\EstInfraBundle\Entity\ElementoInfraestructura;

use MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida;
use MinSal\SidPla\EstInfraBundle\EntityDao\UnidadMedidaDao;

class AccionEstInfraElementoInfraestructuraController extends Controller {

  
    public function consultarElementoInfraestructuraJSONAction() {

        $ElementoInfraestructuraDao=new ElementoInfraestructuraDao($this->getDoctrine());
        $ElementoInfraestructura= $ElementoInfraestructuraDao->getElementoInfraestructura();
        

        $numfilas = count($ElementoInfraestructura);

        $aux = new ElementoInfraestructura();
        $i = 0;

        foreach ($ElementoInfraestructura as $aux) {
            $rows[$i]['id'] = $aux->getIdElemInfra();
            $rows[$i]['cell'] = array($aux->getIdElemInfra(),
                $aux->getNomElemInfra(),
                $aux->getCodUnidadMed()->getAbreUnidMed(),
                $aux->getElemInfraDescrip()                
            );
          
            $i++;
        }

        $datos = json_encode($rows);


        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }
   

    public function manttElementoInfraestruturaAction() {
        $request = $this->getRequest();
        
        $codElemInfra=$request->get('id');
        $nomElemInfra=$request->get('nomelem');
        $abreElemInfra=(int) $request->get('abreunidmed');
        $descElemInfra=$request->get('descripcion'); 
        $operacion = $request->get('oper');

        $eleminfraDao=new ElementoInfraestructuraDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                 $eleminfraDao->editarElementoInfra($codElemInfra, $nomElemInfra, $abreElemInfra, $descElemInfra);
                break;
            case 'del':
                $eleminfraDao->eliminarElementoInfra($codElemInfra);
                break;
            case 'add':
                 $eleminfraDao->agregarElementoInfra($nomElemInfra, $abreElemInfra, $descElemInfra);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>

