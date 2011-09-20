<?php
namespace MinSal\SidPla\PaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//Para saber que unidad organizativa a la que pertenece y mostrar los periodos asociados
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
//use MinSal\SidPla\PaoBundle\EntityDao\PeriodoOficialDao;
//use MinSal\SidPla\PaoBundle\Entity\PeriodoOficial;


class AccionPaoPeriodoPaoController extends Controller{
    public function mantenimientoPeriodoPaoAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        //Obtener la unidad a la que pertence el usuario
        $usuario=new User();
        $empleado=new Empleado();
        
        $user = $this->get('security.context')->getToken()->getUser();
        $empleado=$user->getEmpleado();
        $idUnidad=$empleado->getUnidadOrganizativa()->getIdUnidadOrg();

        return $this->render('MinSalSidPlaPaoBundle:PeriodoPao:manttPeriodoPao.html.twig'
                        , array('opciones' => $opciones,'idUnidad'=>$idUnidad));
    }

}

?>
