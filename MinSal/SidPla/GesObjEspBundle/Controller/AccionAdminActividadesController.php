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
    
    
    public function editarActividadAction()
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
          
        
        
        
        
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:EditarActividades.html.twig', 
                array( 'opciones' => $opciones,'idfilaResultado'=>$idfilaResultado,'idfila' => $idfila,'descripcion' => $objetivosEspec,'descripcionResultado'=>$resultadoesperado));
        
    }
    
    
    
}

?>
