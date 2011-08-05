<?php

namespace MinSal\SidPla\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MinSal\SidPla\AdminBundle\EntityDao\OpcionSistemaDao;
use Symfony\Component\HttpFoundation\Response;


class AccionAdminOpcionesController extends Controller
{    
   
    /**
     *  Esta es la opcion del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase OpcionSistemaDao para
     *  manejar la persistencia de la entidad OpcionSistemaDao, y retornara los
     *  mensajes de exito/fracaso del sistema.
     */
	
	public function addOcpAction()
	{
		$opcDao = new OpcionSistemaDao($this->getDoctrine()->getEntityManager());	
		$mensajesSistema = $opcDao->addOpcion('opcionPrueba', 'descripcion');	 
	
	    return new Response($mensajesSistema[0].' '.$mensajesSistema[1] );
	}
}
