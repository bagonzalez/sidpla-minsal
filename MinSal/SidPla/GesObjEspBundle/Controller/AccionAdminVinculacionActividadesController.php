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

 */

namespace MinSal\SidPla\GesObjEspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\PaoBundle\Entity\Pao;
use MinSal\SidPla\AdminBundle\EntityDao\UnidadOrganizativaDao;

/**
 * Description of AccionAdminVinculacionActividades
 *
 * @author bagonzalez
 */
class AccionAdminVinculacionActividadesController extends Controller {
    
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
    
    public function gestionVinculacionAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:gestionVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
    }
    
    public function agregarVinculacionAction()
    {
         $opciones=$this->getRequest()->getSession()->get('opciones');
         
         return $this->render('MinSalSidPlaGesObjEspBundle:GestionVincular:ingresarVinculacion.html.twig', 
                array( 'opciones' => $opciones,));
        
    }
    
     public function obtenerActividadesJSONAction()
    { 
            $request=$this->getRequest();
            
            $paoElaboracion=$this->obtenerPaoElaboracionAction();
            $programacionMonitoreo=$paoElaboracion->getProgramacionMonitoreo();
            
            
            
            
            
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
    
    
}

?>
