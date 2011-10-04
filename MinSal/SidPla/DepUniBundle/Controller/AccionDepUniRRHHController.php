<?php

namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\DepUniBundle\Entity\RecursoHumano;
use MinSal\SidPla\DepUniBundle\EntityDao\RecursoHumanoDao;

use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;

//Para saber que unidad organizativa a la que pertenece y mostrar los elementos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionDepUniRRHHController extends Controller {

    public function consultarRRHHJSONAction() {

        $unidadOrg = $this->obtenerUniOrg();
        $deptosUni = $unidadOrg->getDepartUnidades();

        $aux = new DepartamentoUni();
        $numfilas=0;
        $j=0;
        foreach ($deptosUni as $aux) {
            $rrHH=$aux->getRrHHs();
            $aux2=new RecursoHumano();
            $numfilas += count($rrHH);
            foreach($rrHH as $aux2){
                $rows[$j]['id'] = $aux2->getCodigoRRHH();
                $rows[$j]['cell'] = array($aux2->getCodigoRRHH(),
                    $aux2->getDeptoUnidadRRHH()->getNombreDepto(),
                    $aux2->getTipoRRHH()->getDescripRRHH(),
                    $aux2->getCantidad(),
                    $aux2->getDescripcion()
                );
                $j++;
            }
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ',' ',' ',' ');
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
    
    public function manttRRHHEdicionAction() {
        $request = $this->getRequest();
        

        $codigoRRHH = $request->get('id');
        $codDeptoUni=$request->get('depto');
        $codTipoRR=$request->get('tipoRRHH');
        $cantRRHH=(int)$request->get('cant');
        $descRRHH=$request->get('descripcion');
        
        $operacion = $request->get('oper');

        $rrHHDao=new RecursoHumanoDao($this->getDoctrine());

        switch ($operacion){
            case 'add':
                $rrHHDao->agregarRRHH($codDeptoUni,$codTipoRR, $cantRRHH, $descRRHH);    
            break;
            case 'edit':
                $rrHHDao->editarRRHH($codigoRRHH,$codDeptoUni,$codTipoRR, $cantRRHH, $descRRHH);
                break;
            case 'del':
                 $rrHHDao->eliminarRRHH($codigoRRHH);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
