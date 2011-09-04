<?php

namespace MinSal\SidPla\CensoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use MinSal\SidPla\CensoBundle\EntityDao\BloqueCensoDao;
use MinSal\SidPla\CensoBundle\Entity\BloqueCenso;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminBloqueController
 *
 * @author edwin
 */


class AccionAdminBloqueController extends Controller {
    //put your code here

    public function consultarBloqueCensoAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
       
        $BloqueCeDao=new BloqueCensoDao($this->getDoctrine());        
        $BloqueCeT=$BloqueCeDao->getBloqueCen();        
        
        return $this->render('MinSalSidPlaCensoBundle:BloqueCenso:manttBloqueCenso.html.twig'
                , array('opciones' => $opciones, 'BloqueCeT' => $BloqueCeT));              
    } 
    
    public function consultarBloqueCensoJSONAction(){
        
       
         $bloqueCensoDao=new BloqueCensoDao($this->getDoctrine());        
        $BloqueCeT=$bloqueCensoDao->getBloqueCen();  
         
        
        $numfilas=count($BloqueCeT);  
            
            $uni=new BloqueCenso();
            $i=0;
            
            foreach ($BloqueCeT as $uni) {
                $rows[$i]['id']= $uni->getIdBloque();
                $rows[$i]['cell']= array($uni->getIdBloque(),
                                         $uni->getNombreBloque(),
                                         $uni->getOrdenBloque());    
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
    
    
   public function manttBloqueCensoEdicionAction(){
            
            $request=$this->getRequest();
            $nombrebloqueCe=$request->get('Nombre');
            $ordenbloqueCe=$request->get('Orden');            
            $id=$request->get('id');
            
            $operacion=$request->get('oper'); 
            
            $BloqueCenDao=new BloqueCensoDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $BloqueCenDao->editBloqueCen($nombrebloqueCe, $ordenbloqueCe, $id);
            }
            
            if($operacion=='del'){
                $BloqueCenDao->delBloqueCen($id);        
            }
            
            if($operacion=='add'){
                $BloqueCenDao->addBloqueCen($nombrebloqueCe, $ordenbloqueCe);
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        }
    
    
    
    
    
}

?>
