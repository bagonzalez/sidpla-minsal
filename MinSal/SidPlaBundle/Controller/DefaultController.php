<?php

namespace MinSal\SidPlaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\EntityDao\OpcionSistemaDao;
use Symfony\Component\HttpFoundation\Request;



class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $opcDao=new OpcionSistemaDao($this->getDoctrine());
        $opciones=$opcDao->getOpciones();        
        
        $peticion =$this->getRequest();
        $sesion = $peticion->getSession();
        $sesion->set('opciones', $opciones);
        
        return $this->render('MinSalSidPlaBundle:Default:index.html.twig', array('opciones' => $opciones)); 
    }
}
