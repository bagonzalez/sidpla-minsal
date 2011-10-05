<?php

namespace MinSal\SidPla\DepUniBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MinSal\SidPla\DepUniBundle\Entity\DepartamentoUni;
use MinSal\SidPla\DepUniBundle\EntityDao\DepartamentoUniDao;

use MinSal\SidPla\DepUniBundle\Entity\TipoRRHumano;
use MinSal\SidPla\DepUniBundle\EntityDao\TipoRRHumanoDao;

//Para saber que unidad organizativa a la que pertenece y mostrar los elementos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class DefaultController extends Controller {

    public function principalAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $uniOrg=$this->obtenerUniOrg();
                
        $deptoUniDao= new DepartamentoUniDao($this->getDoctrine());
        $combodepto=$deptoUniDao->obtenerDeptoUni($uniOrg);
        
        $tipoRRHHDao= new TipoRRHumanoDao($this->getDoctrine());
        $comboRRHH=$tipoRRHHDao->obtenerRRHHcadena();
        
        return $this->render('MinSalSidPlaDepUniBundle:Default:manttDeptoHumano_RRHH.html.twig'
                        , array('opciones' => $opciones,'combodepto'=>$combodepto,'comboRRHH'=>$comboRRHH));
    }

    public function obtenerUniOrg() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        return $unidad;
    }

}
