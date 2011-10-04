<?php
namespace MinSal\SidPla\RRMedicoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed;
use MinSal\SidPla\RRMedicoBundle\EntityDao\ResulPrograRRMedDao;
use MinSal\SidPla\RRMedicoBundle\EntityDao\TipoHorarioDao;

//Para saber que unidad organizativa a la que pertenece y mostrar los periodos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;  

class AccionRRMedicoResulPrograRRMedController extends Controller {
    
    public function consultarResulPrograRRMedAction() {
     $opciones = $this->getRequest()->getSession()->get('opciones');
  
     $TipoHorarioDao= new TipoHorarioDao($this->getDoctrine());
     $comboResulRRmed=$TipoHorarioDao->obtenerTipoHorarios();
        
    return $this->render('MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:manttResultPrograRRMed.html.twig'
                         , array('opciones' => $opciones,'comboResulRRmed'=>$comboResulRRmed));
     

    }
    
     public function consultarResulPrograRRMedJSONAction(){
        
       $anio = $this->getRequest()->get('anio');

        if ($anio == 0)
            $anio = date("Y");

        $pao = $this->obtenerPao($anio);

        $resulPrograRRMed = $pao->getProgramacionesRRMed();
       
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
    
    
    public function obtenerPao($anio) {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        $pao = new Pao();
        $pao = $unidaDao->getPaoAnio($idUnidad, $anio);

        return $pao;
    }

}

?>
