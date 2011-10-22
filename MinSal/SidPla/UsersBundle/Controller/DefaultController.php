<?php

namespace MinSal\SidPla\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\UsersBundle\EntityDao\UserDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;

class DefaultController extends Controller {

 

    public function mostrarUsuariosSinRolAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaUsersBundle:Usuarios:manttUsuariosSinRol.html.twig', array('opciones' => $opciones));
    }
    
    public function consultarUsuarioSinRolJSONAction() {

        $usuarioDao=new UserDao($this->getDoctrine());
        $usuarios= $usuarioDao->getUser();

        $numfilas = count($usuarios);

        $aux = new User();
        $i = 0;

        foreach ($usuarios as $aux) {
            $rows[$i]['id'] = $aux->getIdUsuario();
            $rows[$i]['cell'] = array($aux->getIdUsuario(),
                $aux->getIdUsuario(),
                $aux->getEmpleado()->getPrimerNombre()
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
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

}
