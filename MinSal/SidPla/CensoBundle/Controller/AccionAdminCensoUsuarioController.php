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

    
    public function consultarInformacionComplementariaAction(){
        
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaCensoBundle:CensoUsuario:manttCensoUsuario.html.twig'
                , array('opciones' => $opciones,));              
    } 
    
    
     public function consultarInformacionComplementariaJSONAction(){
        
       
         $InfoCompleDao=new InformacionComplementariaDao($this->getDoctrine());        
        $InfoCompleDaoT=$InfoCompleDao->getInfoComple();  
         
        
        $numfilas=count($InfoCompleDaoT);  
            
            $uni=new InformacionComplementaria();
            $i=0;
            
            foreach ($InfoCompleDaoT as $uni) {
                $rows[$i]['id']= $uni->getIdInfoComp();
                $rows[$i]['cell']= array($uni->getIdInfoComp(),
                                         $uni->getAreaInfoComp(),
                                         $uni->getCodigoCensoPoblacion(),
                                         $uni->getCodigoCatCen(),
                                         $uni->getCantidadInfoComp());    
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
       
       $censoPoblacionDao=new CensoPoblacionDao($this->getDoctrine());
       $censoPoblacion=new CensoPoblacion();
       $censoPoblacion=$censoPoblacionDao->getCensoPoblacion('38');
       
       
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
        
       
         $InfoPobHumaDao=new PoblacionHumanaDao($this->getDoctrine());        
        $InfoPobHumDaoT=$InfoPobHumaDao->getInfoPobHum();  
         
        
        $numfilas=count($InfoPobHumDaoT);  
            
            $uni=new InformacionComplementaria();
            $i=0;
            
            foreach ($InfoPobHumDaoT as $uni) {
                $rows[$i]['id']= $uni->getIdPobHum();
                $rows[$i]['cell']= array($uni->getIdPobHum(),
                                         $uni->getCodCatCen(),
                                         $uni->getCodCenPob(),
                                         $uni->getPobHumClasi(),
                                         $uni->getPobHumArea(),
                                         $uni->getPobHumCant(),
                                         $uni->getPobhumSexo());    
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
        
       
         $InfoRelDao=new InformacionRelevanteDao($this->getDoctrine());        
        $InfoRelDaoT=$InfoRelDao->getInfoRel();  
         
        
        $numfilas=count($InfoRelDaoT);  
            
            $uni=new InformacionRelevante();
            $i=0;
            
            foreach ($InfoRelDaoT as $uni) {
                $rows[$i]['id']= $uni->getIdInfRel();
                $rows[$i]['cell']= array($uni->getIdInfRel(),
                                         $uni->getCodCenPob(),
                                         $uni->getCodCatCen(),
                                         $uni->getInfRelCant());    
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
    
    
}

?>
