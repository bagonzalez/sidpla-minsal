<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AccionAdminUnidadOrgController
 *
 * @author bagonzalez
 */
class AccionAdminUnidadOrgController extends Controller {
    
    public function consultarUnidadesOrgAction(){
        return new Response('hola soy consultar unidad org');        
    } 
    
    public function ingresoNuevaUnidadesOrgAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones'); 
        
        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', 
                    array('opciones' => $opciones,  ));       
    }
    
     public function ingresarUnidadOrgAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones'); 
        $request=$this->getRequest();
        $nombreUnidad=$request->get('nombreUnidad');
        $direccion=$request->get('direccion');
        $responsable=$request->get('responsable');
        $telefono=$request->get('telefono');
        $fax=$request->get('fax');
        $tipoUnidad=$request->get('tipoUnidad');
        $unidadPadre=$request->get('unidadPadre');
        
        
        
        
        
        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', 
                    array('opciones' => $opciones,  ));       
     }
    
    
}

?>
