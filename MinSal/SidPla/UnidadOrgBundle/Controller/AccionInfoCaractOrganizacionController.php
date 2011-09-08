<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MinSal\SidPla\UnidadOrgBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\UnidadOrgBundle\Form\Type\InfoCaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Form\Type\CaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;

use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;

/**
 * Description of AccionInfoCaractOrganizacionController
 *
 * @author bgonzalez
 */
class AccionInfoCaractOrganizacionController extends Controller
{
    public function ingresarInfoCaractAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
        $user=new User();
        $empleado=new Empleado();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $empleado=$user->getEmpleado();
        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();

        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();
        $infoGeneral=new InformacionGeneral();
        
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        $nombreUnidad=$unidad->getNombreUnidad();
        $nombreUnidadPadre=$unidad->getParent()->getNombreUnidad();
        
        $infoGeneral=$unidad->getInformacionGeneral();
        $caractOrg=$unidad->getCaractOrg();
        
        
        $form = $this->createForm(new InfoCaractOrgType(), $infoGeneral);
        $formCaract = $this->createForm(new CaractOrgType(), $caractOrg);
        
        return $this->render('MinSalSidPlaUnidadOrgBundle:InforCaractOrg:ingresoInfoCaractOrg.html.twig', 
                array( 'form' => $form->createView(), 
                       'formOrg' => $formCaract->createView(), 
                       'opciones' => $opciones,
                       'unidadOrg' => $nombreUnidad,
                       'unidadPadre' => $nombreUnidadPadre,                                                       
                ));        
        
    } 
}

?>
