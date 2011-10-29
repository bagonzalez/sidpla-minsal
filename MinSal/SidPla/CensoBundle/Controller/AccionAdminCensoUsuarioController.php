<?php

namespace MinSal\SidPla\CensoBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use MinSal\SidPla\CensoBundle\EntityDao\InformacionComplementariaDao;
use MinSal\SidPla\CensoBundle\Entity\InformacionComplementaria;
use MinSal\SidPla\CensoBundle\EntityDao\CategoriaCensoDao;
use MinSal\SidPla\CensoBundle\Entity\CategoriaCenso;
use MinSal\SidPla\CensoBundle\EntityDao\PoblacionHumanaDao;
use MinSal\SidPla\CensoBundle\Entity\PoblacionHumana;
use MinSal\SidPla\CensoBundle\EntityDao\InformacionRelevanteDao;
use MinSal\SidPla\CensoBundle\Entity\InformacionRelevante;


use MinSal\SidPla\CensoBundle\Form\Type\PoblacionHumanaType;
use MinSal\SidPla\CensoBundle\EntityDao\CensoPoblacionDao;
use MinSal\SidPla\CensoBundle\Entity\CensoPoblacion;

use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;

use MinSal\SidPla\CensoBundle\EntityDao\BloqueCensoDao;

use \PHPExcel_IOFactory; 
use \PHPExcel_Cell;

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
    
    public function consultarInformacionComplementariaAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
        $bloqueDao=new BloqueCensoDao($this->getDoctrine());
        $bloquesCensoPoblacion=$bloqueDao->getBloqueCen();
        
        $censoPoblacion=new CensoPoblacion();       
        $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
        
        
        return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
                , array('opciones' => $opciones, 'bloques' => $bloquesCensoPoblacion,
                        'censoPoblacion' => $censoPoblacion));              
    } 
    
    
     public function consultarInformacionComplementariaJSONAction(){
        
         
       $request=$this->getRequest();
       
       
       $rows='';       
       
       $censoPoblacion=new CensoPoblacion();
       
       $paoElaboracion=$this->obtenerPaoElaboracionAction();       
       $censoPoblacion=$paoElaboracion->getCesopoblacion();
       
       $infComplem=$censoPoblacion->getInformacionComplementaria();
        
        $numfilas=count($infComplem);  
        $regInfComple=new InformacionComplementaria();            
        $i=0;       
        foreach ($infComplem as $regInfComple) {
            $rows[$i]['id']= $regInfComple->getIdInfoComp();
            $rows[$i]['cell']= array($regInfComple->getCategoriaCenso()->getDescripcionCategoria(),                
                                     $regInfComple->getAreaInfoComp(),
                                     $regInfComple->getCantidadInfoComp()
                                     );    
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
    
    
   public function consultarDatosCategoriaJSONAction(){
       
       $request=$this->getRequest();
       $idCategoria=$request->get('idCategoria');
       
       $categoriaDao=new CategoriaCensoDao($this->getDoctrine());
       $categoriaCenso=new CategoriaCenso();
       $categoriaCenso=$categoriaDao->getCategoriaCenso($idCategoria);
       
       $descripCategoria=$categoriaCenso->getDescripcionCategoria();
       $tablaCenso=$categoriaCenso->getDivTabla();
       
       $rows='';
       
       $paoElaboracion=$this->obtenerPaoElaboracionAction();       
       $censoPoblacion=$paoElaboracion->getCesopoblacion();
       
       
       if($tablaCenso=='sidpla_poblacionhumana'){
           
            $poblacionHumana=$censoPoblacion->getPoblacionHumana();
            $regPobHumana=new PoblacionHumana();
            
            
            $i=0;
       
            foreach ($poblacionHumana as $regPobHumana) {
                    
                    if($regPobHumana->getCategoriaCenso()==$categoriaCenso){
                        $rows[$i]['id']= $regPobHumana->getIdPobHum();
                        $rows[$i]['cell']= array($regPobHumana->getIdPobHum(),
                                                 $regPobHumana->getPobHumArea(),                                                 
                                                 $regPobHumana->getPobhumsexo(),
                                                 $regPobHumana->getPobHumCant());    
                        $i++;
                    }
            }
       }
       
       
       if($tablaCenso=='sidpla_informacionrelevante'){
           
            $infRelevante=$censoPoblacion->getInformacionRelevante();
            $regInfRelevante=new InformacionRelevante();            
            $i=0;       
            foreach ($infRelevante as $regInfRelevante) {
                    
                    if($regInfRelevante->getCategoriaCenso()==$categoriaCenso){
                        $rows[$i]['id']= $regInfRelevante->getIdInfRel();
                        $rows[$i]['cell']= array($regInfRelevante->getIdInfRel(),
                                                 $regInfRelevante->getInfRelCant());    
                        $i++;
                    }
            }
       }
       
       
       if($tablaCenso=='sidpla_infcomplementaria'){
           
            $infComplem=$censoPoblacion->getInformacionComplementaria();
            $regInfComple=new InformacionComplementaria();            
            $i=0;       
            foreach ($infComplem as $regInfComple) {
                    
                    if($regInfComple->getCategoriaCenso()==$categoriaCenso){
                        $rows[$i]['id']= $regInfComple->getIdInfoComp();
                        $rows[$i]['cell']= array($regInfComple->getIdInfoComp(),
                                                 $regInfComple->getAreaInfoComp(),
                                                 $regInfComple->getCantidadInfoComp());    
                        $i++;
                    }
            }
       }
       
        $datos=json_encode($rows); 
       
        $jsonresponse='{
               "tabla":"'.$tablaCenso.'",
               "idCategoria":"'.$idCategoria.'",
               "registros":'.$datos.',                   
               "categoriaDescripcion":"'.$descripCategoria.'"}';
       
       
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
    
    public function consultarPoblacionHumanaJSONAction(){
        
       $request=$this->getRequest();       
      
       
       $rows='';
       
       $paoElaboracion=$this->obtenerPaoElaboracionAction();       
       $censoPoblacion=$paoElaboracion->getCesopoblacion();
           
        $poblacionHumana=$censoPoblacion->getPoblacionHumana();
        $regPobHumana=new PoblacionHumana();

        $i=0;
        $numfilas=count($poblacionHumana);         
        
       
            foreach ($poblacionHumana as $regPobHumana) {                    
                    
                $rows[$i]['id']= $regPobHumana->getIdPobHum();
                $rows[$i]['cell']= array($regPobHumana->getCategoriaCenso()->getDescripcionCategoria(),
                                         $regPobHumana->getPobHumArea(),                                                 
                                         $regPobHumana->getPobhumsexo(),
                                         $regPobHumana->getPobHumCant());    
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
    
     public function procesarPoblacionHumanaAction(){
         
        $opciones=$this->getRequest()->getSession()->get('opciones');
         
        $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
           
        $poblacionHumana=$censoPoblacion->getPoblacionHumana();
        $regPobHumana=new PoblacionHumana();

        $i=0;
        $numfilas=count($poblacionHumana);         
        
        /**	Load the quadratic equation solver worksheet into memory			**/
	$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');
        $objPHPExcel->setActiveSheetIndex(3);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        
        
        foreach ($poblacionHumana as $regPobHumana) { 
           $regPobHumana->getIdPobHum();
           $nombreCatego=$regPobHumana->getCategoriaCenso()->getDescripcionCategoria();
            
           $col = 0;
           
           /*for ($row = 1; $row <= $highestRow; ++$row) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
               if($nombreCatego==$nombreMax){
                   $fila=$row;                   
               }
           }*/
           $row=1;
           $fila=0;
           
           while ($row <= $highestRow && $fila==0 ) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
               
               if($nombreCatego==$nombreMax){
                   $fila=$row;                   
               }
               
               ++$row;
           }
           
           $area=$regPobHumana->getPobHumArea();
           $sexo=$regPobHumana->getPobhumsexo();
           $resultado=$regPobHumana->getPobHumCant();
           
           
           if($area=='URBANA'){               
               if($sexo=='H'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $resultado);
               }
               
               if($sexo=='M'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $resultado);
               }
           }
           
           if($area=='RURAL'){               
               if($sexo=='H'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $resultado);
               }
               
               if($sexo=='M'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $resultado);
               }
           }
           
           if($area=='PROMOTOR'){               
               if($sexo=='H'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $resultado);
               }
               
               if($sexo=='M'){
                   if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $fila, $resultado);
               }
           }

        }
        
                
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');

		
        //$callStartTime = microtime(true);

        //echo $objPHPExcel->getActiveSheet()->getCell('B5')->getCalculatedValue().'<br />';
        //echo $objPHPExcel->getActiveSheet()->getCell('B6')->getCalculatedValue().'<br />';
        //$callEndTime = microtime(true);
        //$callTime = $callEndTime - $callStartTime;
         
        return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
        , array('opciones' => $opciones,));      
     }
     
      public function procesarInfRelevanteAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones');         
        $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
        
        $infRelevante=$censoPoblacion->getInformacionRelevante();
        $regInfRel=new InformacionRelevante();
        
        /**	Load the quadratic equation solver worksheet into memory			**/
	$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');
        $objPHPExcel->setActiveSheetIndex(3);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $fila=0;
        
        
        foreach ($infRelevante as $regInfRel) {
            $nombreCatego=$regInfRel->getCategoriaCenso()->getDescripcionCategoria();
            
             $col = 0;
             $row=1;
             $fila=0;
            
            while ($row <= $highestRow && $fila==0 ) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
               
               if($nombreCatego==$nombreMax){
                   $fila=$row;                   
               }
               
               ++$row;
           }
           
           $resultado=$regInfRel->getInfRelCant();
           if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $resultado);

        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');
         return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
        , array('opciones' => $opciones,));    
  }
  
   public function procesarInfComplementariaAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones');         
        $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
        
        $infComplementaria=$censoPoblacion->getInformacionComplementaria();
        $regInfComple=new InformacionComplementaria();
        
        /**	Load the quadratic equation solver worksheet into memory			**/
	$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');
        $objPHPExcel->setActiveSheetIndex(3);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $fila=0;
        
        
        foreach ($infComplementaria as $regInfComple) {
            $nombreCatego=$regInfComple->getCategoriaCenso()->getDescripcionCategoria();
            
             $col = 0;
             $row=1;
             $fila=0;
            
            while ($row <= $highestRow && $fila==0 ) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;
               
               if($nombreCatego==$nombreMax){
                   $fila=$row;                   
               }
               
               ++$row;
           }
           
           $resultado=$regInfComple->getCantidadInfoComp();
           $area=$regInfComple->getAreaInfoComp();
           
            if($area=='URBANA'){               
                if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $resultado);
               
           }
           
           if($area=='RURAL'){                              
                if($resultado>0)
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $resultado);               
           }

        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/PAO2011_N1Especializado.final2.xls');
         return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
        , array('opciones' => $opciones,));    
  }
    
    
   public function manttPoblacionHumanaEdicionAction(){
            
            $request=$this->getRequest();
            $codCenPob=$request->get('codCensoPob');
            $codCatCen=$request->get('codCatCen');            
            $pobHumClasi=$request->get('pobHumClasi');  
            $pobHumArea=$request->get('pobHumArea');  
            $pobHumCant=$request->get('pobHumCant');
            $pobhumSexo=$request->get('pobhumSexo');            
              
            
            $id=$request->get('id');
            
            $operacion=$request->get('oper'); 
            
            $InfPobHumaDao=new PoblacionHumanaDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $InfPobHumaDao->editPobHuma($codCenPob, $codCatCen,$pobHumClasi,$pobHumArea,$pobHumCant,$pobhumSexo, $id);
            }
            
            if($operacion=='del'){
                $InfPobHumaDao->delPobHuma($id);        
            }
            
            if($operacion=='add'){
                $InfPobHumaDao->addInfoPobHuma($codCenPob, $codCatCen,$pobHumClasi,$pobHumArea,$pobHumCant,$pobhumSexo);
            }
             
            return new Response("{sc:true,msg:''}"); 
            
        }
    
    
    
    
     public function consultarCategoriaCensoUsuarioJSONAction(){
        
            $request=$this->getRequest();
            $categoriaDao=new CategoriaCensoDao($this->getDoctrine());
            $categorias=$categoriaDao->getCategorias();
            
            $numfilas=count($categorias);  
            
            
            $i=0;
            
            $categoria=new CategoriaCenso();
            
            foreach ($categorias as $categoria) {
                
                $rows[$i]['id']= $categoria->getIdCategoriaCenso();
                $rows[$i]['cell']= array($categoria->getIdCategoriaCenso(),
                                         $categoria->getDescripcionCategoria(),
                                         $categoria->getActivo(),
                                         $categoria->getDivTabla() ,
                                         $categoria->getBloque()->getNombreBloque()
                                         );    
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
    
    
    public function consultarInformacionRelevanteJSONAction(){
        
       $request=$this->getRequest();       
       $rows='';
       
       $page = $request->get('page'); // get the requested page 
       $limit = $request->get('rows'); // get how many rows we want to have into the grid 
       $sidx = $request->get('sidx'); // get index row - i.e. user click to sort 
       $sord = $request->get('sord'); // get the direction
       if(!$sidx) $sidx =1;
       
       $paoElaboracion=$this->obtenerPaoElaboracionAction();       
       $censoPoblacion=$paoElaboracion->getCesopoblacion();
          
       
           
        $infRelevante=$censoPoblacion->getInformacionRelevante();
        $regInfRelevante=new InformacionRelevante();            
        $i=0;   
        $numfilas=count($infRelevante);
        
        if( $numfilas >0 ) { 
            $total_pages = ceil($numfilas/$limit);             
        } else { 
            $total_pages = 0;             
        }
        if ($page > $total_pages) $page=$total_pages;
        
        foreach ($infRelevante as $regInfRelevante) {
                    $rows[$i]['id']= $regInfRelevante->getIdInfRel();
                    $rows[$i]['cell']= array($regInfRelevante->getCategoriaCenso()->getDescripcionCategoria(),
                                             $regInfRelevante->getInfRelCant());    
                    $i++;                    
        }
        
        $datos=json_encode($rows);            
            
            
            $jsonresponse='{
               "page":"'.$page.'",
               "total":"'.$total_pages.'",
               "records":"'.$numfilas.'", 
               "rows":'.$datos.'}';
            
            
            $response=new Response($jsonresponse);              
            return $response;            
        
    }
    
    public function ingresarPoblacionHumanaAction(){
        $request=$this->getRequest();
        
        $idRuralHombres=$request->get('idAreaRuralH');
        $idRuralMujeres=$request->get('idAreaRuralM');
        
        $idUrbanaHombres=$request->get('idAreaUrbanaH');
        $idUrbanaMujeres=$request->get('idAreaUrbanaM');        
        
        $idPromotorHombres=$request->get('idAreaPromotorH');
        $idPromotorMujeres=$request->get('idAreaPromotorM');
        
        
        
            
            $cantUrbanaHombres=$request->get('urbanaHombres');
            $cantUrbanaMujeres=$request->get('urbanaMujeres');
            
            $cantRuralHombres=$request->get('ruralHombres');
            $cantRuralMujeres=$request->get('ruralMujeres');
            
            $cantPromotorHombres=$request->get('promotorMaculino');
            $cantPromotorMujeres=$request->get('promotorFemenino');
            
            $poblacionUrbanaDao=new PoblacionHumanaDao($this->getDoctrine());            
            
            
            $poblacionUrbanaHombres= $poblacionUrbanaDao->getPoblacionHumana($idUrbanaHombres);
            $poblacionUrbanaMujeres= $poblacionUrbanaDao->getPoblacionHumana($idUrbanaMujeres);
            $poblacionRuralHombres= $poblacionUrbanaDao->getPoblacionHumana($idRuralHombres);
            $poblacionRuralMujeres= $poblacionUrbanaDao->getPoblacionHumana($idRuralMujeres);
            $poblacionPromotorHombres= $poblacionUrbanaDao->getPoblacionHumana($idPromotorHombres);            
            $poblacionPromotorMujeres= $poblacionUrbanaDao->getPoblacionHumana($idPromotorMujeres);
            
            $poblacionUrbanaHombres->setPobHumCant($cantUrbanaHombres);
            $poblacionUrbanaMujeres->setPobHumCant($cantUrbanaMujeres);
            
            $poblacionRuralHombres->setPobHumCant($cantRuralHombres);
            $poblacionRuralMujeres->setPobHumCant($cantRuralMujeres);
            
            $poblacionPromotorHombres->setPobHumCant($cantPromotorHombres);
            $poblacionPromotorMujeres->setPobHumCant($cantPromotorMujeres);
            
            $this->getDoctrine()->getEntityManager()->persist($poblacionUrbanaHombres);
            $this->getDoctrine()->getEntityManager()->persist($poblacionUrbanaMujeres);
            
            $this->getDoctrine()->getEntityManager()->persist($poblacionRuralHombres);
            $this->getDoctrine()->getEntityManager()->persist($poblacionRuralMujeres);
            
            $this->getDoctrine()->getEntityManager()->persist($poblacionPromotorHombres);
            $this->getDoctrine()->getEntityManager()->persist($poblacionPromotorMujeres);
            
            $this->getDoctrine()->getEntityManager()->flush();
            
            
            
        
     return $this->consultarInformacionComplementariaAction();  
        
        
    }  
    
    
    public function ingresarInfRelevaAction(){
        
        $request=$this->getRequest();
        
        $idInfRelevante=$request->get('idInfRelevante');
        
            
            $cantInfRelv=$request->get('cantRelevante');
            
            $infRelevanteDao=new InformacionRelevanteDao($this->getDoctrine());            
            
            
            $infRelevanteReg= $infRelevanteDao->getInfRelevante($idInfRelevante);
            $infRelevanteReg->setInfRelCant($cantInfRelv);
            
            $this->getDoctrine()->getEntityManager()->persist($infRelevanteReg);
           
            $this->getDoctrine()->getEntityManager()->flush();
            
            
            
        
     return $this->consultarInformacionComplementariaAction();  
        
        
    }  
    
     public function ingresarInfComplementariaAction(){
        
        $request=$this->getRequest();
        
        $idAreaUrbana=$request->get('idAreaUrbana');
        $idAreaRural=$request->get('idAreaRural');
        $idAreaPromotor=$request->get('idAreaPromotor');
        
            
        $cantUrbana=$request->get('_urbanaComple');
        $cantRural=$request->get('_ruralComple');
            
        $infComplementaDao=new InformacionComplementariaDao($this->getDoctrine()); 
        
                
        $regInfComple=$infComplementaDao->getInfoComplementaria($idAreaUrbana);
        $regInfComple->setCantidadInfoComp($cantUrbana);
        
        $this->getDoctrine()->getEntityManager()->persist($regInfComple);
        $this->getDoctrine()->getEntityManager()->flush(); 
        
        $regInfComple=$infComplementaDao->getInfoComplementaria($idAreaRural);
        $regInfComple->setCantidadInfoComp($cantRural);      
        
        $this->getDoctrine()->getEntityManager()->persist($regInfComple);
        $this->getDoctrine()->getEntityManager()->flush();
                                 
        return $this->consultarInformacionComplementariaAction();                  
    }     
    
}

?>
