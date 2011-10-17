<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminObjetivosEspecificosController
 *
 * @author edwin
 */

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\CaractOrgDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\UsersBundle\Entity\User;

use MinSal\SidPla\PaoBundle\Entity\Pao;


class AccionAdminObjetivosEspecificosController extends Controller {

    //put your code here

    public function obtenerPaoElaboracionAction(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();              
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        $paoElaboracion=new Pao();        
        $paoElaboracion=$unidaDao->getPaoElaboracion($idUnidad);
        
        return $paoElaboracion;
        
    }
    

    public function consultarObjetivosEspecificosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();

        $empleado = $user->getEmpleado();

        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();

        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        //$infoGeneral=new InformacionGeneral();

        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        // $nombreUnidad=$unidad->getNombreUnidad();
        // $nombreUnidadPadre=$unidad->getParent()->getNombreUnidad();
        // $infoGeneral=$unidad->getInformacionGeneral();
        $caractOrg = $unidad->getCaractOrg();


        // $form = $this->createForm(new InfoCaractOrgType(), $infoGeneral);
        // $formCaract = $this->createForm(new CaractOrgType(), $caractOrg);

        return $this->render('MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones, 'idCaractOrg' => $caractOrg->getIdCaractOrg()));
    }

    public function consultarObjetivosEspecificosJSONAction() {

        $request = $this->getRequest();
        $idCaractOrg = $request->get('idCaractOrg');

        $caractOrgAux = new CaractOrg();
        $catOrgDao = new CaractOrgDao($this->getDoctrine());
        $caractOrgAux = $catOrgDao->getCaractOrg($idCaractOrg);

        $objetivosEspec = $caractOrgAux->getObjetivosEspec();

        $numfilas = count($objetivosEspec);

        $objetivoEspec = new ObjetivoEspecifico();
        $i = 0;
        $rows='';

        foreach ($objetivosEspec as $objetivoEspec) {
            $rows[$i]['id'] = $objetivoEspec->getIdObjEspec();
            $rows[$i]['cell'] = array($objetivoEspec->getIdObjEspec(),
                $objetivoEspec->getDescripcion()
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

    public function manttObjetivosEspecificosAction() {

        $request = $this->getRequest();

        $objetivo = $request->get('objetivo');
        $id = $request->get('id');
        $idCaractOrg = $request->get('idCaractOrg');

        $operacion = $request->get('oper');

        $objDao = new ObjetivoEspecificoDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $objDao->editObjEspec($objetivo, $id);
        }

        if ($operacion == 'del') {
            $objDao->delObjEspec($id);
        }

        if ($operacion == 'add') {
            $catOrgDao = new CaractOrgDao($this->getDoctrine());
            
            $paoElaboracion=$this->obtenerPaoElaboracionAction();       
            $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
            
            $catOrgDao->agregarObjEspec($objetivo, $idCaractOrg, $programacionMonitoreo);
        }

        return new Response("{sc:true,msg:''}");
    }

}

?>
