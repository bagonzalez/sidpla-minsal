<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminResultadosEsperadosController
 *
 * @author edwin
 */

namespace MinSal\SidPla\GesObjEspBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

class AccionAdminResultadosEsperadosController extends Controller {
    //put your code here

    public function consultarResultadosEsperadosAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $prueba=5;
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'prueba' => $prueba));
        
    }
    
    
    public function consultarObjetivosEspecificosJSONAction()
    {
        
        $request=$this->getRequest();        
        $idCaractOrg=$request->get('idfila');
        
        $caractOrgAux=new CaractOrg();
        $catOrgDao = new CaractOrgDao($this->getDoctrine());                      
        $caractOrgAux=$catOrgDao->getCaractOrg($idCaractOrg);         
        
        $objetivosEspec=$caractOrgAux->getObjetivosEspec();
        
        $numfilas=count($objetivosEspec);  
            
        $objetivoEspec=new ObjetivoEspecifico();
        $i=0;

        foreach ($objetivosEspec as $objetivoEspec) { 
            $rows[$i]['id']= $objetivoEspec->getIdObjEspec();
            $rows[$i]['cell']= array($objetivoEspec->getIdObjEspec(),
                                     $objetivoEspec->getDescripcion()
                                     );    
            $i++;
        }
            
            $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"1",
               "total":"'.($numfilas/10).'",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;            
        
        
    }
      
    
    public function manttObjetivosEspecificosAction()
    {
        
        $request=$this->getRequest();            
        
        $objetivo=$request->get('objetivo');            
        $id=$request->get('id');
        $idCaractOrg=$request->get('idCaractOrg');

        $operacion=$request->get('oper'); 

        $objDao = new ObjetivoEspecificoDao($this->getDoctrine()); 

        if($operacion=='edit'){   
            $objDao->editObjEspec($objetivo, $id);            
        }

        if($operacion=='del'){
            $objDao->delObjEspec($id);
        }

        if($operacion=='add'){
            $catOrgDao = new CaractOrgDao($this->getDoctrine());                      
            $catOrgDao->agregarObjEspec($objetivo, $idCaractOrg );           
        }

        return new Response("{sc:true,msg:''}"); 
        
    }
    
    
    
    
    
}

?>
