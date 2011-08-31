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

/**
 * Description of AccionAdminEmpleadosController
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;

class AccionAdminEmpleadosController extends Controller {
    
         /*
         * Mantenimineto de Empleados.
         * 
         */
        
        public function mattEmpleadosAction()
	{
            $opciones=$this->getRequest()->getSession()->get('opciones'); 
            
            //$user = $this->get('security.context')->getToken()->getUser();
            
            return $this->render('MinSalSidPlaAdminBundle:Empleado:manttEmpleados.html.twig', 
                    array('opciones' => $opciones,));
            
	}
        
        
        public function consultarEmpleadosJSONAction()
	{
            $request=$this->getRequest();
            $empleadoDao=new EmpleadoDao($this->getDoctrine());
            $empleados=$empleadoDao->getEmpleados();
            
            $numfilas=count($empleados);  
            
            $emple=new Empleado();
            $i=0;
            
            foreach ($empleados as $emple) {
                
                $unidad=$emple->getUnidadOrganizativa();
                 if($unidad==null)
                     $unidad=new UnidadOrganizativa();
                
                
                $rows[$i]['id']= $emple->getIdEmpleado();
                $rows[$i]['cell']= array($emple->getIdEmpleado(),
                                         $emple->getPrimerNombre(),
                                         $emple->getSegundoNombre(),
                                         $emple->getPrimerApellido(),
                                         $emple->getSegundoApellido(),
                                         $emple->getDui(),
                                         $unidad->getNombreUnidad());    
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
            
        
        /*
         * Mantenimiento de empleados
         * Eliminar, agregar, editar
         * 
         */
        
        public function manttEmpleadoEdicionAction(){
            
            $request=$this->getRequest();           
            
            
            
            $dui=$request->get('dui');
            $nombrePrimero=$request->get('nombrePrimero');
            $nombreSegundo=$request->get('nombreSegundo');
            $primerApellido=$request->get('primerApellido');
            $segundoApellido=$request->get('segundoApellido');
            $unidadAsignada=$request->get('unidad');
            
            $id=$request->get('id');            
            $operacion=$request->get('oper'); 
            
            $empleadoDao=new EmpleadoDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $empleadoDao->editEmpleado($dui, $nombrePrimero, $nombreSegundo, $primerApellido, $segundoApellido, $id, $unidadAsignada);
            }
            
            if($operacion=='del'){
                $empleadoDao->delEmpleado($id);        
            }
            
            if($operacion=='add'){
                $empleadoDao->addEmpleado($dui, $nombrePrimero, $nombreSegundo, $primerApellido, $segundoApellido, $unidadAsignada);
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        }     
    
}

?>
