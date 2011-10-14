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
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;



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
    
    public function generarProgramacionJSONAction(){
        
        $paoElaboracion=$this->obtenerPaoSeguimiento();
        $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
        $idProgramon=$programacionMonitoreo->getIdPrograMon();
        
        $promMonDao=new ProgramacionMonitoreoDao($this->getDoctrine());
        $actividades=$promMonDao->getActividades($idProgramon);
        
        $numfilas=count($actividades);  
            
        $i=0;
        $rows='';
        $actividad=new Actividad();        
        $resultadoActividad=new ResulActividad();
        $actividadDao=new ActividadDao($this->getDoctrine());
        
        foreach ($actividades as $actividad) {
                
                $actividad=$actividadDao->getActividad($actividad->getIdAct()); 
                
                $resultadosActividad=$actividad->getResulAct();
                $resulEspec=new ResultadoEsperado;
                $resulEspec=$actividad->getIdResEsp();
                $objEspec=new ObjetivoEspecifico();
                $objEspec=$resulEspec->getIdObjEsp();
                
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
            
         $datos=json_encode($rows);            
            
            
         $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';


         $response=new Response($jsonresponse);              
         return $response;  
    }
    
}

?>
