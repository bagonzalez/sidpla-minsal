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
 * Description of AccionAdminOpcionesController
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\EntityDao\OpcionSistemaDao;
use MinSal\SidPla\AdminBundle\Form\Type\OpcionSistemaType;
use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class AccionAdminOpcionesController extends Controller
{    
   
    /**
     *  Esta es la opcion del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase OpcionSistemaDao para
     *  manejar la persistencia de la entidad OpcionSistemaDao, y retornara los
     *  mensajes de exito/fracaso del sistema.
     */   
    
	
	public function addOcpAction(Request $peticion)
	{
            $opc=new OpcionSistema(); 
            $form = $this->createForm(new OpcionSistemaType() , $opc);
            
            if ($peticion->getMethod() == 'POST') {
                $form->bindRequest($peticion);

                if ($form->isValid()) {
                    $opcDao = new OpcionSistemaDao($this->getDoctrine());                
                    $mensajesSistema = $opcDao->addOpcion($opc);	                     
                    return new Response($mensajesSistema[0].' '.$mensajesSistema[1] );                    
                }
            }
            return $this->redirect($this->generateUrl('MinSalSidPlaAdminBundle_homepage'));	    
	}
        
        /*
         * Crea un nuevo formulario, para ser utilizado, para crear una Nueva Opcion del sistema.
         */
        
        
        public function nuevaOpcAction()
	{
            $opciones=$this->getRequest()->getSession()->get('opciones');
            
            $opc=new OpcionSistema();            
            
            $form = $this->createForm(new OpcionSistemaType() , $opc);
            return $this->render('MinSalSidPlaAdminBundle:Default:opcionFormTemplate.html.twig', 
                    array('form' => $form->createView(), 'opciones' => $opciones ));            
	}
        
        /*
         * Permite recuperar roles del sistema.
         * 
         */
        
        
        public function consultarOpcAction()
	{
            $opcDao=new OpcionSistemaDao($this->getDoctrine());
            $opciones=$opcDao->getOpciones();
            
            $numfilas=count($opciones);  
            
            $opc=new OpcionSistema();
            $i=0;
            
            foreach ($opciones as $opc) {
                $rows[$i]['id']= $opc->getIdOpcionSistema();
                $rows[$i]['cell']= array($opc->getIdOpcionSistema(),
                                         $opc->getNombreOpcion(),
                                         $opc->getDescripcionOpcion(),
                                         $opc->getEnlace(),
                                         $opc->getIdOpcionSistema2());    
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
         * Mantenimineto de opciones.
         * 
         */
        
        public function mattOpcionesAction()
	{
            $opciones=$this->getRequest()->getSession()->get('opciones'); 
            
            $opcDao=new OpcionSistemaDao($this->getDoctrine());
            $opciones=$opcDao->getOpciones();
            return $this->render('MinSalSidPlaAdminBundle:Opciones:manttOpcionesSystemForm.html.twig', 
                    array('opciones' => $opciones));            
	}
        
        
        public function manttOpcEdicionAction()
	{
            $request=$this->getRequest();
            
            $nombreOpc=$request->get('nombre');
            $descripcion=$request->get('descripcion');
            $enlace=$request->get('enlace');            
            $id=$request->get('id');
            $opcpadre=$request->get('opcpadre');
            $operacion=$request->get('oper'); 
            
            $opcDao=new OpcionSistemaDao($this->getDoctrine());
            
            if($operacion=='edit'){
                $opcDao->editOpcion($nombreOpc, $descripcion, $enlace, $id, $opcpadre);                
            }
            
            if($operacion=='del'){
                $opcDao->delOpcion($id);        
            }
            
            if($operacion=='add'){
                $opcDao->addOpcion($nombreOpc, $descripcion, $enlace, $opcpadre);                
            }
            
            return new Response("{sc:true,msg:''}");           
	}
        
        
}
