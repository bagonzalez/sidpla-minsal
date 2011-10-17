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


namespace MinSal\SidPla\GesObjEspEntControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use MinSal\SidPla\UnidadOrgBundle\Entity\ObjetivoEspecifico;
use MinSal\SidPla\UnidadOrgBundle\EntityDao\ObjetivoEspecificoDao;

/**
 * Description of AccionResultEspeEntControlController
 *
 * @author bagonzalez
 */
class AccionResultEspeEntControlController extends Controller  {
    
    public function consultarResultadosEsperadosAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');
        
          $request=$this->getRequest();        
          $idfila=$request->get('idfila');  
          $objetivoAux=new ObjetivoEspecifico();
        $objetivoDao = new ObjetivoEspecificoDao($this->getDoctrine());                      
        $objetivoAux=$objetivoDao->getObjetEspecif($idfila);         
        $objetivosEspec=$objetivoAux->getDescripcion();
          $objUniControl= true;
               
        return $this->render('MinSalSidPlaGesObjEspBundle:GestionResultadosEsperados:manttResultadosEsperados.html.twig', 
                array( 'opciones' => $opciones,'idfila' => $idfila,'descripcion' => $objetivosEspec, 'objUniControl' =>$objUniControl ));
        
    }
    
    
}

?>
