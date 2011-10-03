<?php

namespace MinSal\SidPla\PaoBundle\Controller; // siempre va solo cambiar el bundle al que pertenece la entidad

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; // estas tres lineas siempre van


use MinSal\SidPla\PaoBundle\EntityDao\JustificacionDao;
use MinSal\SidPla\PaoBundle\Entity\Justificacion;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

use \Java;
use \JavaClass;

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

         
    public function consultarJustificacionAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones'); //siempre va
        
        $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        $JustiDao=$paoElaboracion->getJustificacion(); //$JustificacioDao->buscarJustificacion($id); 
        
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
        
        
        /** 
         * convert a php value to a java one... 
         * @param string $value 
         * @param string $className 
         * @returns boolean success 
         */  
        function convertValue($value, $className)  
        {  
            // if we are a string, just use the normal conversion  
            // methods from the java extension...  
            try   
            {  
                if ($className == 'java.lang.String')  
                {  
                    $temp = new Java('java.lang.String', $value);  
                    return $temp;  
                }  
                else if ($className == 'java.lang.Boolean' ||  
                    $className == 'java.lang.Integer' ||  
                    $className == 'java.lang.Long' ||  
                    $className == 'java.lang.Short' ||  
                    $className == 'java.lang.Double' ||  
                    $className == 'java.math.BigDecimal')  
                {  
                    $temp = new Java($className, $value);  
                    return $temp;  
                }  
                else if ($className == 'java.sql.Timestamp' ||  
                    $className == 'java.sql.Time')  
                {  
                    $temp = new Java($className);  
                    $javaObject = $temp->valueOf($value);  
                    return $javaObject;  
                }  
            }  
            catch (Exception $err)  
            {  
                echo (  'unable to convert value, ' . $value .  
                        ' could not be converted to ' . $className);  
                return false;  
            }

            echo (  'unable to convert value, class name '.$className.  
                    ' not recognised');  
            return false;  
        }


        
        public function reporteJustificacionAction(){
            $opciones=$this->getRequest()->getSession()->get('opciones');
            $request=$this->getRequest();
            $JustiPao=$request->get('justificacion');            
            $id=$request->get('id');
            //$JustiDao=new JustificacionDao($this->getDoctrine());
            //$JustiDao-> actualizacionJustificacion($JustiPao, $id);
            
            try {

                 $compileManager = new JavaClass("net.sf.jasperreports.engine.JasperCompileManager");
            
                $report = $compileManager->compileReport(dirname(__FILE__)."/jasperReports/reporteJustificacion.jrxml");

                $fillManager = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

                $params = new Java("java.util.HashMap");
                $params->put("idJustificacion", $id);  

                //Java( 'java.lang.Class' )->forName('org.postgresql.Driver' );
                //$conn = Java( 'java.sql.DriverManager' )->getConnection("jdbc:postgresql://localhost:5432/sidpla", "sidpla", "sidplaDB");
                //$conn = Java( 'java.sql.DriverManager' )->getConnection("jdbc:postgresql://localhost:5432/sidpla?user=sidpla&password=sidplaDB");
                
               $memo=new Java('org.postgresql.Driver');
               $drm=new JavaClass("java.sql.DriverManager");
               $Conn = $drm->getConnection("jdbc:postgresql://localhost:5432/sidpla", "sidpla" , "sidplaDB");



            
                $emptyDataSource = new Java("net.sf.jasperreports.engine.JREmptyDataSource");
                $jasperPrint = $fillManager->fillReport($report, $params, $Conn);


                $outputPath = realpath(".")."/"."output.pdf";

                $exportManager = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
                $exportManager->exportReportToPdfFile($jasperPrint, $outputPath);
            
                header("Content-type: application/pdf");
                readfile($outputPath);
                
                $Conn->close();

                
           }
          catch( Exception $ex ) {                                                                                                                                                           
            if( $Conn != null ) {
              $Conn->close();
            }
              throw $ex;
          }
          
  
            //unlink($outputPath); 
            
            //echo java("java.lang.System")->getProperties(); 

            
            return $this->render('MinSalSidPlaAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
            //return $this->render('MinSalSidPlaPaoBundle:Justificacion:ManttJustificacion.html.twig' //aqui se define la carpeta en que se
             //   , array('opciones' => $opciones,));    
            
        }
      
        
        }
     ?>