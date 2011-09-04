<?php

namespace MinSal\SidPlaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\EntityDao\OpcionSistemaDao;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $user=new User();
        $rol=new RolSistema();
        $opciones=new OpcionSistema();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user!='anon.'){
            $rol=$user->getRol();
            $opciones=$rol->getOpcionesSistema();            
        }
        
        
        
        //$opcDao=new OpcionSistemaDao($this->getDoctrine());
        //$opciones=$opcDao->getOpciones();        
        
        $peticion =$this->getRequest();
        $sesion = $peticion->getSession();
        $sesion->set('opciones', $opciones);
        
        return $this->render('MinSalSidPlaBundle:Default:index.html.twig', array('opciones' => $opciones)); 
    }
}
