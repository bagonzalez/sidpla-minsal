<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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
use MinSal\SidPla\IndicadoresTemplateBundle\EntityDao\EvaluacionIndicadorDao;
use MinSal\SidPla\IndicadoresTemplateBundle\Entity\EvaluacionIndicador;


/**
 * Description of AccionEvaluaciondeResultadosUnisalController
 *
 * @author edwin
 */
class AccionEvaluaciondeResultadosUnisalController extends Controller{
 
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
        foreach ($proTemplate as $proUnisalTmp){
            $objetivos=$proUnisalTmp->getObjeEspeProgra();            
        }
        
        return $objetivos;        
    }
    
    
    public function obtenerObjEspecElaboracion(){        
        $proUnisalTmp=new ProUnisalTemplate(); 
        $proUnisalTmpDao= new ProUnisalTemplateDao($this->getDoctrine());
        $anio = date('Y')+1;       
        
        $proTemplate=$proUnisalTmpDao->obtenerObjTempAnio($anio);
        foreach ($proTemplate as $proUnisalTmp){
            $objetivos=$proUnisalTmp->getObjeEspeProgra();            
        }
        
        return $objetivos;        
    }
    
     public function showEvaluaciondeResultadosUNISALAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerObjEspec();
         
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $evalIndicador=$paoElaboracion->getEvaluacionResultado();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $actividadesProgramon=$programacionMonitoreo->getActividadesUniSal();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
         $areaClasificacionDao=new AreaClasificacionDao($this->getDoctrine());
         $areasClasif=$areaClasificacionDao->getAreaClasificacions();
         
         $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
       
         $trimestre=4;
         $mes=1;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         $evalIndicador=1;
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:EvaluaciondeResultadosUnisal:EvaluacionResultadosUNISAL.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon,
                   'mes' => $mes, 'trimestre' => $trimestre, 'idUnidad' => $idUnidad, 'areasClasif' => $areasClasif , 'idProgramon' =>$idProgramon,'evalIndicador' =>$evalIndicador ));
    }
    
     
    
    public function guardarEvaluaciondeResultadosUNISALAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $request = $this->getRequest();
       
          
            $numero = count($_POST);
            $tags = array_keys($_POST);// obtiene los nombres de las varibles
            $valores = array_values($_POST);// obtiene los valores de las varibles

            
            $resultadoIndiDao=new EvaluacionIndicadorDao($this->getDoctrine());
            $resultadoIndi=new EvaluacionIndicador();
            for($i=0;$i<$numero;$i++){                
                $cadena=$tags[$i];
               
                if((preg_match('/resultadoEvaIndicador_/',$cadena))==1){
                    $idResultadoRealizado=substr($tags[$i], 22);
                    $valorRealizado=$valores[$i];
                    
                    if($valorRealizado>0){
                        $resultadoIndiDao->editarEvaluacionIndicador($idResultadoRealizado,$valorRealizado);
                                               
                    }
                }  
            }
         
         return $this->showEvaluaciondeResultadosUNISALAction();
    }
    
    
    
}

?>