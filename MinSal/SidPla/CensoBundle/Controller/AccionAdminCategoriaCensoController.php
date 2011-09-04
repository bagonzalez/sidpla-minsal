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

use MinSal\SidPla\CensoBundle\EntityDao\CategoriaCensoDao;
use MinSal\SidPla\CensoBundle\Entity\CategoriaCenso;
use MinSal\SidPla\CensoBundle\Form\Type\CategoriaCesoType;


/**
 * Description of AccionAdminCategoriaCensoController
 *
 * @author Bruno González
 */
class AccionAdminCategoriaCensoController extends Controller {
    
     public function manttCatCensoAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');        
        return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:manttCategoriaCenso.html.twig', array('opciones' => $opciones));
    }
    
    
    public function ingresarCategoriaFormAction(){
        $opciones=$this->getRequest()->getSession()->get('opciones');
        $categoria=new CategoriaCenso();
        
        $form = $this->createForm(new CategoriaCesoType(), $categoria);
        return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:ingresoCategoriaCenso.html.twig', 
                array('form' => $form->createView(), 'opciones' => $opciones ));
    }


    public function consultarCategoriaCensoJSONAction(){
        
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
    
    public function addCategoriaAction(Request $peticion)
	{
            $opciones=$this->getRequest()->getSession()->get('opciones');
            $categoria=new CategoriaCenso();
            $form = $this->createForm(new CategoriaCesoType(), $categoria);
            
            if ($peticion->getMethod() == 'POST') {
                $form->bindRequest($peticion);

                if ($form->isValid()) {
                    $catCensoDao = new CategoriaCensoDao($this->getDoctrine());                
                    $mensajesSistema = $catCensoDao->addCategoria($categoria);	                     
                    return $this->render('MinSalSidPlaCensoBundle:CategoriaCenso:manttCategoriaCenso.html.twig', array('mensaje' => $mensajesSistema[0], 'opciones' => $opciones));                                     
                }
            }
            return $this->redirect($this->generateUrl('MinSalSidPlaCensoBundle_manttCatCenso'));	    
	}
    
}

?>
