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

use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResulActividadDao;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

use MinSal\SidPla\PaoBundle\EntityDao\PeriodoPaoDao;


class AccionAdminActividadesController extends Controller{
    //put your code here

    public function obtenerPaoElaboracionAction(){
        
        $user=new User();
        $empleado=new Empleado();        
        $user = $this->get('security.context')->getToken()->getUser();        
        $empleado=$user->getEmpleado();        
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();        
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();              
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        $paoElaboracion=new Pao();        
        $paoElaboracion=$unidaDao->getPaoElaboracion($idUnidad);
        
        return $paoElaboracion;
        
    }
    
    
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
        
        $paoElaboracion=$this->obtenerPaoElaboracionAction();
        $idPao=$paoElaboracion->getIdPao();
        
        $periodoPaoDao=new PeriodoPaoDao($this->getDoctrine());
        
        $fechasMin=$periodoPaoDao->getMinFechaPao($idPao);        
        $fechasMax=$periodoPaoDao->getMaxFechaPao($idPao);
               
        
                
        $fechaInicioPeriodoPao=$fechasMin[0][1];
        $fechaFinPeriodoPao=$fechasMax[0][1];
        
        //$minDate = date( 'y-m-d', $fechaInicioPeriodoPao );
          
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionActividades:IngresoActividades.html.twig', 
                array( 'opciones' => $opciones,'idfilaResultado'=>$idfilaResultado,
                       'idfila' => $idfila,'descripcion' => $objetivosEspec,
                       'descripcionResultado'=>$resultadoesperado,
                        'fechaInicio'=>$fechaInicioPeriodoPao,
                        'fechaFin'=>$fechaFinPeriodoPao));
        
    }
    
      public function guardarActividadesAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');
          $idfilaResultado=$request->get('idfilaResultado');  //representa en este caso el codigo del resultado esperado 
         // $idfilaActividad=$request->get('idfilaActividad'); 
          
          $actividad=$request->get('actividad');
          $indicador=$request->get('indicador');
          $medioverifindicador=$request->get('medioverifindicador');
          $responsable=$request->get('responsable');
          $supuestosfactores=$request->get('supuestosfactores');
          $metaAnual=$request->get('metaAnual');
          $tipometa=$request->get('selectipometa');
          $descripMetaAnual=$request->get('descripMetaAnual');
          $costo=$request->get('costo');
          
              
              //este  valor es  fusilados porque no se bien como  funcionan
          //asi que solo los asigno y lo mando
              $resEspNomencl="pruebanomenc";
             
                  //valores que representan lo programado         
               $cantrimUno=$request->get('trimUno');
               $cantrimDos=$request->get('trimDos');
               $cantrimTres=$request->get('trimTres');
               $cantrimCuatro=$request->get('trimCuatro');
               $fechainicio=$request->get('fechainicio');
               $fechafin=$request->get('fechafin');  
               
               $fechaInicioPrimer = $request->get('datepickerInicioPrimer');
               $fechaFinPrimer = $request->get('datepickerFinPrimer');
               
               $fechaInicioSegundo = $request->get('datepickerInicioSegundo');
               $fechaFinSegundo = $request->get('datepickerFinSegundo');
               
               $fechaInicioTercero = $request->get('datepickerInicioTercer');
               $fechaFinTercero = $request->get('datepickerFinTercer');
               
               $fechaInicioCuarto = $request->get('datepickerInicioCuarto');
               $fechaFinCuarto = $request->get('datepickerFinCuarto');
               
               
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
                                        $medioverifindicador, $costo ); 
               
           
          
          //aqui tiene que ir el codigo para guardar lo programado el sidpla_resultadoactividad
          
          $trimesuno=1;
           $trimesdos=2;
           $trimestres=3;
           $trimescuatro=4;
           
           
            $paoElaboracion=$this->obtenerPaoElaboracionAction();
           $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
           
           //valor de cada segmento de actividad
           
           $porcRepresentaUno=$cantrimUno/$metaAnual;
           $porcRepresentaDos=$cantrimDos/$metaAnual;
           $porcRepresentaTres=$cantrimTres/$metaAnual;
           $porcRepresentaCuatro=$cantrimCuatro/$metaAnual;
           
           $costoProgramadoSegmentoUno=$porcRepresentaUno*$costo;
           $costoProgramadoSegmentoDos=$porcRepresentaDos*$costo;
           $costoProgramadoSegmentoTres=$porcRepresentaTres*$costo;
           $costoProgramadoSegmentoCuatro=$porcRepresentaCuatro*$costo;
           
          
          //inicia proceso de guardar el valor de lo programado en sidpla_resultadore
           $resultadoDao = new ActividadDao($this->getDoctrine());                      
           $resultadoDao->agregarResulActividad($idActividad,$trimesuno,$cantrimUno,$fechaInicioPrimer,$fechaFinPrimer, $programacionMonitoreo, $costoProgramadoSegmentoUno); 
           $resultadoDao->agregarResulActividad($idActividad,$trimesdos,$cantrimDos,$fechaInicioSegundo,$fechaFinSegundo, $programacionMonitoreo, $costoProgramadoSegmentoDos); 
           $resultadoDao->agregarResulActividad($idActividad,$trimestres,$cantrimTres,$fechaInicioTercero,$fechaFinTercero, $programacionMonitoreo, $costoProgramadoSegmentoTres); 
           $resultadoDao->agregarResulActividad($idActividad,$trimescuatro,$cantrimCuatro,$fechaInicioCuarto,$fechaFinCuarto, $programacionMonitoreo, $costoProgramadoSegmentoCuatro); 
       
                  
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
           
           
           
           //inicia el proceso  de recuperar los atos de la tabla resultadore
           $resultAux=new Actividad();
           $resultDao = new ActividadDao($this->getDoctrine());                      
           $resultAux=$resultDao->getActividad($idfilaActividad);         
           $resultaEspe=$resultAux->getResulAct();
           $numfilas=count($resultaEspe);  
           $resultadoreEspec=new ResulActividad();
           $i=0;
           $programadoPrimerTrimestre=0;
           $programadoSegundoTrimestre=0;
           $programadoTercerTrimestre=0;
           $programadoCuartoTrimestre=0;
           $iduno=0;
           $iddos=0;
           $idtres=0;
           $idcuatro=0;
           $fechainiciotrimuno=0;
           $fechainiciotrimdos=0;
           $fechainiciotrimtres=0;
           $fechainiciotrimcuatro=0;
           $fechafintrimuno=0;
           $fechafintrimdos=0;
           $fechafintrimtres=0;
           $fechafintrimcuatro=0;
           
           
        foreach ($resultaEspe as $resultadoreEspec) { 
            
            $trimestre=$resultadoreEspec->getResulActTrimestre();
            if($trimestre==1){
                $programadoPrimerTrimestre=$resultadoreEspec->getResulActProgramado();
                $fechainiciotrimuno=$resultadoreEspec->getResulActFechaInicio();
                $fechafintrimuno=$resultadoreEspec->getResulActFechaFin();
                                                
                $iduno=$resultadoreEspec->getIdResulAct();
                
            } 
            
             if($trimestre==2){
                $programadoSegundoTrimestre=$resultadoreEspec->getResulActProgramado();
                //$fechainiciotrimdos=$resultadoreEspec->getResulActFechaInicio();
                //$fechafintrimdos=$resultadoreEspec->getResulActFechaFin();
                $iddos=$resultadoreEspec->getIdResulAct();
            } 
            
             if($trimestre==3){
                $programadoTercerTrimestre=$resultadoreEspec->getResulActProgramado();
                // $fechainiciotrimtres=$resultadoreEspec->getResulActFechaInicio();
                // $fechafintrimtres=$resultadoreEspec->getResulActFechaFin();
                $idtres=$resultadoreEspec->getIdResulAct();
            } 
            
             if($trimestre==4){
                $programadoCuartoTrimestre=$resultadoreEspec->getResulActProgramado();
               // $fechainiciotrimcuatro=$resultadoreEspec->getResulActFechaInicio();
               // $fechafintrimcuatro=$resultadoreEspec->getResulActFechaFin();
                $idcuatro=$resultadoreEspec->getIdResulAct();
            } 
            
        }
           
           
           
        
        
               
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
                    ,'trim1' => $programadoPrimerTrimestre
                    ,'trim2' => $programadoSegundoTrimestre
                    ,'trim3' => $programadoTercerTrimestre
                    ,'trim4' => $programadoCuartoTrimestre
                    ,'iduno' => $iduno
                    ,'iddos' => $iddos
                    ,'idtres' => $idtres
                    ,'idcuatro' => $idcuatro
                    
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
           
               $iduno=$request->get('iduno');
               $iddos=$request->get('iddos');
               $idtres=$request->get('idtres');
               $idcuatro=$request->get('idcuatro');
               $fechainicio=$request->get('fechainicio');                              
               $fechafin=$request->get('fechafin');
            // $selectipometa=1;  
             
               $fechaInicioPrimer = $request->get('datepickerInicioPrimer');
               $fechaFinPrimer = $request->get('datepickerFinPrimer');
               
               $fechaInicioSegundo = $request->get('datepickerInicioSegundo');
               $fechaFinSegundo = $request->get('datepickerFinSegundo');
               
               $fechaInicioTercero = $request->get('datepickerInicioTercer');
               $fechaFinTercero = $request->get('datepickerFinTercer');
               
               $fechaInicioCuarto = $request->get('datepickerInicioCuarto');
               $fechaFinCuarto = $request->get('datepickerFinCuarto');
               
               
               
           
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
            
          
          
         //inicia proceso de guardar el valor de lo programado en sidpla_resultadore
           $resultadoDao = new ResulActividadDao($this->getDoctrine());                      
           $resultadoDao->editResulActividad($trimUno,$iduno, $fechaInicioPrimer,$fechaFinPrimer, $id);            
           $resultadoDao->editResulActividad($trimDos,$iddos,$fechaInicioSegundo, $fechaFinSegundo,$id);
           $resultadoDao->editResulActividad($trimTres,$idtres,$fechaInicioTercero, $fechaFinTercero, $id); 
           $resultadoDao->editResulActividad($trimCuatro, $idcuatro, $fechaInicioCuarto, $fechaFinCuarto, $id); 
          
         
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
    
}

?>
