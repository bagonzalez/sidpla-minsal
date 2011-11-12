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
use MinSal\SidPla\TemplateUnisalBundle\Entity\ResultActUniSal;

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ProUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ResultActUniSalDao;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ActividadUniSalDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ActividadUniSal;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\AreaClasificacionDao;

use MinSal\SidPla\CensoBundle\Entity\CensoPoblacion;


/**
 * Description of AccionPrograMonUNISALController
 *
 * @author bgonzalez
 */
class AccionPrograMonUNISALController extends Controller {
    
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
    
    
     public function obtenerPaoElaboracion(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());        
       
        
        $paoElaboracion=new Pao();        
        $paoElaboracion=$unidaDao->getPaoElaboracion($idUnidad);
        
        return $paoElaboracion;
        
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
    
    
    
    public function obtenerObjEspec(){        
        $proUnisalTmp=new ProUnisalTemplate(); 
        $proUnisalTmpDao= new ProUnisalTemplateDao($this->getDoctrine());
        $anio = date('Y');       
        
        $proTemplate=$proUnisalTmpDao->obtenerObjTempAnio($anio);
        $objetivos=$proTemplate->getObjeEspeProgra();            
        
        
        return $objetivos;        
    }
    
    
    public function obtenerObjEspecElaboracion(){        
        $proUnisalTmp=new ProUnisalTemplate(); 
        $proUnisalTmpDao= new ProUnisalTemplateDao($this->getDoctrine());
        $anio = date('Y')+1;       
        
        $proTemplate=$proUnisalTmpDao->obtenerObjTempAnio($anio);
        $objetivos=$proTemplate->getObjeEspeProgra();  
        
        return $objetivos;        
    }
    
     public function showProgramacionMonitoreoUNISALAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerObjEspec();
         
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $actividadesProgramon=$programacionMonitoreo->getActividadesUniSal();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
         $areaClasificacionDao=new AreaClasificacionDao($this->getDoctrine());
         $areasClasif=$areaClasificacionDao->getAreaClasificacions();
        
         $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
         //$actividadesProgramon=$promMonDao->getActividadesUniSal($idProgramon);
         $mes=date('m');
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo:programacionMonitoreoUNISAL.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon,
                    'mes' => $mes, 'idUnidad' => $idUnidad, 'areasClasif' => $areasClasif , 'idProgramon' =>$idProgramon ));
    }
    
    
    public function construccionProgramacionMonitoreoUNISALAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerObjEspecElaboracion();
         
         $paoElaboracion=$this->obtenerPaoElaboracion();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $censopoblacio=$paoElaboracion->getCesopoblacion();         
         
         $actividadesProgramon=$programacionMonitoreo->getActividadesUniSal();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
         $areaClasificacionDao=new AreaClasificacionDao($this->getDoctrine());
         $areasClasif=$areaClasificacionDao->getAreaClasificacions();
        
         $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());         
         $mes=12;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo:construccionProgramacionMonitoreoUNISAL.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon, 
                       'mes' => $mes, 'idUnidad' => $idUnidad, 'areasClasif' => $areasClasif,
                        'censopoblacion' => $censopoblacio));
    }
    
    
    public function guardarProgramacioUniSalAction()
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
            
            $resultadoActDao=new ResultActUniSalDao($this->getDoctrine());
            $resultadoAct=new ResultActUniSal ();
            
            $actividadUnisalDao=new ActividadUniSalDao($this->getDoctrine());
            $actividadUnisal=new ActividadUniSal();
            
            
            for($i=0;$i<$numero;$i++){                
                $cadena=$tags[$i];
               
                if((preg_match('/resultadoProgramado_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 20);
                    $valorRealizado=$valores[$i];
                    
                    if($valorRealizado>=0){
                        $resultadoAct=$resultadoActDao->getResultActUnisal($idResultadoRealizado);
                        $resultadoAct->setResulActProgramado($valorRealizado);                    
                        $resultadoActDao->guardarResulAct($resultadoAct);                        
                    }
                }
                
                if((preg_match('/metaAnualActividadUniSal_/',$cadena))==1){
                    $idActividadUniSal=substr($tags[$i], 25);
                    $valorRealizado=$valores[$i];
                    
                    $actividadUnisal=$actividadUnisalDao->getActividadUniSal($idActividadUniSal);
                    $actividadUnisal->setMetaAnualActUni($valorRealizado);         
                    $actividadUnisalDao->guardarActividad($actividadUnisal);       
                }                
                 
                if((preg_match('/responsableActividadUniSal_/',$cadena))==1){
                    $idActividadUniSal=substr($tags[$i], 27);
                    $responsableActUni=$valores[$i];                    
                    
                    $actividadUnisal=$actividadUnisalDao->getActividadUniSal($idActividadUniSal);
                    $actividadUnisal->setResponsableActUni($responsableActUni);         
                    $actividadUnisalDao->guardarActividad($actividadUnisal);                     
                }
                
                if((preg_match('/costoProgramon_/',$cadena))==1){
                    $idActividadUniSal=substr($tags[$i], 15);
                    $costo=$valores[$i];
                    if($costo>0){                    
                        $actividadUnisal=$actividadUnisalDao->getActividadUniSal($idActividadUniSal);
                        $actividadUnisal->setCosto($costo);         
                        $actividadUnisalDao->guardarActividad($actividadUnisal);                     
                    }
                }
                
                if((preg_match('/coberturaActividadUniSal_/',$cadena))==1){
                    $idActividadUniSal=substr($tags[$i], 25);
                    $cobertura=$valores[$i];
                    if($cobertura>0){                    
                        $actividadUnisal=$actividadUnisalDao->getActividadUniSal($idActividadUniSal);
                        $actividadUnisal->setCoberActUni($cobertura);         
                        $actividadUnisalDao->guardarActividad($actividadUnisal);                     
                    }
                }
                
            }
         
         return $this->construccionProgramacionMonitoreoUNISALAction();
    }
    
    
    public function guardarSeguimientoProgramacioUniSalAction()
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
            
            $resultadoActDao=new ResultActUniSalDao($this->getDoctrine());
            $resultadoAct=new ResultActUniSal ();
            
            $actividadUnisalDao=new ActividadUniSalDao($this->getDoctrine());
            $actividadUnisal=new ActividadUniSal();
            
            
            for($i=0;$i<$numero;$i++){                
                $cadena=$tags[$i];
               
                if((preg_match('/resultadoRealizado_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 19);
                    $valorRealizado=$valores[$i];
                    
                    if($valorRealizado>0){
                        $resultadoAct=$resultadoActDao->getResultActUnisal($idResultadoRealizado);
                        $resultadoAct->setResulActRealizado($valorRealizado);                    
                        $resultadoActDao->guardarResulAct($resultadoAct);                        
                    }
                }
                
                if((preg_match('/costoReal_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 10);
                    $valorRealizado=$valores[$i];
                    
                    if($valorRealizado>0){
                        $resultadoAct=$resultadoActDao->getResultActUnisal($idResultadoRealizado);
                        $resultadoAct->setCostoReal($valorRealizado);                    
                        $resultadoActDao->guardarResulAct($resultadoAct);                        
                    }
                }
                
                
            }
         
         return $this->showProgramacionMonitoreoUNISALAction();
    }
    
    
}

?>
