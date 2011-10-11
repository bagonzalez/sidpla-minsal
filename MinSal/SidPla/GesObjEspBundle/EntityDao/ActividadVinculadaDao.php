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
namespace MinSal\SidPla\GesObjEspBundle\EntityDao;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\GesObjEspBundle\Entity\ActividadVinculada;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Description of ActividadVinculadaDao
 *
 * @author bagonzalez
 */
class ActividadVinculadaDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaGesObjEspBundle:ActividadVinculada');
    } 
    
    
    public function guardarActividadVinculada($idActividad, $idActividadAVincular){
        $actividadDao=new ActividadDao($this->doctrine);
        $actividadOrigen=$actividadDao->getActividad($idActividad);
        $actividadDestino=$actividadDao->getActividad($idActividadAVincular);
        
        $actividaVinculada=new ActividadVinculada();
        $actividaVinculada->setActOrigen($actividadOrigen);
        $actividaVinculada->setIdActOrigen($idActividad);
        
        $actividaVinculada->setActDest($actividadDestino);
        $actividaVinculada->setIdActDest($idActividadAVincular);
        $actividaVinculada->setEstado('unidad');
        
         $this->em->persist($actividaVinculada);
         $this->em->flush();
    }
    
    
    public function removeActividadVinculada($idActividadOriginal, $idActividadDest){
        $actividadDao=new ActividadDao($this->doctrine);
        
        $actividades=$this->getActividadesVinculadas($idActividadOriginal);
        
         $actividad=new ActividadVinculada();
            
        foreach ($actividades as $actividad) {
            if($actividad->getIdActDest()==$idActividadDest){
                    $this->em->remove($actividad); 
                    $this->em->flush();
            }
        }
        
        $this->em->flush();
    }
    
    
    public function getActividadesVinculadas($idActividad){
        
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSidPlaGesObjEspBundle:ActividadVinculada', 'a');
             $rsm->addFieldResult('a', 'actvin_codigo', 'idActVincu');
             $rsm->addFieldResult('a', 'actividad_actividaddestino', 'idActDest');
             $rsm->addFieldResult('a', 'actividad_actividadorigen', 'idActOrigen');
             $query = $this->em->createNativeQuery('SELECT 
                      sidpla_actividadvinculada.actvin_codigo,
                      sidpla_actividadvinculada.actividad_actividaddestino, 
                      sidpla_actividadvinculada.actividad_actividadorigen
                    FROM 
                      public.sidpla_actividadvinculada, 
                      public.sidpla_actividad
                    WHERE   
                      sidpla_actividadvinculada.actividad_actividadorigen = sidpla_actividad.actividad_codigo AND
                      actividad_actividadorigen=?' , $rsm);   
             $query->setParameter(1, $idActividad);
             $actividades = $query->getResult();             
             
             return $actividades;        
    }
}

?>
