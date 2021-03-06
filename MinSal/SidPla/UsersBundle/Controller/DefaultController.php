<?php

namespace MinSal\SidPla\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\UsersBundle\EntityDao\UserDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;

class DefaultController extends Controller {

    public function mostrarUsuariosSinRolAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();
        $aux = new RolSistema();
        $cadena = '';
        $i = 1;
        $n = count($roles);
        foreach ($roles as $aux) {
            if ($i != $n)
                $cadena.=$aux->getIdRol() . ':' . $aux->getNombreRol() . ';';
            else
                $cadena.=$aux->getIdRol() . ':' . $aux->getNombreRol();
            $i++;
        }

        return $this->render('MinSalSidPlaUsersBundle:Usuarios:manttUsuariosSinRol.html.twig', array('opciones' => $opciones, 'roles' => $cadena));
    }

    public function consultarUsuarioSinRolJSONAction() {

        $usuarioDao = new UserDao($this->getDoctrine());
        $usuarios = $usuarioDao->getUserSinRol();

        $numfilas = count($usuarios);

        $aux = new User();
        $i = 0;

        foreach ($usuarios as $aux) {
            $rows[$i]['id'] = $aux->getIdUsuario();
            $rows[$i]['cell'] = array($aux->getIdUsuario(),
                $aux->getUsername(),
                $aux->getEmpleado()->getPrimerNombre() . ' ' . $aux->getEmpleado()->getPrimerApellido(),
                $aux->getEmpleado()->getUnidadOrganizativa()->getNombreUnidad()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ');
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
    }

    public function editarUsuarioSinRolAction() {
        $request = $this->getRequest();
        $codigoUsuario = $request->get('id');
        $numRol = $request->get('rol');

        $userDao = new UserDao($this->getDoctrine());
        $userDao->editUserSinRol($codigoUsuario, $numRol);

        return new Response("{sc:true,msg:''}");
    }

    public function verificaCreacionAction() {
        $request = $this->getRequest();
        $idEmpleado = $request->get('idEmpleado');
        $username = $request->get('username');
        $email = $request->get('email');

        $empleadoDao = new EmpleadoDao($this->getDoctrine());
        $be = $empleadoDao->existeEmpleado($idEmpleado);

        $userDao = new UserDao($this->getDoctrine());
        $bu = $userDao->tieneOtroUsuario($idEmpleado);
        $bud = $userDao->usernameDisponible($username);
        $bemail = $userDao->emailDisponible($email);

        if ($be == 0) {
            $msj[0][0] = 'NO EXISTE EL EMPLEADO';
            $msj[0][1] = FALSE;
        } else {
            if ($bu != 0) {
                $msj[0][0] = 'NO SE PUEDE CREAR UN USUARIO PARA ESTE EMPLEADO PORQUE YA TIENE ASIGNADO UNO';
                $msj[0][1] = FALSE;
            } else {
                if ($bud != 0) {
                    $msj[0][0] = 'ESTE USUARIO YA ESTA EN USO, ESCRIBA UNO NUEVA EN NOMBRE DE USUARIO';
                    $msj[0][1] = FALSE;
                } else {
                    if ($bemail != 0) {
                        $msj[0][0] = 'ESTE EMAIL NO PUEDE UTILIZARSE, PORQUE YA TIENE USUARIO ASIGNADO';
                        $msj[0][1] = FALSE;
                    } else {
                        $msj[0][0] = 'SE HA CREADO EXITOSAMENTE';
                        $msj[0][1] = TRUE;
                    }
                }
            }
        }
        $datos = json_encode($msj);
        $numfilas = 1;
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "msj":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

}

