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

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;

use MinSal\SidPla\GesObjEspBundle\EntityDao\ActividadVinculadaDao;
use MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada;

/**
 * Description of AccionAdminVinculacionActividades
 *
 * @author bagonzalez
 */
class AccionAdminVinculacionActividadesController extends Controller {
    
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
    
    
    public function obtenerPaoElaboracionDependenciaAction($idUnidad){
        
               
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());        
        
        $paoElaboracion=new Pao();        
        $paoElaboracion=$unidaDao->getPaoElaboracion($idUnidad);
        
        return $paoElaboracion;
        
    }
    
    public function gestionVinculacionAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:gestionVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
    }
    
    
    public function mostrarActDependendientesAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVinculaConDependencias:showActividadesDependientes.html.twig', 
                array( 'opciones' => $opciones,));
    }
    
    public function aprobarVinculacionAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         $paoElaboracion=$this->obtenerPaoElaboracionAction();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         
         $actividadesVinculadasDestino=$programacionMonitoreo->getActvinculadasDestino();
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVinculaConDependencias:aprobarVinculacion.html.twig', 
                array( 'opciones' => $opciones, 'actividadesVinculadasDestino' => $actividadesVinculadasDestino  ));
    }
    
    public function agregarVinculacionAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:ingresarVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
        
    }
    
       public function agregarVinculacionDependenciasAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVinculaConDependencias:ingresarVinculacionConDep.html.twig', 
                array( 'opciones' => $opciones,));
        
    }
    
    public function vincularActividadesAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
          $request = $this->getRequest();
          
          $dependencia = $request->get('dependenciasCombo');
          $programacionMonitoreoDestino=null;
          
          if($dependencia){
                $paoElaboracionDestino=$this->obtenerPaoElaboracionDependenciaAction($dependencia);
                $programacionMonitoreoDestino=$paoElaboracionDestino->getProgramacionMonitoreo();                
          }
          
          $paoElaboracion=$this->obtenerPaoElaboracionAction();
          $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
          //$query = $this->getQuery();
          
          $idActividad = $request->get('actividadesCombo');
          $justificacion=$request->get('justificacion');
          $vinculacionEntreDepen=$request->get('vinculacionDepen');
          
            $numero = count($_GET);
            $tags = array_keys($_GET);// obtiene los nombres de las varibles
            $valores = array_values($_GET);// obtiene los valores de las varibles

            $actividadVinDao=new ActividadVinculadaDao($this->getDoctrine());
            // crea las variables y les asigna el valor
            for($i=0;$i<$numero;$i++){
                $idActividadAVincular = substr($tags[$i], 17);
                if($idActividadAVincular!=$idActividad && $idActividadAVincular>0)
                    $actividadVinDao->guardarActividadVinculada($idActividad, $idActividadAVincular, $justificacion, $vinculacionEntreDepen, $programacionMonitoreo, $programacionMonitoreoDestino);
                
            }
          
           
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:ingresarVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
        
    }
    
    
    public function desvincularActividadesAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         $request = $this->getRequest();
          
         $idActividadOrigen = $request->get('actividadesCombo');
         $idActividadDest=$request->get('actividadDestVin');
           
         $actividadVinDao=new ActividadVinculadaDao($this->getDoctrine());           
         $actividadVinDao->removeActividadVinculada($idActividadOrigen, $idActividadDest);
           
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:ingresarVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
        
    }
    
    
     public function obtenerActividadesVincJSONAction()
    { 
            $request=$this->getRequest();
            
            $idActividad = $request->get('actividadesCombo');
            
            $paoElaboracion=$this->obtenerPaoElaboracionAction();
            $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
            $idProgramon=$programacionMonitoreo->getIdPrograMon();
            
            $actividadvincDao=new ActividadVinculadaDao($this->getDoctrine());
            $actividades=$actividadvincDao->getActividadesVinculadas($idActividad);
            
            $numfilas=count($actividades);  
            
            
            $i=0;
            
            $actividad=new ActividadVinculada();
            $rows='';
            
            foreach ($actividades as $actividad) {
                
                $rows[$i]['id']= $actividad->getIdActVincu();
                $rows[$i]['cell']= array($actividad->getIdActVincu(),
                                         $actividad->getIdActDest(),
                                         $actividad->getIdActOrigen()                                         
                                         );    
                $i++;
            }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;  
         
        
    }
    
    
    public function obtenerActividadesVincDependicentesJSONAction()
    { 
            $request=$this->getRequest();
            
            $idActividad = $request->get('actividadesCombo');
            
            $paoElaboracion=$this->obtenerPaoElaboracionAction();
            $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
            $idProgramon=$programacionMonitoreo->getIdPrograMon();
            
            $actividadvincDao=new ActividadVinculadaDao($this->getDoctrine());
            $actividades=$actividadvincDao->getActividadesVinculadasDependientes($idActividad);
            
            $numfilas=count($actividades);  
            
            
            $i=0;
            
            $actividad=new ActividadVinculada();
            
            foreach ($actividades as $actividad) {
                
                $rows[$i]['id']= $actividad->getIdActVincu();
                $rows[$i]['cell']= array($actividad->getIdActVincu(),
                                         $actividad->getIdActDest(),
                                         $actividad->getIdActOrigen()                                         
                                         );    
                $i++;
            }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;  
         
        
    }
    
    
    public function obtenerActividadesJSONAction()
    { 
            $request=$this->getRequest();
            
            $idActividad = $request->get('actividadesCombo');
            $dependencia = $request->get('dependencia');
            $idProgramon='';
            
            if($dependencia){
                $paoElaboracion=$this->obtenerPaoElaboracionDependenciaAction($dependencia);
                $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
                $idProgramon=$programacionMonitoreo->getIdPrograMon();
            }else{
                $paoElaboracion=$this->obtenerPaoElaboracionAction();
                $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
                $idProgramon=$programacionMonitoreo->getIdPrograMon();                
            }           
            
            
            $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
            $actividades=$promMonDao->getActividades($idProgramon);
            
            $numfilas=count($actividades);  
            
            
            $i=0;
            $rows='';
            $actividad=new Actividad();
            
            foreach ($actividades as $actividad) {
                
                $rows[$i]['id']= $actividad->getIdAct();
                $rows[$i]['cell']= array($actividad->getIdAct(),
                                         $actividad->getActDescripcion(),
                                         $actividad->getActResponsable()
                                         
                                         );    
                $i++;
            }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;  
        
    }
    
    
    public function consultarUnidadesDependenciasJSONAction() {

        $unidadOrgDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidadesOrg = $unidadOrgDao->getUnidadesOrg();

        $numfilas = count($unidadesOrg);

        $uni = new UnidadOrganizativa();
        $i = 0;

        foreach ($unidadesOrg as $uni) {
            if($uni->getTipoUnidad()==1){
                $infogeneral = $uni->getInformacionGeneral();
                if ($infogeneral == null)
                    $infogeneral = new InformacionGeneral();


                $rows[$i]['id'] = $uni->getIdUnidadOrg();
                $rows[$i]['cell'] = array($uni->getIdUnidadOrg(),
                    $uni->getNombreUnidad(),
                    $uni->getDescripcionUnidad(),
                    '',
                    $infogeneral->getDireccion(),
                    $infogeneral->getTelefono());
                $i++;                
            }            
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ' . ' ');
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
    
    
    public function guardaEvaluacionVinculaAction(){
        
         $request=$this->getRequest();
         
         $idVinculacion = $request->get('ActVinID');
         $justificacionDepen=$request->get('justificacionDependencia');
         $estado=$request->get('estado');
         
         $actVincula=new ActividadVinculada();
         
         $actVinculaDao=new ActividadVinculadaDao($this->getDoctrine());
         $actVincula=$actVinculaDao->getActividadVinculada($idVinculacion);
         
         $actVincula->setJustificacionEstado($justificacionDepen);
         $actVincula->setEstado($estado);
         
         $actVinculaDao->guardarActividadVinculadaObj($actVincula);
          
         return $this->aprobarVinculacionAction();        
    }
    
    
}

?>
