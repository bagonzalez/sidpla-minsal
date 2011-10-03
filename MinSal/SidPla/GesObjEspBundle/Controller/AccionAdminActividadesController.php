<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionAdminActividadesController
 *
 * @author edwin
 */
namespace MinSal\SidPla\GesObjEspBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;

use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResultadoEsperadoDao;

use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ActividadDao;


class AccionAdminActividadesController extends Controller{
    //put your code here

    
    
    public function consultarActividadesAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $idfilaResultado=$request->get('idfilaResultado');
            //obteniendo el objetivo para mandarlo a la plantilla  
       
        $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
        $objetivosEspec=$objetivoAux->getDescripcion();
        
        //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
          
          
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:manttActividades.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'idfilaResultado'=>$idfilaResultado,'descripcion'=>$objetivosEspec,'descripcionResultado'=>$resultadoesperado));
        
    }
    
    
    public function consultarActividadesJSONAction()
    {
        
        $request=$this->getRequest();        
        $idfilaResultado=$request->get('idfilaResultado');
        
        $ResultadoAux=new ResultadoEsperado();
        $objetivoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $ResultadoAux=$objetivoDao->getResulEspera($idfilaResultado);         
        
        $Actividades=$ResultadoAux->getActividades();
        
        $numfilas=count($Actividades);  
            
        $Actividad=new Actividad();
        $i=0;

        foreach ($Actividades as $Actividad) { 
            $rows[$i]['id']= $Actividad->getIdAct();
            $rows[$i]['cell']= array($Actividad->getIdAct(),
                                     $Actividad->getActDescripcion()
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
      
    public function ingresoActividadesAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $idfilaResultado=$request->get('idfilaResultado'); 
        
          
        //obteniendo el objetivo para mandarlo a la plantilla  
        $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
        $objetivosEspec=$objetivoAux->getDescripcion();
        
        //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
          
        
        
        
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:IngresoActividades.html.twig', 
                array( 'opciones' => $opciones,'idfilaResultado'=>$idfilaResultado,'idfila' => $idfila,'descripcion' => $objetivosEspec,'descripcionResultado'=>$resultadoesperado));
        
    }
    
      public function guardarActividadesAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');
          $idfilaResultado=$request->get('idfilaResultado');  //representa en este caso el codigo del resultado esperado 
          
          $actividad=$request->get('actividad');
          $indicador=$request->get('indicador');
          $medioverifindicador=$request->get('medioverifindicador');
          $responsable=$request->get('responsable');
          $supuestosfactores=$request->get('supuestosfactores');
          $metaAnual=$request->get('metaAnual');
          $tipometa=$request->get('selectipometa');
          $descripMetaAnual=$request->get('descripMetaAnual');
          
              
              //este  valor es  fusilados porque no se bien como  funcionan
          //asi que solo los asigno y lo mando
              $resEspNomencl="pruebanomenc";
             
                  //valores que representan lo programado         
               $trimUno=$request->get('trimUno');
               $trimDos=$request->get('trimDos');
               $trimTres=$request->get('trimTres');
               $trimCuatro=$request->get('trimCuatro');
           
                                             
               
            // $selectipometa=1;  
           
               $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
          $idActividad= $resultadoDao->agregarActividad($idfilaResultado,
                                       $tipometa,
                                        $actividad,
                                        $resEspNomencl,
                                        $supuestosfactores,
                                        $metaAnual,
                                        $descripMetaAnual,
                                        $responsable,
                                        $indicador,
                                        $medioverifindicador ); 
               
           
          
          //aqui tiene que ir el codigo para guardar lo programado el sidpla_resultadore
          
          
          
          
                  
           $objetivoAux=new ObjetivoEspecifico();
           $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
           $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
           $objetivosEspec=$objetivoAux->getDescripcion();
           
            //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
          
           return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:manttActividades.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'idfilaResultado'=>$idfilaResultado,'descripcion'=>$objetivosEspec,'descripcionResultado'=>$resultadoesperado));
        
    }
    
    
    
    public function editarActividadAction()
    {
          $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $idfilaResultado=$request->get('idfilaResultado'); 
          $idfilaActividad=$request->get('idfilaActividad');
         
        //obteniendo el objetivo para mandarlo a la plantilla  
        $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
        $objetivosEspec=$objetivoAux->getDescripcion();
        
        //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
          
          $actividadAux=new Actividad();
          $actividadDao = new ActividadDao($this->getDoctrine());                      
          $actividadAux=$actividadDao->getActividad($idfilaActividad);         
        
           $actividad=$actividadAux->getActDescripcion();
           $indicador=$actividadAux->getActIndicador();
           $medioverifi=$actividadAux->getIdTipoMedVeri();
           $responsable=$actividadAux->getActResponsable();
           $supuestos=$actividadAux->getSupuestosFactores();
           $metaanual=$actividadAux->getActMetaAnual();
           $descmetaanual=$actividadAux->getActDescMetaAnu();
           $tipometa=$actividadAux->getIdTipoMeta();
           //$fechainicio=$actividadAux->get;
           
        
        
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:EditarActividades.html.twig', 
                array( 'opciones' => $opciones,
                    'idfilaResultado'=>$idfilaResultado,
                    'idfila' => $idfila,
                    'descripcion' => $objetivosEspec,
                    'actividad'=>$actividad,
                    'indicador'=>$indicador,
                    'medioverifi'=>$medioverifi,
                    'responsable'=>$responsable,
                    'supuestos'=>$supuestos,
                    'metaanual'=>$metaanual,
                    'descmetaanual'=>$descmetaanual,
                    'tipometa'=>$tipometa,
                    'descripcionResultado'=>$resultadoesperado,
                    'idfilaActividad'=>$idfilaActividad
                    ));
        
    }
    
    public function editandoActividadesAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $idfilaResultado=$request->get('idfilaResultado');//representa en este caso el codigo de objetivo
         
          
          $id=$request->get('idfilaActividad');
          
          $actividad=$request->get('actividad');
          $indicador=$request->get('indicador');
          $medioverifindicador=$request->get('medioverifindicador');
          $responsable=$request->get('responsable');
          $supuestosfactores=$request->get('supuestosfactores');
          $metaAnual=$request->get('metaAnual');
          $tipometa=$request->get('selectipometa');
          $descripMetaAnual=$request->get('descripMetaAnual');
          
              
              //este  valor es  fusilados porque no se bien como  funcionan
          //asi que solo los asigno y lo mando
              $resEspNomencl="pruebanomenc";
             
                  //valores que representan lo programado         
               $trimUno=$request->get('trimUno');
               $trimDos=$request->get('trimDos');
               $trimTres=$request->get('trimTres');
               $trimCuatro=$request->get('trimCuatro');
           
                                             
               
            // $selectipometa=1;  
           
               $resultadoDao = new ActividadDao($this->getDoctrine());                      
          $idActividad= $resultadoDao->editActividad($idfilaResultado,
                                       $tipometa,
                                        $actividad,
                                        $resEspNomencl,
                                        $supuestosfactores,
                                        $metaAnual,
                                        $descripMetaAnual,
                                        $responsable,
                                        $indicador,
                                        $medioverifindicador,
                                        $id); 
                          
         
          $objetivoAux=new ObjetivoEspecifico();
           $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
           $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
           $objetivosEspec=$objetivoAux->getDescripcion();
           
        //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
          
       //obteniendo el resultado para mandarlo a la plantilla
        $resultadoAux=new ResultadoEsperado();
        $resultadoDao = new ResultadoEsperadoDao($this->getDoctrine());                      
        $resultadoAux=$resultadoDao->getResulEspera($idfilaResultado);         
        $resultadoesperado=$resultadoAux->getResEspeDesc();
                
           
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:manttActividades.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'idfilaResultado'=>$idfilaResultado,'descripcion'=>$objetivosEspec,'descripcionResultado'=>$resultadoesperado));
        
    }
    
}

?>
