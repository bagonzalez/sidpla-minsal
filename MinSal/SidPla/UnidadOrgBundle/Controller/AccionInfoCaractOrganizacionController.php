<?php

/*
  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.


 */

namespace MinSal\SidPla\UnidadOrgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\UnidadOrgBundle\Form\Type\InfoCaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Form\Type\CaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\UnidadOrgBundle\Entity\FuncionEspecifica;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\CaractOrgDao;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\FuncionEspecificaDao;

use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;

/**
 * Description of AccionInfoCaractOrganizacionController
 *
 * @author bgonzalez
 */
class AccionInfoCaractOrganizacionController extends Controller {

    public function ingresarInfoCaractAction() {
        $nombreempleado="";
        $segundonombre="";
        $apellidoempleado="";
        $segundoapellido="";
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();

        $empleado = $user->getEmpleado();

        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();


        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $infoGeneral = new InformacionGeneral();

        $unidad = $unidaDao->getUnidadOrg($idUnidad);
        
        $nombreUnidad = $unidad->getNombreUnidad();
        $nombreUnidadPadre = $unidad->getParent()->getNombreUnidad();

        $infoGeneral = $unidad->getInformacionGeneral();
        $caractOrg = $unidad->getCaractOrg();
        $responsable=$unidad->getResponsable();
        
       $responsableDao = new EmpleadoDao($this->getDoctrine());
       $empleado = new Empleado();
       $empleado = $responsableDao->getEmpleado($responsable);
      
       if( $empleado!=NULL){
       $nombreempleado=$empleado->getPrimerNombre();
       $segundonombre=$empleado->getSegundoNombre();
       $apellidoempleado=$empleado->getPrimerApellido();
       $segundoapellido=$empleado->getSegundoApellido();
       }
       
        $infoGeneralcod = $unidad->getInformacionGeneral()->getIdInformacionGeneral();
       
        $infoGeneralcoddireccion = $unidad->getInformacionGeneral()->getDireccion();
        $infoGeneralcodtelefono = $unidad->getInformacionGeneral()->getTelefono();
        $infoGeneralcodfax = $unidad->getInformacionGeneral()->getFax();
        $infoGeneralcodmail = $unidad->getInformacionGeneral()->getEmail();
        $infoGeneralfecha = $unidad->getInformacionGeneral()->getFechaActualizacion();
        $unidadorgcod=$unidad->getIdUnidadOrg();
        
        
        

        $form = $this->createForm(new InfoCaractOrgType(), $infoGeneral);
        $formCaract = $this->createForm(new CaractOrgType(), $caractOrg);

        return $this->render('MinSalSidPlaUnidadOrgBundle:InforCaractOrg:ingresoInfoCaractOrg.html.twig', array('form' => $form->createView(),
                    'formOrg' => $formCaract->createView(),
                    'opciones' => $opciones,
                    'unidadOrg' => $nombreUnidad,
                    'unidadPadre' => $nombreUnidadPadre,
                    'idCaractOrg' => $caractOrg->getIdCaractOrg(),
                    'nombreempleado' => $nombreempleado
                     ,'segundonombre' => $segundonombre
                     ,'apellidoempleado' => $apellidoempleado
                     ,'segundoapellido' => $segundoapellido
                     ,'responsable' => $responsable 
                     ,'infoGeneralcod' => $infoGeneralcod
                     ,'infoGeneralcoddireccion' => $infoGeneralcoddireccion
                     ,'infoGeneralcodtelefono' => $infoGeneralcodtelefono
                     ,'infoGeneralcodfax' => $infoGeneralcodfax 
                     ,'infoGeneralcodmail' =>  $infoGeneralcodmail
                      ,'unidadorgcod' =>  $unidadorgcod   
                      ,'infoGeneralfecha' =>  $infoGeneralfecha
                ));
    }

    
    public function guardarInfoGeneralAction(Request $peticion) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        
        $infoGeneralcod=$request->get('infoGeneralcod');
        $unidadorgcod = $request->get('unidadorgcod');
        $responsable=$request->get('idempleado');
        $mail=$request->get('mail');
        $telefono=$request->get('telefono');
        $fax=$request->get('fax');
        $direccion=$request->get('direccion');
        
        
        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadOrgDao->guardarInfogeneralOrg($infoGeneralcod, $unidadorgcod, $responsable, $mail, $telefono, $fax, $direccion);

        
        
        
        
        
        
