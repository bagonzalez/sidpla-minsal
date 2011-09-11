<?php

namespace MinSal\SidPla\PaoBundle\Controller; // siempre va solo cambiar el bundle al que pertenece la entidad

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; // estas tres lineas siempre van


use MinSal\SidPla\PaoBundle\EntityDao\JustificacionDao;
use MinSal\SidPla\PaoBundle\Entity\Justificacion;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminMenCorreTempController
 *
 * @author Jenny
 */
class AccionJustificacionController extends Controller {
    //put your code here

         
    public function consultarJustificacionAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones'); //siempre va
       
        $JustificacioDao=new JustificacionDao($this->getDoctrine());  // haciendo una instancia dao      
       // $JustiDao=$JustificacioDao->getHistorialJustificacion();// aqui va el metodo que define en archivo para dao que obtiene todo    
        
        //trabajando con una justificacion en especifico
         //Este valor $id= 1 es una prueba, aqui debe capturarse ese id dependediendo del valor asignado
        // en la tabla pao,   que se le ha asignado a la unidad organizativa que esta haciendo la justificacion 
         $id=1;
        $JustiDao=$JustificacioDao->buscarJustificacion($id); 
        
        return $this->render('MinSalSidPlaPaoBundle:Justificacion:ManttJustificacion.html.twig' //aqui se define la carpeta en que se
                , array('opciones' => $opciones, 'MensajeJustifi' => $JustiDao));// almacenara el archivo .twig y el nombre del archivo             
    } 
    
     public function consultarJustificacionJSONAction(){
        
       
        $JustificacioDao=new JustificacionDao($this->getDoctrine());     // ENTIDAD DAO   
        $JustiDao=$JustificacioDao->getHistorialJustificacion(); // aqui va la entidad dao, get que obtiene el historial
         
        
        $numfilas=count($JustiDao);  
            
            $uni=new Justificacion();// entidad
            $i=0;
            
            foreach ($JustiDao as $uni) {
                $rows[$i]['id']= $uni->getIdJustificacion(); // metodo get del id de la entidad
                $rows[$i]['cell']= array($uni->getIdJustificacion(), // metodo de id de la entidad
                                         $uni->getPao_codigo(),
                                         $uni->getJustificacion_descripcion());  // metodo get de atributo descripcion
                                     
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
         * Opciones de mantenimiento de justificacion template
         * Eliminar, agregar, editar
         * 
         */
          
    
    public function manttJustificacionEdicionAction(){
            
            $request=$this->getRequest();
            $descripcionJusti=$request->get('Descripcion');
            $JustiPao=$request->get('codigoPao');            
            $id=$request->get('id'); // no se toca
            
            $operacion=$request->get('oper'); 
            
            $JustiDao=new JustificacionDao($this->getDoctrine()); // entidad DAO
            
            if($operacion=='edit'){                
                 $JustiDao-> editJustificacion($descripcionJusti, $JustiPao, $id); // Metodo definido en DAO
            }
            
            if($operacion=='del'){
                $JustiDao->delJustificacion($id);      // Metodo definido en el archivo DAO  
            }
            
            if($operacion=='add'){
                $JustiDao->addJustificacion($descripcionJusti, $JustiPao); // Metodo definido en entida dao
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        }   
        
        
        public function actualizarJustificacionAction(){
           $opciones=$this->getRequest()->getSession()->get('opciones');
            $request=$this->getRequest();
            $JustiPao=$request->get('justificacion');            
            $id=$request->get('id');
            $JustiDao=new JustificacionDao($this->getDoctrine());
            $JustiDao-> actualizacionJustificacion($JustiPao, $id);
     
                       
            return $this->render('MinSalSidPlaAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
            //return $this->render('MinSalSidPlaPaoBundle:Justificacion:ManttJustificacion.html.twig' //aqui se define la carpeta en que se
             //   , array('opciones' => $opciones,));    
            
        }
      
        
        }
     ?>