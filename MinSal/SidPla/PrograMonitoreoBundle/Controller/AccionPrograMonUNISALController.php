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

use MinSal\SidPla\TemplateUnisalBundle\EntityDao\ProUnisalTemplateDao;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ProUnisalTemplate;
use MinSal\SidPla\TemplateUnisalBundle\Entity\ObjetivoEspeUnisal;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\ProgramacionMonitoreoDao;

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
    
     public function showProgramacionMonitoreoUNISALAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');   
         $objetivos=$this->obtenerObjEspec();
         
         $paoElaboracion=$this->obtenerPaoSeguimiento();
         $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
         $actividadesProgramon=$programacionMonitoreo->getActividadesUniSal();
         $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
         $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
         //$actividadesProgramon=$promMonDao->getActividadesUniSal($idProgramon);
         $mes=5;
         
         $uniControl=new UnidadOrganizativa();            
         $uniControl=$this->obtenerUnidadOrg();
         $idUnidad=$uniControl->getIdUnidadOrg();
         
         return $this->render('MinSalSidPlaPrograMonitoreoBundle:ProgramacionMonitoreo:programacionMonitoreoUNISAL.html.twig', 
                array( 'opciones' => $opciones, 'objetivos' => $objetivos, 'actividades' => $actividadesProgramon, 'mes' => $mes, 'idUnidad' => $idUnidad ));
    }
    
    
}

?>
