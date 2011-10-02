<?php
namespace MinSal\SidPla\RRMedicoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed;
use MinSal\SidPla\RRMedicoBundle\EntityDao\ResulPrograRRMedDao;
use MinSal\SidPla\RRMedicoBundle\EntityDao\TipoHorarioDao;

class AccionRRMedicoResulPrograRRMedController extends Controller {
    public function consultarResulPrograRRMedAction() {
     $opciones = $this->getRequest()->getSession()->get('opciones');
  
     $TipoHorarioDao= new TipoHorarioDao($this->getDoctrine());
     $comboResulRRmed=$TipoHorarioDao->obtenerTipoHorarios();
        
    return $this->render('MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:manttResultPrograRRMed.html.twig'
                         , array('opciones' => $opciones,'comboResulRRmed'=>$comboResulRRmed));
     

    }
    
     public function consultarResulPrograRRMedJSONAction(){
        
        $resulPrograRRMedDao=new ResulPrograRRMedDao($this->getDoctrine());
        $resulPrograRRMed=$resulPrograRRMedDao->getResulPrograRRMed();
        

        $numfilas = count($resulPrograRRMed);

        $aux = new ResulPrograRRMed();
        $i = 0;

        foreach ($resulPrograRRMed as $aux) {
            $rows[$i]['id'] = $aux->getCodResproRR();
            $rows[$i]['cell'] = array($aux->getCodResproRR(),
                $aux->getTipoRRHH()->getTipoHorDes(),
                $aux->getCantRRMedDispo(),
                $aux->getTotalHorasRR(),
                0,
                $aux->getConsulasDispo()
                               
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

    public function manttResulPrograRRMedAction() {
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
