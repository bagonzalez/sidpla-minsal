<?php



/*
  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * 
 */

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

use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;

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
    
    public function obtenerPaoSeguimientoUnidadAction($idUnidad){        
               
        $unidaDao=new UnidadOrganizativaDao($this->getDoctrine());
        $unidad=new UnidadOrganizativa();              
        $unidad=$unidaDao->getUnidadOrg($idUnidad);
        
        $paoElaboracion=new Pao();        
        $paoElaboracion=$unidaDao->getPaoSeguimiento($idUnidad);
        
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
    
     public function procesarPoblacionHumanaAction($objPHPExcel, $idUnidad = 0){
         
        if($idUnidad!=0)
            $paoElaboracion=$this->obtenerPaoSeguimientoUnidadAction ($idUnidad);
        else
            $paoElaboracion=$this->obtenerPaoElaboracionAction();       
        
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
           
        $poblacionHumana=$censoPoblacion->getPoblacionHumana();
        $regPobHumana=new PoblacionHumana();

        $i=0;
        $numfilas=count($poblacionHumana);         
        
        
	//$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = 160;//$objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $poblacionHumanaDao=new PoblacionHumanaDao($this->getDoctrine());
        
         $col = 0;
           
           
        $row=1;
        $fila=0;
           
        $categoriasXLS=array();
        $nombreUnidad=$paoElaboracion->getUnidadOrganizativa()->getNombreUnidad();
        $responsable=$paoElaboracion->getUnidadOrganizativa()->getResponsable();
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $nombreUnidad );
        
        $responsableDao = new EmpleadoDao($this->getDoctrine());
        $empleado = new Empleado();
        $empleado = $responsableDao->getEmpleado($responsable);

           if( $empleado!=NULL){
               $nombreempleado=$empleado->getPrimerNombre();
               $segundonombre=$empleado->getSegundoNombre();
               $apellidoempleado=$empleado->getPrimerApellido();
               $segundoapellido=$empleado->getSegundoApellido();
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, $nombreempleado." ".$segundonombre." ".$apellidoempleado." ".$segundoapellido );
           }
        
        
        while ($row <= $highestRow) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;               
               if($nombreMax)
                $categoriasXLS[$nombreMax]=$row;               
               ++$row;
        }
        
        foreach ($poblacionHumana as $regPobHumana) { 
           $regPobHumana->getIdPobHum();
           $nombreCatego=$regPobHumana->getCategoriaCenso()->getDescripcionCategoria();
          
            $fila=$categoriasXLS[$nombreCatego];
            
            if($fila>0){
                
                  $area=$regPobHumana->getPobHumArea();
                   $sexo=$regPobHumana->getPobhumsexo();
                   $resultado=$regPobHumana->getPobHumCant();
                    if(!($resultado>0))
                        $resultado=0;
                        

                   if($regPobHumana->getCategoriaCenso()->getEsCalculada()){

                               if($area=='URBANA'){               
                                   if($sexo=='H'){ 
                                        $valor=$objPHPExcel->getActiveSheet()->getCell("D".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }

                                   if($sexo=='M'){                           
                                        $valor=$objPHPExcel->getActiveSheet()->getCell("F".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }
                               }

                               if($area=='RURAL'){               
                                   if($sexo=='H'){                           
                                        $valor=$objPHPExcel->getActiveSheet()->getCell("J".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }

                                   if($sexo=='M'){                           
                                        $valor=$objPHPExcel->getActiveSheet()->getCell("L".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }
                               }

                               if($area=='PROMOTOR'){               
                                   if($sexo=='H'){                           
                                        $valor=$objPHPExcel->getActiveSheet()->getCell("X".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }

                                   if($sexo=='M'){
                                       $valor=$objPHPExcel->getActiveSheet()->getCell("Z".$fila)->getCalculatedValue();   
                                        $regPobHumana->setPobHumCant($valor);
                                        $poblacionHumanaDao->guardarPoblacionHumana($regPobHumana);
                                   }
                               }

                       }else{
                           if($area=='URBANA'){               
                               if($sexo=='H'){                                   
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $resultado);                                  
                               }

                               if($sexo=='M'){                                   
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $fila, $resultado);
                                   
                               }
                           }

                           if($area=='RURAL'){               
                               if($sexo=='H'){                               
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $resultado);
                               }

                               if($sexo=='M'){                                   
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $fila, $resultado);
                               }
                           }

                           if($area=='PROMOTOR'){               
                               if($sexo=='H'){                                   
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $fila, $resultado);
                               }

                               if($sexo=='M'){                                   
                                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, $fila, $resultado);
                               }
                           }

               }
                
                
            }

        }
        
                
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
        
        return $objPHPExcel;
        
     }
     
      public function procesarInfRelevanteAction($objPHPExcel, $idUnidad = 0){
        
        if($idUnidad!=0)
            $paoElaboracion=$this->obtenerPaoSeguimientoUnidadAction ($idUnidad);
        else
            $paoElaboracion=$this->obtenerPaoElaboracionAction(); 
        
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
        
        $infRelevante=$censoPoblacion->getInformacionRelevante();
        $regInfRel=new InformacionRelevante();
        
        
	//$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = 160;//$objWorksheet->getHighestRow(); 
        $highestColumn = $objWorksheet->getHighestColumn();

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $categoriasXLS=array();
        
        $fila=0;
        $col = 0;
        $row=1;
        
        while ($row <= $highestRow) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;               
               if($nombreMax)
                $categoriasXLS[$nombreMax]=$row;               
               ++$row;
        }
             
        
        foreach ($infRelevante as $regInfRel) {
            $nombreCatego=$regInfRel->getCategoriaCenso()->getDescripcionCategoria();
            
            $fila=$categoriasXLS[$nombreCatego];
            
            if($fila>0){
               $resultado=$regInfRel->getInfRelCant();
               if(!($resultado>0))
                   $resultado=0;
                   
                   
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $fila, $resultado);
                
            }
        }
        
        return $objPHPExcel;
        
       
  }
  
   public function procesarInfComplementariaAction($objPHPExcel, $idUnidad = 0){
        
        if($idUnidad!=0)
            $paoElaboracion=$this->obtenerPaoSeguimientoUnidadAction ($idUnidad);
        else
            $paoElaboracion=$this->obtenerPaoElaboracionAction(); 
        
        $censoPoblacion=$paoElaboracion->getCesopoblacion();
        
        $infComplementaria=$censoPoblacion->getInformacionComplementaria();
        $regInfComple=new InformacionComplementaria();
        
        
	//$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $highestRow = 160;//$objWorksheet->getHighestRow(); 
        $highestColumn = $objWorksheet->getHighestColumn(); 

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        $categoriasXLS=array();
        
        $fila=0;
        $col = 0;
        $row=1;
        
        while ($row <= $highestRow) {             
               $nombreMax=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue() ;               
               if($nombreMax)
                    $categoriasXLS[$nombreMax]=$row;               
               ++$row;
        }
             
        
        $infComDao=new InformacionComplementariaDAO($this->getDoctrine());
        
        foreach ($infComplementaria as $regInfComple) {
            $nombreCatego=$regInfComple->getCategoriaCenso()->getDescripcionCategoria();
            
             $fila=$categoriasXLS[$nombreCatego];
            
            if($fila>0){
                $area=$regInfComple->getAreaInfoComp();
                $resultado=0;

                if($regInfComple->getCategoriaCenso()->getEsCalculada()){

                    if($area=='URBANA'){                                   
                            $valor=$objPHPExcel->getActiveSheet()->getCell("D".$fila)->getCalculatedValue();   
                            if($valor>0){
                                $regInfComple->setCantidadInfoComp($valor);
                                $infComDao->guardarInfComple($regInfComple);                                                
                            }
                   }

                   if($area=='RURAL'){                                                  
                            $valor=$objPHPExcel->getActiveSheet()->getCell("J".$fila)->getCalculatedValue();                        
                             if($valor>0){
                                $regInfComple->setCantidadInfoComp($valor);
                                $infComDao->guardarInfComple($regInfComple);
                             }

                   }

                    if($area=='PROMOTOR'){                                                  
                            $valor=$objPHPExcel->getActiveSheet()->getCell("X".$fila)->getCalculatedValue();                        
                             if($valor>0){
                                $regInfComple->setCantidadInfoComp($valor);
                                $infComDao->guardarInfComple($regInfComple);
                             }
                   }


                }else{
                   $resultado=$regInfComple->getCantidadInfoComp();              
                    if(!($resultado>0))
                        $resultado=0;
                    
                    if($area=='URBANA'){               
                        
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $fila, $resultado);

                   }

                   if($area=='RURAL'){                                                      
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $fila, $resultado);               
                   }
                   
                    if($area=='PROMOTOR'){                                                      
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, $fila, $resultado);               
                   }

                }
                
            }

        }
        
        //return $this->consultarInformacionComplementariaAction();      
        
        return $objPHPExcel;
        
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
       
       $page = $request->get('page'); 
       $limit = $request->get('rows'); 
       $sidx = $request->get('sidx'); 
       $sord = $request->get('sord'); 
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
            $poblacionUrbanaHombres->setPobHumArea('URBANA');
            $poblacionUrbanaHombres->setPobhumsexo('H');
            
            $poblacionUrbanaMujeres->setPobHumCant($cantUrbanaMujeres);
            $poblacionUrbanaMujeres->setPobHumArea('URBANA');
            $poblacionUrbanaMujeres->setPobhumsexo('M');
            
            $poblacionRuralHombres->setPobHumCant($cantRuralHombres);
            $poblacionRuralHombres->setPobHumArea('RURAL');
            $poblacionRuralHombres->setPobhumsexo('H');
            
            $poblacionRuralMujeres->setPobHumCant($cantRuralMujeres);
            $poblacionRuralMujeres->setPobHumArea('RURAL');
            $poblacionRuralMujeres->setPobhumsexo('M');
            
            
            $poblacionPromotorHombres->setPobHumCant($cantPromotorHombres);
            $poblacionPromotorHombres->setPobHumArea('PROMOTOR');
            $poblacionPromotorHombres->setPobhumsexo('H');
            
            $poblacionPromotorMujeres->setPobHumCant($cantPromotorMujeres);
            $poblacionPromotorMujeres->setPobHumArea('PROMOTOR');
            $poblacionPromotorMujeres->setPobhumsexo('M');
            
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
        $cantPromotor=$request->get('_promotorComple');
            
        $infComplementaDao=new InformacionComplementariaDao($this->getDoctrine()); 
        
                
        $regInfComple=$infComplementaDao->getInfoComplementaria($idAreaUrbana);
        $regInfComple->setCantidadInfoComp($cantUrbana);
        
        $this->getDoctrine()->getEntityManager()->persist($regInfComple);
        $this->getDoctrine()->getEntityManager()->flush(); 
        
        $regInfComple=$infComplementaDao->getInfoComplementaria($idAreaRural);
        $regInfComple->setCantidadInfoComp($cantRural);  
        
        $this->getDoctrine()->getEntityManager()->persist($regInfComple);
        $this->getDoctrine()->getEntityManager()->flush();
        
        $regInfComple=$infComplementaDao->getInfoComplementaria($idAreaPromotor);
        $regInfComple->setCantidadInfoComp($cantPromotor);  
        
        $this->getDoctrine()->getEntityManager()->persist($regInfComple);
        $this->getDoctrine()->getEntityManager()->flush();
                                 
        return $this->consultarInformacionComplementariaAction();                  
    }  
    
    
    
    public function generarCensoUsuarioAction(){
        
       $objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
       
       $objPHPExcel=$this->procesarPoblacionHumanaAction($objPHPExcel);
       $objPHPExcel=$this->procesarInfRelevanteAction($objPHPExcel);
       $objPHPExcel=$this->procesarInfComplementariaAction($objPHPExcel);       

       
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="censopoblacion.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
                                 
        return $this->consultarInformacionComplementariaAction();                  
    }  
    
      public function generarCensoUsuarioDirPlaAction(){
          
       $opciones = $this->getRequest()->getSession()->get('opciones');
          
       $request = $this->getRequest();
       $unidad = (int) $request->get('idUniSal');
        
       $objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).'/PAO_CENSOPOBLACION.xls');
       
       $objPHPExcel=$this->procesarPoblacionHumanaAction($objPHPExcel, $unidad );
       $objPHPExcel=$this->procesarInfRelevanteAction($objPHPExcel, $unidad);
       $objPHPExcel=$this->procesarInfComplementariaAction($objPHPExcel, $unidad);       

       
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="censopoblacion.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
                                 
        return $this->render('MinSalSidPlaReportesBundle:Consolidados:reportesUniSal.html.twig', array('opciones' => $opciones));                 
    }  
    
}

?>
