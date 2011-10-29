<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

class AccionResultEspeEntControlController extends Controller {

    public function consultarResultadosEsperadosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoAux = $objetivoDao->getObjetEspecif($idfila);
        $objetivosEspec = $objetivoAux->getDescripcion();
        $uniControl = $this->obtenerUnidadOrg();
        $resultadosEsperados = $uniControl->getResultadosEsperados();
        
        $objUniControl = true;

        if(count($resultadosEsperados)==0)
            return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec,'objUniControl' => $objUniControl));
        else
            return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                array('opciones' => $opciones, 'idfila' => $idfila, 'descripcion' => $objetivosEspec,'resultadosEsperado'=>$resultadosEsperados,
                    'objUniControl' => $objUniControl));
        
       
    }
    
    public function obtenerUnidadOrg() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        //$unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        return $unidad;
    }

}

?>
