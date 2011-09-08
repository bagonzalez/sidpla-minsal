<?php

namespace MinSal\SidPla\CensoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use MinSal\SidPla\CensoBundle\EntityDao\InformacionComplementariaDao;
use MinSal\SidPla\CensoBundle\Entity\InformacionComplementaria;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminCensoUsuarioController
 *
 * @author edwin
 */
class AccionAdminCensoUsuarioController extends Controller{
    //put your code here

    
    public function consultarInformacionComplementariaAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
       
        $InfoCompleDao=new InformacionComplementariaDao($this->getDoctrine());        
        $InformacionComplementariaT=$InfoCompleDao->getInfoComple();        
        
        return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
                , array('opciones' => $opciones, 'InformacionComplementariaT' => $InformacionComplementariaT));              
    } 
    
    
     public function consultarInformacionComplementariaJSONAction(){
        
       
         $InfoCompleDao=new InformacionComplementariaDao($this->getDoctrine());        
        $InfoCompleDaoT=$InfoCompleDao->getBloqueCen();  
         
        
        $numfilas=count($InfoCompleDaoT);  
            
            $uni=new InformacionComplementaria();
            $i=0;
            
            foreach ($InfoCompleDaoT as $uni) {
                $rows[$i]['id']= $uni->getIdInfoComp();
                $rows[$i]['cell']= array($uni->getIdInfoComp(),
                                         $uni->getAreaInfoComp(),
                                         $uni->getCodigoCensoPoblacion(),
                                         $uni->getCodigoCatCen(),
                                         $uni->getCantidadInfoComp());    
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
    
    
   public function manttInformacionComplementariaEdicionAction(){
            
            $request=$this->getRequest();
            $areaInfoComp=$request->get('Area');
            $censoCodigo=$request->get('censoCodigo');            
            $catCenCodigo=$request->get('catCenCodigo');  
            $cantidadInfoComp=$request->get('cantidadInfoComp');  
            $id=$request->get('id');
            
            $operacion=$request->get('oper'); 
            
            $InformacionComplementariaDao=new InformacionComplementariaDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $InformacionComplementariaDao->editInfoComple($areaInfoComp,$censoCodigo,$catCenCodigo,$cantidadInfoComp, $id);
            }
            
            if($operacion=='del'){
                $InformacionComplementariaDao->delInfoComple($id);        
            }
            
            if($operacion=='add'){
                $InformacionComplementariaDao->addInfoComple($areaInfoComp,$censoCodigo,$catCenCodigo,$cantidadInfoComp);
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        }
    
    
    
    
    

    
    
    
    
    
    
}

?>
