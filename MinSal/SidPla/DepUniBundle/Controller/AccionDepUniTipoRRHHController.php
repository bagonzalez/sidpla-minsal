<?php
namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\DepUniBundle\EntityDao\TipoRRHumanoDao;
use MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano;

class AccionDepUniTipoRRHHController extends Controller {
    
    public function mantenimientoTipoRecursoAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaDepUniBundle:TipoRRHumano:manttTipoRRHumano.html.twig'
                        , array('opciones' => $opciones));

    }
    
    public function consultarTipoRRHHJSONAction() {

        $tipoRRHHDao= new TipoRRHumanoDao($this->getDoctrine());
        $tipoRRHH=$tipoRRHHDao->getTipoRRHH();
        

        $numfilas = count($tipoRRHH);

        $aux = new TipoRRHumano();
        $i = 0;

        foreach ($tipoRRHH as $aux) {
            $rows[$i]['id'] = $aux->getCodTipoRRHH();
            $rows[$i]['cell'] = array($aux->getCodTipoRRHH(),
                $aux->getDescripRRHH()
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
    
    public function manttTipoRRHHEdicionAction() {
        $request = $this->getRequest();

        $nombreTipo=$request->get('nombre');
        $codigo = $request->get('id');

        $operacion = $request->get('oper');

        $tipoRRHHDao=new TipoRRHumanoDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $tipoRRHHDao->editarTipoRRHH($codigo, $nombreTipo);
                break;
            case 'del':
               $tipoRRHHDao->eliminarTipoRRHH($codigo);
                break;
            case 'add':
                $tipoRRHHDao->agregarTipoRRHH($nombreTipo);
            break;
        }

        return new Response("{sc:true,msg:''}");
    }
}

?>
