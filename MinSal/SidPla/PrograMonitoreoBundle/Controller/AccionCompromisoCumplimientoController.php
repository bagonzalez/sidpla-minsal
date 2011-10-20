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

namespace MinSal\SidPla\PrograMonitoreoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;


use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

use MinSal\SidPla\GesObjEspBundle\EntityDao\ActividadDao;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResulActividadDao;
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;

use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;

use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\CompromisoCumplimientoDao;

use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;


/**
 * Description of AccionCompromisoCumplimientoController
 *
 * @author edwin
 */
class AccionCompromisoCumplimientoController extends Controller {
    
    //para el caso de la creacion de la hoja compromiso cumplimiento 
    //se trabajara con la PAO EN SEGUIMIENTO
    
    public function obtenerPaoSeguimiento(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());        
       
        
        $paoSegumiento=new Pao();        
        $paoSegumiento=$unidaDao->getPaoSeguimiento($idUnidad);
        
        return $paoSegumiento;
        
    }
    
    
    public function consultarObjetivosEspecificosEntControl() {
        $request = $this->getRequest();
        $anio = date('Y')+1;        

        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
         if($objTmpDao->existeObjTmp($anio)==0)
            $objTmpDao->agregarObjetivoTemplate ($anio);
        $objTmp = $objTmpDao->obtenerObjTempAnio($anio);

        $numfilas = 0;
        $objTmpAux = new ObjTemplate();
        $rows='';
        
        $obEspecificos = new  ArrayCollection();
        
        
        $uniControl=new UnidadOrganizativa();            
        $uniControl=$this->obtenerUnidadOrg();
        $resultadosEsperados=$uniControl->getResultadosEsperados();
        
        foreach ($objTmp as $objTmpAux) {
            $i = 0;
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
            $aux = new ObjespTemplate();
            $numfilas = count($objEspTmps);

            foreach ($objEspTmps as $aux) {
                $objEspec=$aux->getIdObjEspec();                
                $obEspecificos[]= $objEspec;
                //$resultadosEspec = new  ArrayCollection();
                
                /*foreach ($resultadosEsperados as $resulEspec) {
                    if($resulEspec->getIdObjEsp()->getIdObjEspec()==$objEspec->getIdObjEspec()){
                        $resultadosEspec[]=$resulEspec;                        
                        $objEspec->addResultadoEsperado($resulEspec);
                    }                    
                } */               
            }
        }
        
        

        return $obEspecificos;
    }
    
      public function obtenerUnidadOrg(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();              
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        return $unidad;
        
    }
    
    
        
    public function obtenerUnidadOrgObjEspec(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();              
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        if($unidad->getTipoUnidad()==3){
            $objetivosEscpec=$this->consultarObjetivosEspecificosEntControl();
            
        }else{
            $objetivosEscpec=$unidad->getCaractOrg()->getObjetivosEspec();                    
        }
        
        
        return $objetivosEscpec;
        
    }
    
    public function ActividadesEnRetrasoJSONAction(){
        
        $paoElaboracion=$this->obtenerPaoSeguimiento();
        $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
        $idProgramon=$programacionMonitoreo->getIdPrograMon();
        $trim=1;
        $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
        $actividadesProgramon=$promMonDao->getActividades($idProgramon,$trim);
        
        $numfilas=count($actividadesProgramon);  
            
        $i=0;
        $rows='';
        $actividad=new Actividad();        
        $actividadAux=new Actividad();        
        $resultadoActividad=new ResulActividad();
        $objEspec=new ObjetivoEspecifico();
        $resulEspec=new ResultadoEsperado();
        
        
        $actividadDao=new ActividadDao($this->getDoctrine());
        
        $objetivosEscpec=$this->obtenerUnidadOrgObjEspec();
        
        
        foreach($objetivosEscpec as $objEspec){
                $resultadosEsperados=$objEspec->getResultadoEsperado();
                
                foreach($resultadosEsperados as $resulEspec){
                    $actividadesResulEspec=$resulEspec->getActividades();
                    
                    foreach ($actividadesResulEspec as $actividadAux) {                        
                                foreach ($actividadesProgramon as $actividad) {
                                    if($actividadAux->getIdAct()==$actividad->getIdAct()){
                                        
                                        $actividad=$actividadDao->getActividad($actividad->getIdAct()); 
                                        $resultadosActividad=$actividad->getResulAct();
                                        
                                     //   $arrayDatosResulAct=array($objEspec->getDescripcion(),
                                       //                           $resulEspec->getResEspeDesc(),
                                         //                         $actividad->getIdAct(),
                                           //                       $actividad->getActDescripcion()); 

                                        foreach ($resultadosActividad as $resultadoActividad) {
                                           $rows[$i]['id']= $resultadoActividad->getIdResulAct();
                                           $rows[$i]['cell']= array($resultadoActividad->getIdResulAct(),
                                                                    $resultadoActividad->getIdActividad()->getActDescripcion(),
                                                                    $resultadoActividad->getResulActProgramado(),
                                                                    $resultadoActividad->getResulActRealizado(),
                                                                    $resultadoActividad->getResulActFechaFin() 
                                               
                                               );
                                                 
                                             $i++; 
                                       
                                       }
                                                                            
                                    }
                             }
                    }
                }                
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
    
    
    public function showActividadesEnRetrasoAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerUnidadOrgObjEspec();
         
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
         $trimestre=1;
         $promMonDao=new CompromisoCumplimientoDao($this->getDoctrine());
         $actividadesProgramon=$promMonDao->getActividades($idProgramon,$trimestre);
         $trimestre=1;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:CompromisoCumplimiento.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon, 'trimestre' => $trimestre, 'idUnidad' => $idUnidad ));
     }
    
     public function ingresoActividadesEnRetrasoAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
       //  $objetivos=$this->obtenerUnidadOrgObjEspec();
         $request = $this->getRequest();
         
         $idResultActividad=$request->get('idresact');
        // $idResultActividad="88";
       $resultadoDao=new ResulActividadDao($this->getDoctrine());
        $resAct=new ResulActividad();              
        $resAct=$resultadoDao->getResulActividad($idResultActividad);
        $descrObjetivo=$resAct->getIdActividad()->getIdResEsp()->getIdObjEsp()->getDescripcion();
        $descrResultado=$resAct->getIdActividad()->getIdResEsp()->getResEspeDesc(); 
        $descrActividad=$resAct->getIdActividad()->getActDescripcion(); 
        $fechaOrigal=$resAct->getResulActFechaFin();
       
        
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:IngresoCompromisoCumplimiento.html.twig', 
                array( 'opciones' => $opciones, 'objetivo' => $descrObjetivo, 'actividad' => $descrActividad, 'resultado' => $descrResultado, 'idresact' => $idResultActividad));
     }
    
        
     
      public function guardarActividadesEnRetrasoAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $request = $this->getRequest();
         
         $idResultActividad=$request->get('idresact');
         $hallazgos=$request->get('hallazgosAct');
         $medidasadoptar=$request->get('medidasAct');
         $fechacumplimiento=$request->get('newdateend');
         $responsable=$request->get('responsable');
        
        
        $rDao=new ResulActividadDao($this->getDoctrine());
        $rDao->addCompromisoCumplimiento($hallazgos, $medidasadoptar, $fechacumplimiento, $responsable, $idResultActividad);
       
        
         
         
         $objetivos=$this->obtenerUnidadOrgObjEspec();
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
         $trimestre=1;
         $promMonDao=new CompromisoCumplimientoDao($this->getDoctrine());
         $actividadesProgramon=$promMonDao->getActividades($idProgramon,$trimestre);
         $trimestre=1;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
        
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:CompromisoCumplimiento:CompromisoCumplimiento.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon, 'trimestre' => $trimestre, 'idUnidad' => $idUnidad ));
     }
      
}

?>
