<?php

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;

/*
 *  OpcionSistemaDao: Parte de la capa de Acceso a Datos, para separar la logica de
 *  Acceso a Datos 
 */

class OpcionSistemaDao 
{
	var $em;
	
	function __construct($emController){ 
		$this->em=$emController;      	
   	} 
   	
   	/*
   	 *  Agrega una nueva OpcionSistema a la base de datos, recibe como parametros
   	 *  los datos para el nuevo registro. 
   	 *  
   	 *  Retorna mensajes del sistema que indican si es exito o fracaso.
   	 */	

	public function addOpcion($nombreOpcion, $descripcionOpcion) {
		
		$opc = new OpcionSistema();	    
	    $opc->setNombreOpcion($nombreOpcion);	   
	    $opc->setDescripcionOpcion($descripcionOpcion);
	    
	    
	    $this->em->persist($opc);
	    $this->em->flush();
	    
	    $matrizMensajes = array('El proceso de almacenar Opcion termino con exito', 'Opcion '.$opc->getIdOpcionSistema());
 
        return $matrizMensajes;
	}

}
