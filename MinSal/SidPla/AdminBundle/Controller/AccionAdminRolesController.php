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
 * 
 * 
 */

/**
 * Description of AccionAdminRolesController
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\AdminBundle\Form\Type\RolSistemaType;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccionAdminRolesController  extends Controller
{  
    /**
     *  Esta es la opcion del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase RolSistemaDao para
     *  manejar la persistencia de la entidad RolSistema, y retornara los
     *  mensajes de exito/fracaso del sistema.
     */
	
	public function addRolAction(Request $peticion)
	{
            $rol=new RolSistema(); 
            $form = $this->createForm(new RolSistemaType() , $rol);
            
            if ($peticion->getMethod() == 'POST') {
                $form->bindRequest($peticion);

                if ($form->isValid()) {
                    $rolDao = new RolDao($this->getDoctrine());                
                    $mensajesSistema = $rolDao->addRol($rol);	                     
                    return new Response($mensajesSistema[0].' '.$mensajesSistema[1] );                    
                }
            }
            return $this->redirect($this->generateUrl('MinSalSidPlaAdminBundle_homepage'));	    
	}
    
    
     /*
     * Crea un nuevo formulario, para ser utilizado, para crear un nuevo rol del sistema.
     */
        
        
        public function nuevoRolAction()
	{
            $rol=new RolSistema();            
            
            $form = $this->createForm(new RolSistemaType() , $rol);
            return $this->render('MinSalSidPlaAdminBundle:Default:rolFormTemplate.html.twig', 
                    array('form' => $form->createView(),  ));
            
	}
        
        /*
         * Permite recuperar roles del sistema.
         * 
         */
        
        
         public function consultarRolesAction()
	{
            $rolDao=new RolDao($this->getDoctrine());
            $roles=$rolDao->getRoles();
            return $this->render('MinSalSidPlaAdminBundle:Roles:showAllRoles.html.twig', 
                    array('roles' => $roles));
            
	}
}

?>