        return $this->ingresarInfoCaractAction();
    }
    
    
    
    
    
    
    
    
    
    
    public function guardarCaracteristicasAction(Request $peticion) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();

        $caractOrg = new CaractOrg();
        $form = $this->createForm(new CaractOrgType(), $caractOrg);

        if ($peticion->getMethod() == 'POST') {
            $form->bindRequest($peticion);

            if ($form->isValid()) {
                $catOrgDao = new CaractOrgDao($this->getDoctrine());

                $caractOrgAux = $catOrgDao->getCaractOrg($caractOrg->getIdCaractOrg());

                $caractOrgAux->setFuncionPrincipal($caractOrg->getFuncionPrincipal());
                $caractOrgAux->setMision($caractOrg->getMision());
                $caractOrgAux->setVision($caractOrg->getVision());
                $caractOrgAux->setObjetivoGeneral($caractOrg->getObjetivoGeneral());


                $this->getDoctrine()->getEntityManager()->persist($caractOrgAux);
                $this->getDoctrine()->getEntityManager()->flush();
            }
        }

        return $this->ingresarInfoCaractAction();
    }

    public function consultarFuncionesOrgAction() {

        $request = $this->getRequest();
        $idCaractOrg = $request->get('idCaractOrg');

        $caractOrgAux = new CaractOrg();
        $catOrgDao = new CaractOrgDao($this->getDoctrine());
        $caractOrgAux = $catOrgDao->getCaractOrg($idCaractOrg);

        $funciones = $caractOrgAux->getFuncionesEspec();

        $numfilas = count($funciones);

        $funcionEspec = new FuncionEspecifica();
        $i = 0;

        foreach ($funciones as $funcionEspec) {
            $rows[$i]['id'] = $funcionEspec->getIdFuncEspec();
            $rows[$i]['cell'] = array($funcionEspec->getIdFuncEspec(),
                $funcionEspec->getFuncDescripcion()
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

    public function consultarObjetivosOrgEspecAction() {

        $request = $this->getRequest();
        $idCaractOrg = $request->get('idCaractOrg');

        $caractOrgAux = new CaractOrg();
        $catOrgDao = new CaractOrgDao($this->getDoctrine());
        $caractOrgAux = $catOrgDao->getCaractOrg($idCaractOrg);

        $objetivosEspec = $caractOrgAux->getObjetivosEspec();

        $numfilas = count($objetivosEspec);

        $objetivoEspec = new ObjetivoEspecifico();
        $i = 0;

        foreach ($objetivosEspec as $objetivoEspec) {
            $rows[$i]['id'] = $objetivoEspec->getIdObjEspec();
            $rows[$i]['cell'] = array($objetivoEspec->getIdObjEspec(),
                $objetivoEspec->getDescripcion()
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

    public function manttObjEspecAction() {

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
            $catOrgDao->agregarObjEspec($objetivo, $idCaractOrg);
        }

        return new Response("{sc:true,msg:''}");
    }

    public function manttFuncEspecAction() {


        $request = $this->getRequest();

        $idCaractOrg = $request->get('idCaractOrg');
        $funcion = $request->get('funcion');
        $id = $request->get('id');

        $operacion = $request->get('oper');

        $funcDao = new FuncionEspecificaDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $funcDao->editFuncionEspec($funcion, $id);
        }

        if ($operacion == 'del') {
            $funcDao->delFuncionEspec($id);
        }

        if ($operacion == 'add') {
            $catOrgDao = new CaractOrgDao($this->getDoctrine());
            $catOrgDao->agregarFuncEspec($funcion, $idCaractOrg);
        }

        return new Response("{sc:true,msg:'ff'}");
    }

public function consultarEmpleadosJSONAction() {
        $request = $this->getRequest();
        $empleadoDao = new EmpleadoDao($this->getDoctrine());
        $empleados = $empleadoDao->getEmpleados();

        $numfilas = count($empleados);

        $emple = new Empleado();
        $i = 0;

        foreach ($empleados as $emple) {

            $unidad = $emple->getUnidadOrganizativa();
            if ($unidad == null)
                $unidad = new UnidadOrganizativa();


            $rows[$i]['id'] = $emple->getIdEmpleado();
            $rows[$i]['cell'] = array($emple->getIdEmpleado(),
                $emple->getPrimerNombre(),
                $emple->getSegundoNombre(),
                $emple->getPrimerApellido(),
                $emple->getSegundoApellido(),
                $emple->getDui(),
                $emple->getEmail(),
                $unidad->getNombreUnidad());
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ',' ', ' ', ' ', ' ', ' ', ' ');
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
    
    
}



?>
