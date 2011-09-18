<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\EstInfraBundle\EntityDao\UnidadMedidaDao;
use MinSal\SidPla\EstInfraBundle\Entity\UnidadMedida;

class AccionEstInfraUnidadMedidaController extends Controller {

    public function consultarUnidadMedidaJSONAction() {

        $unidadMedidaDao=new UnidadMedidaDao($this->getDoctrine());
        $unidadMedida=$unidadMedidaDao->getUnidadMedida();
        

        $numfilas = count($unidadMedida);

        $aux = new UnidadMedida();
        $i = 0;

        foreach ($unidadMedida as $aux) {
            $rows[$i]['id'] = $aux->getIdUnidMed();
            $rows[$i]['cell'] = array($aux->getIdUnidMed(),
                $aux->getNomUnidMed(),
                $aux->getAbreUnidMed(),
                $aux->getTipoUnidMed(),
                $aux->getDescripUnidMed()
                
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

    public function manttUnidadMedidaAction() {
        $request = $this->getRequest();
        
        $codUnidMed=$request->get('id');
        $nomUnidMed=$request->get('unidmed');
        $abreUnidMed=$request->get('abreviatura');
        $tipoUnidMed=$request->get('tipo');
        $descUnidMed=$request->get('descripcion');
                    
        $operacion = $request->get('oper');

        $unidadmedidaDao=new UnidadMedidaDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $unidadmedidaDao->editarUnidadMedida($codUnidMed, $nomUnidMed,$abreUnidMed ,$tipoUnidMed, $descUnidMed);
               break;
            case 'del':
               $unidadmedidaDao->eliminarUnidadMedida($codUnidMed);
                break;
            case 'add':
                $unidadmedidaDao->agregarUnidadMedida($nomUnidMed, $abreUnidMed , $tipoUnidMed, $descUnidMed);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
