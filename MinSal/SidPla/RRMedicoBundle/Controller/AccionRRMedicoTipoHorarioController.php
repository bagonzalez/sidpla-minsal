<?php

namespace MinSal\SidPla\RRMedicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\RRMedicoBundle\EntityDao\TipoHorarioDao;
use MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario;

class AccionRRMedicoTipoHorarioController extends Controller {
    public function consultarTipoHorarioAction() {
    $opciones = $this->getRequest()->getSession()->get('opciones');
   
          return $this->render('MinSalSidPlaRRMedicoBundle:TipoHorario:manttTipoHorario.html.twig'
                        , array('opciones' => $opciones));
    }
     public function consultarTipoHorarioJSONAction(){
    

        $tipoHorarioDao=new TipoHorarioDao($this->getDoctrine());
        $tipoHorario=$tipoHorarioDao->getTipoHorario();
        

        $numfilas = count($tipoHorario);

        $aux = new TipoHorario();
        $i = 0;

        foreach ($tipoHorario as $aux) {
            $rows[$i]['id'] = $aux->getcodTipoHor();
            $rows[$i]['cell'] = array($aux->getcodTipoHor(),
                $aux->getTipoHorDes(),
                $aux->getTipoCantidadHor(),
                $aux->getTipoHorTurno()
                               
            );
          
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ',' ');
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

    public function manttTipoHorarioAction() {
        $request = $this->getRequest();
        
        $codTipoHora=$request->get('id');
        $nomTipoHora=$request->get('nomTipHo');
        $canthoras=(int)$request->get('cantH');
        $tipohorario=$request->get('tipoH');
       
                    
        $operacion = $request->get('oper');

        $tipohorarioDao=new TipoHorarioDao($this->getDoctrine());

        switch ($operacion){
            case 'edit':
                $tipohorarioDao->editarTipoHorario($codTipoHora, $nomTipoHora, $canthoras, $tipohorario);
               break;
            case 'del':
               $tipohorarioDao->eliminarTipoHorario($codTipoHora);
                break;
            case 'add':
                $tipohorarioDao->agregarTipoHorario($nomTipoHora, $canthoras, $tipohorario);
                break;
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
