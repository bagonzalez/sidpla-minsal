<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\AdminBundle\EntityDao\DepartametoPaisDao;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\Entity\Municipio;
/**
 * Description of AccionAdminUnidadOrgController
 *
 * @author bagonzalez
 */
class AccionAdminUnidadOrgController extends Controller {
    
    public function consultarUnidadesOrgAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
       
        $unidadOrgDao=new UnidadOrganizativaDao($this->getDoctrine());        
        $unidadesOrg=$unidadOrgDao->getUnidadesOrg();        
        
        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:showAllUnidadesOrganizativas.html.twig'
                , array('opciones' => $opciones, 'unidadesorg' => $unidadesOrg));              
    } 
    
    public function consultarUnidadesOrgJSONAction(){
        
        $unidadOrgDao=new UnidadOrganizativaDao($this->getDoctrine());        
        $unidadesOrg=$unidadOrgDao->getUnidadesOrg(); 
        
        $numfilas=count($unidadesOrg);  
            
            $uni=new UnidadOrganizativa();
            $i=0;
            
            foreach ($unidadesOrg as $uni) {
                $rows[$i]['id']= $uni->getIdUnidadOrg();
                $rows[$i]['cell']= array($uni->getIdUnidadOrg(),
                                         $uni->getNombreUnidad(),
                                         $uni->getDescripcionUnidad());    
                $i++;
            }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;            
        
    }
    
    public function ingresoNuevaUnidadesOrgAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones'); 
        
        $departamDao=new DepartametoPaisDao($this->getDoctrine());
        $departamentos=$departamDao->getDepartametos();
        
        return $this->render('MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig', 
                    array('opciones' => $opciones, 'deptos' => $departamentos ));       
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
     
     public function consultarMunicipiosJSONAction()
	{
            $request=$this->getRequest();
            $idDpto=$request->get('departamento');
            $departamDao=new DepartametoPaisDao($this->getDoctrine());
            $municipios=$departamDao->consultarMunicipioDpto($idDpto);         
            
            $numfilas=count($municipios);  
            
            $muni=new Municipio();
            $i=0;
            
            foreach ($municipios as $muni) {
                $rows[$i]['id']= $muni->getIdMunicipio();
                $rows[$i]['cell']= array($muni->getIdMunicipio(),
                                         $muni->getNombreMunicipio(),
                                         $muni->getIdDepto());    
                $i++;
            }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"1",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;   
           
	}
    
    
}

?>
