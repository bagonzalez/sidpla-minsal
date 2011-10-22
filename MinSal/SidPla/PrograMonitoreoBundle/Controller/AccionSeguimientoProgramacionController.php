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

/**
 * Description of AccionSeguimientoProgramacionController
 *
 * @author bagonzalez
 */
class AccionSeguimientoProgramacionController extends Controller {
    
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
    
    public function generarProgramacionJSONAction(){
        
        $paoElaboracion=$this->obtenerPaoSeguimiento();
        $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
        $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
        $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
        $actividadesProgramon=$promMonDao->getActividades($idProgramon);
        
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
                                        
                                        $arrayDatosResulAct=array($objEspec->getDescripcion(),
                                                                  $resulEspec->getResEspeDesc(),
                                                                  $actividad->getIdAct(),
                                                                  $actividad->getActDescripcion()); 

                                        foreach ($resultadosActividad as $resultadoActividad) {
                                            $arrayDatosResulAct[] = $resultadoActividad->getResulActTrimestre();
                                            $arrayDatosResulAct[] = $resultadoActividad->getResulActProgramado();
                                            $arrayDatosResulAct[] = $resultadoActividad->getResulActRealizado();
                                        }
                                        $rows[$i]['id']= $actividad->getIdAct();
                                        $rows[$i]['cell']=$arrayDatosResulAct;  
                                        $i++;                                        
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
    
    
    public function showProgramacionMonitoreoAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerUnidadOrgObjEspec();
         
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
         $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
         $actividadesProgramon=$promMonDao->getActividades($idProgramon);
         $trimestre=1;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo:programacionMonitoreo.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon, 'trimestre' => $trimestre, 'idUnidad' => $idUnidad ));
    }
    
    
        
    public function guardarSegumientoAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $request = $this->getRequest();
          //$query = $this->getQuery();
          
          //$idActividad = $request->get('actividadesCombo');
          //$justificacion=$request->get('justificacion');
          //$vinculacionEntreDepen=$request->get('vinculacionDepen');
          
            $numero = count($_POST);
            $tags = array_keys($_POST);// obtiene los nombres de las varibles
            $valores = array_values($_POST);// obtiene los valores de las varibles

            //$actividadVinDao=new ActividadVinculadaDao($this->getDoctrine());
            // crea las variables y les asigna el valor
            
            $resultadoActDao=new ResulActividadDao($this->getDoctrine());
            $resultadoAct=new ResulActividad();
            for($i=0;$i<$numero;$i++){                
                $cadena=$tags[$i];
               
                if((preg_match('/resultadoRealizado_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 19);
                    $valorRealizado=$valores[$i];
                    
                    if($valorRealizado>0){
                        $resultadoAct=$resultadoActDao->getResulActividad($idResultadoRealizado);
                        $resultadoAct->setResulActRealizado($valorRealizado);                    
                        $resultadoActDao->guardarResulAct($resultadoAct);                        
                    }
                }
                
                if((preg_match('/costoReal_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 10);
                    $costoReal=$valores[$i];
                    
                    if($costoReal>0){
                        $resultadoAct=$resultadoActDao->getResulActividad($idResultadoRealizado);
                        $resultadoAct->setCostoReal($costoReal);
                        $resultadoActDao->guardarResulAct($resultadoAct);
                        
                    }
                }
                
                //if($idActividadAVincular!=$idActividad && $idActividadAVincular>0)
                  //  $actividadVinDao->guardarActividadVinculada($idActividad, $idActividadAVincular, $justificacion, $vinculacionEntreDepen);

            }
         
         return $this->showProgramacionMonitoreoAction();
    }
    
}

?>
