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

namespace MinSal\SidPla\UnidadOrgBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UnidadOrgBundle\Form\Type\InfoCaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Form\Type\CaractOrgType;
use MinSal\SidPla\UnidadOrgBundle\Entity\CaractOrg;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;

use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\UnidadOrgBundle\Entity\FuncionEspecifica;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\CaractOrgDao;




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
    
    public function guardarCaracteristicasAction(Request $peticion)
    {
         $request=$this->getRequest();         
         $totalFunciones=$request->get('totalFunciones');         
         $totalObjetivos=$request->get('totalObjetivos'); 
         
         $caractOrg=new CaractOrg(); 
         $form = $this->createForm(new CaractOrgType(), $caractOrg);
         
        if ($peticion->getMethod() == 'POST') {            
            $form->bindRequest($peticion);
            
            if ($form->isValid()) {
                    $catOrgDao = new CaractOrgDao($this->getDoctrine());  
                    
                    
                    
                     
         
                     for($i=1; $i<=$totalFunciones;$i++ ){
                         $funcion=$request->get('funciones_'.$i); 
                         
                         $funcionEspec=new FuncionEspecifica();
                         $funcionEspec->setFuncDescripcion($funcion);
                         $funcionEspec->setCaractOrg($caractOrg);
                         
                         $this->getDoctrine()->getEntityManager()->persist($funcionEspec);
                         $this->getDoctrine()->getEntityManager()->flush();	   
                         
                         $caractOrg->addFuncionesEspec($funcionEspec);
                         
                         $mensajesSistema = $catOrgDao->updateCaractOrg($caractOrg);	
                         
                         

                     }
                     
                     

                    
                    
                    return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:manttCategoriaCenso.html.twig', array('mensaje' => $mensajesSistema[0], 'opciones' => $opciones));                                     
            }
        }
        
        return $this->redirect($this->generateUrl('MinSalSidPlaCensoBundle_manttCatCenso'));
        
        
         
         for($i=1; $i<=$totalObjetivos;$i++ ){
             $objetivos=$request->get('objetivos_'.$i);  
             
         }
         
         return ingresarInfoCaractAction();
    }
}

?>
