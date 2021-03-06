<?php

namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;
use MinSal\SidPla\DepUniBundle\EntityDao\DepartamentoUniDao;

use MinSal\SidPla\DepUniBundle\EntityDao\RecursoHumanoDao;

//Para saber que unidad organizativa a la que pertenece y mostrar los elementos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionDepUniDeptoUniController extends Controller {

    public function consultarDeptoUniJSONAction() {
        
        $unidadOrg=$this->obtenerUniOrg();
        $deptosUni=$unidadOrg->getDepartUnidades();
        $rrHH=new RecursoHumanoDao($this->getDoctrine());
        $aux = new DepartamentoUni();
        $i = 0;

        foreach ($deptosUni as $aux) {
            $rows[$i]['id'] = $aux->getCodDeptoUnidad();
            $cant=$rrHH->cuantoRRHH($aux->getCodDeptoUnidad());
            $rows[$i]['cell'] = array($aux->getCodDeptoUnidad(),
                $aux->getNombreDepto(),
                $cant
            );
            $i++;
        }

        $numfilas = count($deptosUni);

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
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

    public function obtenerUniOrg() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        return $unidad;
    }
    
    public function manttDeptoUniEdicionAction() {
        $request = $this->getRequest();
        

        $codigoDeptoUni = $request->get('id');
        $nombreDeptoUni=$request->get('nombre');
        $unidadOrg=$this->obtenerUniOrg();      

        $operacion = $request->get('oper');

        $deptoUniDao=new DepartamentoUniDao($this->getDoctrine());

        switch ($operacion){
            case 'add':
                $deptoUniDao->agregarDeptoUni($nombreDeptoUni, $unidadOrg);
            break;
            case 'edit':
                $deptoUniDao->editarDeptoUni($codigoDeptoUni,$nombreDeptoUni, $unidadOrg);
                break;
            case 'del':
               $deptoUniDao->eliminarDeptoUni($codigoDeptoUni);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
