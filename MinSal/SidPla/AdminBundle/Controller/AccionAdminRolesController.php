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
use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccionAdminRolesController extends Controller {

    /**
     *  Esta es la opcion del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase RolSistemaDao para
     *  manejar la persistencia de la entidad RolSistema, y retornara los
     *  mensajes de exito/fracaso del sistema.
     */
    public function addRolAction(Request $peticion) {
        $rol = new RolSistema();
        $form = $this->createForm(new RolSistemaType(), $rol);

        if ($peticion->getMethod() == 'POST') {
            $form->bindRequest($peticion);

            if ($form->isValid()) {
                $rolDao = new RolDao($this->getDoctrine());
                $mensajesSistema = $rolDao->addRol($rol);
                return new Response($mensajesSistema[0] . ' ' . $mensajesSistema[1]);
            }
        }
        return $this->redirect($this->generateUrl('MinSalSidPlaAdminBundle_homepage'));
    }

    /*
     * Crea un nuevo formulario, para ser utilizado, para crear un nuevo rol del sistema.
     */

    public function nuevoRolAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rol = new RolSistema();

        $form = $this->createForm(new RolSistemaType(), $rol);
        return $this->render('MinSalSidPlaAdminBundle:Default:rolFormTemplate.html.twig', array('form' => $form->createView(), 'opciones' => $opciones));
    }

    /*
     * Permite recuperar roles del sistema.
     * 
     */

    public function consultarRolesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();

        $numfilas = count($roles);

        $rol = new RolSistema();
        $i = 0;

        foreach ($roles as $rol) {
            $rows[$i]['id'] = $rol->getIdRol();
            $rows[$i]['cell'] = array($rol->getIdRol(),
                $rol->getNombreRol(),
                $rol->getFuncionesRol());
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ');
        }
        $datos = json_encode($rows);

        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;


        /* return $this->render('MinSalSidPlaAdminBundle:Roles:showAllRoles.html.twig', 
          array('roles' => $roles, 'opciones' => $opciones,)); */
    }

    /*
     * Mantenimineto de roles.
     * 
     */

    public function mattRolesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();
        return $this->render('MinSalSidPlaAdminBundle:Roles:manttRolesSystemForm.html.twig', array('roles' => $roles, 'opciones' => $opciones,));
    }

    /*
     * Opciones de mantenimiento de roles
     * Eliminar, agregar, editar
     * 
     */

    public function manttRolEdicionAction() {

        $request = $this->getRequest();

        $nombreRol = $request->get('nombre');
        $funciones = $request->get('funciones');
        $id = $request->get('id');

        $operacion = $request->get('oper');

        $rolDao = new RolDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $rolDao->editRol($nombreRol, $funciones, $id);
        }

        if ($operacion == 'del') {
            $rolDao->delRol($id);
        }

        if ($operacion == 'add') {
            $rolDao->addRol($nombreRol, $funciones);
        }

        return new Response("{sc:true,msg:''}");
    }

    public function asignarOpcRolesAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaAdminBundle:Roles:asignarOpcionesARoles.html.twig', array('opciones' => $opciones,));
    }

    /*
     *  Obtiene las opciones seleccionadas de un rol
     */

    public function opcionesAsignadasAction() {
        $idRol = $this->getRequest()->get('reg');

        $rolDao = new RolDao($this->getDoctrine());
        $opciones = $rolDao->consultarOpcSeleccRol($idRol);

        $numfilas = count($opciones);
        $opc = new OpcionSistema();
        $i = 0;

        foreach ($opciones as $opc) {
            $rows[$i]['id'] = $opc->getIdOpcionSistema();
            $rows[$i]['cell'] = array($opc->getIdOpcionSistema(),
                $opc->getNombreOpcion()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }
        
        $datos = json_encode($rows);
        $pages = floor($numfilas / 25)+1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';
        
        $response = new Response($jsonresponse);
        return $response;
    }

    /*
     * Obtiene las opciones del sistema no asignadas a un rol
     */

    public function opcionesSinAsignarAction() {
        $idRol = $this->getRequest()->get('reg');

        $rolDao = new RolDao($this->getDoctrine());
        $opciones = $rolDao->consultarOpcNoSeleccRol($idRol);

        $numfilas = count($opciones);
        $opc = new OpcionSistema();
        $i = 0;

        foreach ($opciones as $opc) {
            $rows[$i]['id'] = $opc->getIdOpcionSistema();
            $rows[$i]['cell'] = array($opc->getIdOpcionSistema(),
                $opc->getNombreOpcion()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }
        
        $datos = json_encode($rows);
        $pages = floor($numfilas / 25)+1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    /*
     *  Asigna una opcion a un rol seleccionado
     */

    public function insertOpcSeleccRolAction() {
        $idRol = $this->getRequest()->get('reg');
        $idOpc = $this->getRequest()->get('opc');

        $rolDao = new RolDao($this->getDoctrine());
        $rolDao->insertOpcSeleccRol($idRol, $idOpc);
        return $this->opcionesAsignadasAction();
    }

    /*
     *  Elimina un rol asignado a un rol
     */

    public function deleteOpcSeleccRolAction() {
        $idRol = $this->getRequest()->get('reg');
        $idOpc = $this->getRequest()->get('opc');

        $rolDao = new RolDao($this->getDoctrine());
        $rolDao->deleteOpcSeleccRol($idRol, $idOpc);
        return $this->opcionesAsignadasAction();
    }

}

?>
