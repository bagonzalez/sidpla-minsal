<?php


namespace MinSal\SidPla\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use MinSal\SidPla\AdminBundle\EntityDao\MensajeCorreTempDao;
use MinSal\SidPla\AdminBundle\Entity\MensajeCorreTemp;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminMenCorreTempController
 *
 * @author edwin
 */
class AccionAdminMenCorreTempController extends Controller {
    //put your code here

         
    public function consultarMenCorrtempAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
       
        $MensajeCoDao=new MensajeCorreTempDao($this->getDoctrine());        
        $MensajeCorreT=$MensajeCoDao->getMensaTem();        
        
        return $this->render('MinSalSidPlaAdminBundle:MensajeCorreoTemplate:manttMensajesCorreoTemForm.html.twig'
                , array('opciones' => $opciones, 'MensajeCorreT' => $MensajeCorreT));              
    } 
    
     public function consultarMenCorrtempJSONAction(){
        
       
         $MensajeCoDao=new MensajeCorreTempDao($this->getDoctrine());        
        $MensajeCorreT=$MensajeCoDao->getMensaTem();  
         
        
        $numfilas=count($MensajeCorreT);  
            
            $uni=new MensajeCorreTemp();
            $i=0;
            
            foreach ($MensajeCorreT as $uni) {
                $rows[$i]['id']= $uni->getMencortemCodigo();
                $rows[$i]['cell']= array($uni->getMencortemCodigo(),
                                         $uni->getMencortemNombre(),
                                         $uni->getMencortemTexto());    
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
    
   /*
         * Opciones de mantenimiento de mensajes correo template
         * Eliminar, agregar, editar
         * 
         */
          
    
    public function manttMenCorrtempEdicionAction(){
            
            $request=$this->getRequest();
            $nombreRol=$request->get('texto');
            $funciones=$request->get('Nombre');            
            $id=$request->get('id');
            
            $operacion=$request->get('oper'); 
            
            $rolDao=new MensajeCorreTempDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $rolDao->editMensaTem($nombreRol, $funciones, $id);
            }
            
            if($operacion=='del'){
                $rolDao->delMensaTem($id);        
            }
            
            if($operacion=='add'){
                $rolDao->addMensaTem($nombreRol, $funciones);
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        } }
     ?>
