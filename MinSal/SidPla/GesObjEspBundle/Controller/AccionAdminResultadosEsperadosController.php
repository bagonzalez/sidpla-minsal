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

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;

use MinSal\SidPla\GesObjEspBundle\Entity\ResultadoEsperado;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResultadoEsperadoDao;

use MinSal\SidPla\GesObjEspBundle\Entity\TipoMeta;
use MinSal\SidPla\GesObjEspBundle\EntityDao\TipoMetaDao;

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
    
    
    public function consultarResultadosEsperadosJSONAction()
    {
        
        $request=$this->getRequest();        
        $idobjetivo=$request->get('idfila');
        
        $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idobjetivo);         
        
        $objetivosEspec=$objetivoAux->getResultadoEsperado();
        
        $numfilas=count($objetivosEspec);  
            
        $objetivoEspec=new ResultadoEsperado();
        $i=0;

        foreach ($objetivosEspec as $objetivoEspec) { 
            $rows[$i]['id']= $objetivoEspec->getIdResEsp();
            $rows[$i]['cell']= array($objetivoEspec->getIdResEsp(),
                                     $objetivoEspec->getIdObjEsp(),
                                     $objetivoEspec->getIdResTempl(),
                                     $objetivoEspec->getIdTipoMeta(),
                                     $objetivoEspec->getResEspeDesc(),
                                     $objetivoEspec->getResEspNomencl(),
                                     $objetivoEspec->getResEspCondi(),
                                     $objetivoEspec->getResEspMetAnual(),
                                     $objetivoEspec->getResEspDescMetAnual(),
                                     $objetivoEspec->getResEspResponsable(),
                                     $objetivoEspec->getResEspEntidadControl(),
                                     $objetivoEspec->getResEspIndicador()
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
      
    
    public function manttResultadosEsperadosAction()
    {
        
        $request=$this->getRequest();            
         $id=$request->get('id');
         $idobjetivo=$request->get('idfila');//id objetivo
         $idResTempl=$request->get('idResTempl');
         $idTipoMeta=$request->get('idTipoMeta');
         $resEspeDesc=$request->get('resEspeDesc');
         $resEspNomencl=$request->get('resEspNomencl');
         $resEspCondi=$request->get('resEspCondi');
         $resEspMetAnual=$request->get('resEspMetAnual');
         $resEspDescMetAnual=$request->get('resEspDescMetAnual');
         $resEspResponsable=$request->get('resEspResponsable');
         $resEspEntidadControl=$request->get('resEspEntidadControl');
         $resEspIndicador=$request->get('resEspIndicador');
                                              
        
        $operacion=$request->get('oper'); 

        $objDao = new ResultadoEsperadoDao($this->getDoctrine()); 

        if($operacion=='edit'){   
            $objDao->editResulEsp($idResTempl,
                                        $idTipoMeta,
                                        $resEspeDesc,
                                        $resEspNomencl,
                                        $resEspCondi,
                                        $resEspMetAnual,
                                        $resEspDescMetAnual,
                                        $resEspResponsable,
                                        $resEspEntidadControl,
                                        $resEspIndicador,
                                        $idobjetivo,
                                        $id);            
        }

        if($operacion=='del'){
            $objDao->delObjEspec($id);
        }

        if($operacion=='add'){
            $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
            $objetivoDao->agregarResulEsperado($idResTempl,
                                        $idTipoMeta,
                                        $resEspeDesc,
                                        $resEspNomencl,
                                        $resEspCondi,
                                        $resEspMetAnual,
                                        $resEspDescMetAnual,
                                        $resEspResponsable,
                                        $resEspEntidadControl,
                                        $resEspIndicador,
                                        $idobjetivo);           
        }

        return new Response("{sc:true,msg:''}"); 
        
    }
    
    
    
    public function ingresoResultadosEsperadosAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          
        $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
        
        $objetivosEspec=$objetivoAux->getDescripcion();
          
          
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:IngresoResultadoEsperado.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'descripcion' => $objetivosEspec));
        
    }
    
    
    public function guardarResultadosEsperadosAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
         $idfila=$request->get('idfila');
          $idobjetivo=$request->get('idfila');  //representa en este caso el codigo de objetivo
          $resEspeDesc=$request->get('resultadoEsperado');
          $resEspIndicador=$request->get('Indicador');
          $medioverificacion=$request->get('medioverificacion');
         $resEspResponsable=$request->get('responsable');
         $resEspCondi=$request->get('supuestosfactores');
          $resEspMetAnual=$request->get('metaAnual');
          $tipometa=$request->get('selectipometa');
          $resEspDescMetAnual=$request->get('descripMetaAnual');
          
              
              //estos tres valores son fusilados porque no se bien como  funcionan
          //asi que solo los asigno y los mando
              $resEspNomencl="pruebanomenc";
               $restmpcodigo=1;
              $resEspEntidadControl=true;
              
              
              $trimUno=$request->get('trimUno');
               $trimDos=$request->get('trimDos');
               $trimTres=$request->get('trimTres');
               $trimCuatro=$request->get('trimCuatro');
           
                                             
               
            // $selectipometa=1;  
           
               $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
           $objetivoDao->agregarResulEsperado($restmpcodigo,
                                       $tipometa,
                                        $resEspeDesc,
                                        $resEspNomencl,
                                        $resEspCondi,
                                        $resEspMetAnual,
                                        $resEspDescMetAnual,
                                        $resEspResponsable,
                                        $resEspEntidadControl,
                                        $resEspIndicador,
                                        $idobjetivo); 
               
         
           //es en este punto dende tengo que obtener el id del nuevo resultado esperado
           //para poder ingresar los valores en la tablas sidpla_resultadore y sidpla_tipomedioverificacion
           //no hayo como obtener el valor de  'Resultado'.$objResulesperado->getIdResEsp() que viene
           // en el return $matrizmensaje  del metodo agregarResulEsperado del archivo ObjetivoEspecificoDao.php
            return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,));
        
    }
    
    
     public function consultarTipoMetaAction()
	{
            $opciones=$this->getRequest()->getSession()->get('opciones'); 
            
            $tipometaDao=new TipoMetaDao($this->getDoctrine());
            $tiposmeta=$tipometaDao->getTiposMeta();           
            
            $numfilas=count($tiposmeta);  
            
            $tipo=new TipoMeta();
            $i=0;
            
            foreach ($tiposmeta as $tipo) {
                $rows[$i]['id']= $tipo->getIdTipoMeta();
                $rows[$i]['cell']= array($tipo->getIdTipoMeta(),
                                         $tipo->getTipoMetaNombre());    
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

}?>
