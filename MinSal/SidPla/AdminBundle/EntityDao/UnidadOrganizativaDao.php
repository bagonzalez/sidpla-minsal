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

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;
use MinSal\SidPla\AdminBundle\EntityDao\MunicipioDao;
use MinSal\SidPla\PaoBundle\Entity\Pao;

/**
 * Description of UnidadOrganizativaDao
 *
 * @author bagonzalez
 */
class UnidadOrganizativaDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:UnidadOrganizativa');
    } 
    
    /*
     *  Obtiene todos las unidades organizativadel sistema.
     */    
    
    public function getUnidadesOrg() {	    
        $unidadesOrg=$this->repositorio->findAll();
        return $unidadesOrg;
    }
    
    /*
     * Insertar nueva unidad organizativa
     */
    
    public function ingresarUnidadOrg($nombreUnidad,
                                      $direccion,
                                      $responsable,
                                      $telefono,
                                      $fax,
                                      $tipoUnidad,
                                      $unidadPadre,
                                      $departameto,
                                      $municipio,
                                      $descripcion) {	    
        
        
         
        
        $municipioDao=new MunicipioDao($this->doctrine);
        $muncipioObj=$municipioDao->getMunicipio($municipio);
        
        
        $informacionGeneral=new InformacionGeneral();         
        $informacionGeneral->setDireccion($direccion);
        $informacionGeneral->setTelefono($telefono);
        $informacionGeneral->setFax($fax);
        
        
        $unidadOrg=new UnidadOrganizativa();
        $unidadOrg->setNombreUnidad($nombreUnidad);
        $unidadOrg->setTipoUnidad($tipoUnidad);
        
        if($unidadPadre!=0){
            $unidadParent=$this->repositorio->find($unidadPadre); 
            $unidadOrg->setParent($unidadParent);
        }        
        
        $unidadOrg->setIdMunicipio($municipio);        
        $unidadOrg->setInformacionGeneral($informacionGeneral);
        $unidadOrg->setDescripcionUnidad($descripcion);
        
        $informacionGeneral->setUnidadOrganizativa($unidadOrg);
        
        $this->em->persist($unidadOrg);	    
        $this->em->persist($informacionGeneral);        
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar Unidad Organizativa termino con exito', 'Unidad '.$unidadOrg->getIdUnidadOrg());
        
        return $matrizMensajes;

    }
    
    public function getUnidadOrg($id) {	    
        $unidadOrg=$this->repositorio->find($id);
        return $unidadOrg;
    }
    
    public function getPaoElaboracion($id) {	
        $unidadOrg=new UnidadOrganizativa();
        $unidadOrg=$this->repositorio->find($id);
        $paos=$unidadOrg->getPaos();        
        
        $anio = date('Y'); 
        $anioProximo=$anio+1;
        
        $pao=new Pao();
        
         foreach ($paos as $pao) {
             if($pao->getAnio()==$anioProximo){
                 return $pao;
             }             
         }
         
        return $pao;
    }
}

?>
