<?php
namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use MinSal\SidPla\AdminBundle\EntityDao\JustificacionDao;
use MinSal\SidPla\AdminBundle\Entity\Justificacion;
use MinSal\SidPla\AdminBundle\Entity\Pao;

class AccionJustificacionController extends Controller {
    
         /*
         * Gestionar justificacion de PAO
         * 
         */
        
        public function mattJustificacion()
	{
            $opciones=$this->getRequest()->getSession()->get('opciones');             
            
            
            return $this->render('MinSalSidPlaPaoBundle:Justificacion:manttJustificacion.html.twig', 
                    array('opciones' => $opciones,));
            
	}
       
        
    public function consultarJustificacionJSONAction() {

        $JustificacionDao = new JustificacionSistemaDao($this->getDoctrine());
        $JustificacionDao = $JustificacionDao->getjustificacionSistema();

        $numfilas = count($justificacion);

        $aux = new JustificacionSistema();
        $i = 0;

        foreach ($justificacion as $aux) {
            $rows[$i]['id'] = $aux->getCodNoti();
            $rows[$i]['cell'] = array($aux->getCodNoti(),
                $aux->getJustificacion_descripcion(),
                $aux->getPao_codigo(),
                $aux->getIdJudtificacion()
            );
            $i++;
        }

        $datos = json_encode($rows);


        $jsonresponse = '{
               "page":"1",
               "total":"1",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }       
    
 /* Mantenimimento de justificacion de PAO
  * Eliminar, agregar, editar
  */
        
        public function manttJustificacionEdicionAction(){
            
            $request=$this->getRequest();           
            
            
            $justificacion_descripcion=$request->get('justificacion_descripcion');
            $pao_codigo=$request->get('pao_codigo');
           
            $id=$request->get('id');            
            $operacion=$request->get('oper'); 
            
            $JusticacionDao=new JustificacionDao($this->getDoctrine());
            
            if($operacion=='edit'){                
                $JusticacionDao->editJustificacion($justificacion_descripcion, $pao_codigo);
            }
            
            if($operacion=='del'){
                $JusticacionDao->delJustificacion($id);        
            }
            
            if($operacion=='add'){
                $JusticacionDao->addJustificacion($justificacion_descripcion, $pao_codigo);
            }
             
            return new Response("{sc:true,msg:''}"); 
        }        
}
?>
