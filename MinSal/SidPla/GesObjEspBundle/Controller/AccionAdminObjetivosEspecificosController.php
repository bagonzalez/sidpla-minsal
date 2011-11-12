<?php

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\CaractOrgDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\PaoBundle\Entity\Pao;

class AccionAdminObjetivosEspecificosController extends Controller {

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

    public function consultarObjetivosEspecificosAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();

        $empleado = $user->getEmpleado();

        $idUnidad = $empleado->getUnidadOrganizativa()->getIdUnidadOrg();

        $unidaDao = new UnidadOrganizativaDao($this->getDoctrine());
        $unidad = new UnidadOrganizativa();

        $unidad = $unidaDao->getUnidadOrg($idUnidad);
        $caractOrg = $unidad->getCaractOrg();
        $objetivosEspec = $caractOrg->getObjetivosEspec();



        if (count($objetivosEspec) == 0)
            return $this->render('MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones, 'idCaractOrg' => $caractOrg->getIdCaractOrg(), 'idDepen' => $idUnidad));
        else {

            return $this->render('MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig', array('opciones' => $opciones, 'idCaractOrg' => $caractOrg->getIdCaractOrg(), 'objetivos' => $objetivosEspec, 'idDepen' => $idUnidad));
        }
    }

    public function ingresarObjetivoEspecificoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idCaractOrg = $request->get('idCaractOrg');

        return $this->render('MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:gestionObjetivosEspecificos.html.twig', array('opciones' => $opciones, 'idCaractOrg' => $idCaractOrg));
    }

    public function editarObjetivoEspecificoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $id = $request->get('id');
        $idCaractOrg = $request->get('idCaractOrg');

        $objetivoEspecificoDao = new ObjetivoEspecificoDao($this->getDoctrine());
        $objetivoEspecifico = $objetivoEspecificoDao->getObjetEspecif($id);

        $objetivo = $objetivoEspecifico->getDescripcion();

        return $this->render('MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:gestionObjetivosEspecificos.html.twig', array('opciones' => $opciones, 'id' => $id, 'objetivo' => $objetivo, 'idCaractOrg' => $idCaractOrg));
    }

    public function manttObjetivosEspecificosAction() {

      $request = $this->getRequest();

      $id = $request->get('id');
      $objetivo = $request->get('objetivo');
      $idCaractOrg = $request->get('idCaractOrg');

      $operacion = $request->get('oper');

      $objDao = new ObjetivoEspecificoDao($this->getDoctrine());

      if ($operacion == 'edit') {
      $objDao->editObjEspec($objetivo, $id);
      }

      if ($operacion == 'add') {
      $catOrgDao = new CaractOrgDao($this->getDoctrine());

      $paoElaboracion = $this->obtenerPaoElaboracionAction();
      $programacionMonitoreo = $paoElaboracion->getProgramacionMonitoreo();

      $catOrgDao->agregarObjEspec($objetivo,(int) $idCaractOrg, (int)$programacionMonitoreo->getPao()->getAnio());
      }

      return $this->consultarObjetivosEspecificosAction();
      } 
}

?>
