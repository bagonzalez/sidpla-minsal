<?php

namespace MinSal\SidPla\EstInfraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\EstInfraBundle\Entity\EvaluacionElementoInfra;
use MinSal\SidPla\EstInfraBundle\EntityDao\EvaluacionElementoInfraDao;

use MinSal\SidPla\EstInfraBundle\Entity\InfraestructuraEvaluada;

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
        $unidadMedidadDao= new UnidadMedidaDao($this->getDoctrine());
        $comboUniMed=$unidadMedidadDao->obtenerUnidadMedida();
        
        //ComboElementoInfraestructura
        $elementoInfraestructuraDao= new ElementoInfraestructuraDao($this->getDoctrine());
        $comboElementoInfra=$elementoInfraestructuraDao->obtenerElementoInfraestructura();
        
        //ComboEstadosInfraestructura
        $estadoInfraestructuraDao= new EstadoInfraestructuraDao($this->getDoctrine());
        $comboEstadoInfraestructura= $estadoInfraestructuraDao->obtenerEstadoInfraestructura();
        
        return $this->render('MinSalSidPlaEstInfraBundle:EvaluacionElementoInfraestructura:manttEvaluacionElementoInfraestrutura.html.twig'
                        , array('opciones' => $opciones,'unidadMedida'=>$comboUniMed,'elementoInfra'=>$comboElementoInfra,'estadosInfra'=>$comboEstadoInfraestructura));
    }

    public function consultarEvaluacionElementoJSONAction() {

       
       // $anio=$this->getRequest()->get('anio');
        
        //if($anio==0)
           // $anio=date("Y");
        
        $pao=$this->obtenerPao(2011);//Obtenego la PAO de la Unidad y el Anio que quiero
        
        $infraEvaluada=new InfraestructuraEvaluada();
        $infraEvaluada=$pao->getinfraEvaluadaPao();//obtenego la infraestructura evaluada
        
        $evaluacionElemento= new EvaluacionElementoInfra();
        $evaluacionElemento= $infraEvaluada->getevaEleInfra();//obtengo todos los valores de la Evaluacion Infraestructura Asociada a la PAO
        
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
        if ($numfilas != 0){
            array_multisort($rows,SORT_ASC);
            $datos = json_encode($rows);
        }
        else{
            $rows[0]['id']=0;
            $rows[0]['cell']=array(' ',' ',' ',' ');
            $datos = json_encode($rows);
        }

        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }
    
    public function manttEvaluacionElementoAction() {
        $request = $this->getRequest();
        
        $codEvaElemento=$request->get('id');
        
        $estInfCodigo=1;//ya lo voy a sacar
        $cantEvaElemento=(float) $request->get('cantidad');

        $evaElementoDao= new EvaluacionElementoInfraDao($this->getDoctrine());
        
        $evaElementoDao->editarEvaluacionElemento($codEvaElemento, $estInfCodigo, $cantEvaElemento);

        

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

}

?>
