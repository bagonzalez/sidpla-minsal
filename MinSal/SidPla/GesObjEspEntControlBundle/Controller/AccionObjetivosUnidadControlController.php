<?php

namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\GesObjEspEntControlBundle\EntityDao\ObjTemplateDao;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjTemplate;
use MinSal\SidPla\GesObjEspEntControlBundle\Entity\ObjespTemplate;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\PaoBundle\EntityDao\PeriodoPaoDao;

class AccionObjetivosUnidadControlController extends Controller {

    public function consultarObjetivosEspecificosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $objTmpDao = new ObjTemplateDao($this->getDoctrine());
        $paoElaboracion=  $this->obtenerPaoElaboracionAction();
        $objTmp = $objTmpDao->obtenerObjTempAnio($paoElaboracion->getAnio());

        $objTmpAux = new ObjTemplate();
        $objEspTmps = new ObjTemplate();
        foreach ($objTmp as $objTmpAux) {
            $objEspTmps = $objTmpAux->getEspecificoObjTmp();
        }


        if (count($objEspTmps) == 0)
            return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', 
                    array('opciones' => $opciones));
        else
                return $this->render('MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', 
                array('opciones' => $opciones,'objetivos'=>$objEspTmps));
    }
    
    public function obtenerPaoElaboracionAction() {

        $user = new User();
        $empleado = new Empleado();
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();
        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();
        $unidad = $unidaDao->getUnidadOrg($idUnidad);

        $paoElaboracion = new Pao();
        $paoElaboracion = $unidaDao->getPaoElaboracion($idUnidad);

        return $paoElaboracion;
    }

}

?>
