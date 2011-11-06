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

use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;

use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ProUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\EntityDao\AreaClasificacionDao;

/**
 * Description of AccionUnidadesSupervisadas
 *
 * @author bgonzalez
 */
class AccionUnidadesSupervisadasController extends Controller {
    
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
        
        $objetivos=array();        
        $proTemplate=$proUnisalTmpDao->obtenerObjTempAnio($anio);
        $objetivos=$proTemplate->getObjeEspeProgra();
        
        return $objetivos;        
    }
    
    public function obtenerPaoSeguimiento($idUnidad){        
              
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $paoSegumiento=new Pao();        
        $paoSegumiento=$unidaDao->getPaoSeguimiento($idUnidad);
        
        return $paoSegumiento;
        
    }
    
    public function supervisarProgramonUnidadesAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
        
        
        $unidadOrgEmpleado=new UnidadOrganizativa();
        $subUnidad=new UnidadOrganizativa();
        $unidadOrgEmpleado=$this->obtenerUnidadOrg();
        $subunidades=$unidadOrgEmpleado->getSubUnidades();
        
        $paosSeguimiento= array();
        $pao;
        $prograMacionesMonitoreo=array();        
        $objetivos=$this->obtenerObjEspec();
        
        foreach ($subunidades as $subUnidad){             
            $pao=$this->obtenerPaoSeguimiento($subUnidad->getIdUnidadOrg());
            $paosSeguimiento[]=$pao;   
        }
        
       return $this->render('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo:supervisarUnidadesProgramon.html.twig', 
                array( 'opciones' => $opciones, 'subUnidades' => $subunidades ,
                       'paosSeguimiento' => $paosSeguimiento, 'objetivos' => $objetivos  ));
        
    }
    
    public function supervisarResultadosEspecAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');        
        
        $objetivos=$this->obtenerObjEspec();
        
        $unidadOrgEmpleado=new UnidadOrganizativa();
        $subUnidad=new UnidadOrganizativa();
        $unidadOrgEmpleado=$this->obtenerUnidadOrg();
        $subunidades=$unidadOrgEmpleado->getSubUnidades();
        
        $paosSeguimiento= array();
        $pao;
        $prograMacionesMonitoreo=array();    
        
         $areaClasificacionDao=new AreaClasificacionDao($this->getDoctrine());
         $areasClasif=$areaClasificacionDao->getAreaClasificacions();
        
        
        foreach ($subunidades as $subUnidad){             
            $pao=$this->obtenerPaoSeguimiento($subUnidad->getIdUnidadOrg());
            $paosSeguimiento[]=$pao;   
        }
        
       return $this->render('MinSalSidPlaPrograMonitoreoBundle:EvaluaciondeResultadosUnisal:supervisarResultEsperadosUNISAL.html.twig', 
                array( 'opciones' => $opciones, 'subUnidades' => $subunidades ,
                       'paosSeguimiento' => $paosSeguimiento, 'objetivos' => $objetivos
                    ,'areasClasif' => $areasClasif ,));
        
    }
    
}

?>
