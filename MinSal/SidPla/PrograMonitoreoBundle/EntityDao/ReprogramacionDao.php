<?php

namespace MinSal\SidPla\PrograMonitoreoBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\Reprogramacion;
use MinSal\SidPla\GesObjEspBundle\Entity\ResulActividad;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ResulActividadDao;
use MinSal\SidPla\GesObjEspBundle\Entity\Actividad;
use MinSal\SidPla\GesObjEspBundle\EntityDao\ActividadDao;
use MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento;
use MinSal\SidPla\PrograMonitoreoBundle\EntityDao\CompromisoCumplimientoDao;

class ReprogramacionDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaPrograMonitoreoBundle:Reprogramacion');
    }

    public function getReprogramacionEspecifico($codigo) {
        $reprogramacion = $this->repositorio->find($codigo);
        return $reprogramacion;
    }
    
     public function agregarReprogramacion($fechIniOrSeg,$fechFinOrSeg,$prograOrSeg,$fechIniNuSeg,$fechFinNuSeg,$prograNuSeg,
                                           $fechIniOrTer,$fechFinOrTer,$prograOrTer,$fechIniNuTer,$fechFinNuTer,$prograNuTer,
                                           $fechIniOrCua,$fechFinOrCua,$prograOrCua,$fechIniNuCua,$fechFinNuCua,$prograNuCua,
                                           \MinSal\SidPla\PrograMonitoreoBundle\Entity\CompromisoCumplimiento $compromisoCumplimiento) {
         
        $reprogramacion=new Reprogramacion();
        $reprogramacion->setCompromisoCumplimiento($compromisoCumplimiento);
        //SEGUNDO TRIMESTRE
        $reprogramacion->setIniFechOrSeg($fechIniOrSeg);
        $reprogramacion->setFinFechOrSeg($fechFinOrSeg);
        $reprogramacion->setPrograOrSeg($prograOrSeg);
        if($fechIniNuSeg!="--")
            $reprogramacion->setIniFechNuSeg($fechIniNuSeg);
        if($fechFinNuSeg!="--")
            $reprogramacion->setIniFechNuSeg($fechIniNuSeg);
        $reprogramacion->setFinFechNuSeg($fechFinNuSeg);
        $reprogramacion->setPrograNuSeg($prograNuSeg);
        //TERCER TRIMESTRE
        $reprogramacion->setIniFechOrTer($fechIniOrTer);
        $reprogramacion->setFinFechOrTer($fechFinOrTer);
        $reprogramacion->setPrograOrTer($prograOrTer);
        if($fechIniNuTer!="--")
            $reprogramacion->setIniFechNuTer($fechIniNuTer);
        if($fechFinNuTer!="--")
            $reprogramacion->setFinFechNuTer($fechFinNuTer);
        $reprogramacion->setPrograNuTer($prograNuTer);
        //CUARTO TRIMESTRE
        $reprogramacion->setIniFechOrCua($fechIniOrCua);
        $reprogramacion->setFinFechOrCua($fechFinOrCua);
        $reprogramacion->setPrograOrCua($prograOrCua);
        if($fechIniNuCua!="--")
            $reprogramacion->setIniFechNuCua($fechIniNuCua);
        if($fechFinNuCua!="--")
            $reprogramacion->setFinFechNuCua($fechFinNuCua);
        $reprogramacion->setPrograNuCua($prograNuCua);
        
        //$resActComp=new ResulActividad();
        $resActComp= $compromisoCumplimiento->getIdResActividad();
        $actividad=new Actividad();
        $actividad= $resActComp->getIdActividad();
        $resActAux=new ResulActividad();
        foreach($actividad->getResulAct() as $resActAux){
            switch ($resActAux->getResulActTrimestre()){
                case 2:
                    if($prograNuSeg!=0){
                        $resActAux->setResulActProgramado($prograOrSeg+$prograNuSeg);
                        $resActAux->setResulActFechaFin($fechFinNuSeg);   
                    }
                    break;
                case 3:
                    if($prograNuTer!=0){
                        $resActAux->setResulActProgramado($prograOrTer+$prograNuTer);
                        $resActAux->setResulActFechaFin($fechFinNuTer);   
                    }
                    break;
                case 4:
                    if($prograNuCua!=0){
                        $resActAux->setResulActProgramado($prograOrCua+$prograNuCua);
                        $resActAux->setResulActFechaFin($fechFinNuCua);   
                    }
                    break;
            }
            //ACTUALIZA LOS CAMBIOS
            $this->em->persist($resActAux);
            $this->em->flush();
        }
        
        //$unidadMedidaDao = new UnidadMedidaDao($this->doctrine);
        $this->em->persist($reprogramacion);
        $compromisoCumplimiento->addReprogramaciones($reprogramacion);
        $this->em->persist($compromisoCumplimiento);
        
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar elementos de infraestructura termino con exito');

        return $matrizMensajes;
    }

/*
    public function editarElementoInfra($codElemInfra, $nomElemInfra, $abreElemInfra, $descElemInfra) {

        $elemInfra = $this->getElementoInfraestructuraEspecifico($codElemInfra);
        $elemInfra->setNomElemInfra($nomElemInfra);

        $unidadMedidaDao = new UnidadMedidaDao($this->doctrine);
        $unidadMedida = $unidadMedidaDao->getUnidadMedidaEspecifica($abreElemInfra);
        $elemInfra->setCodUnidadMed($unidadMedida);


        $elemInfra->setElemInfraDescrip($descElemInfra);


        $this->em->persist($elemInfra);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el elemento de infraestructura termino con exito');

        return $matrizMensajes;
    }

    public function eliminarElementoInfra($codigo) {

        $elementoinfra = $this->repositorio->find($codigo);

        $this->em->remove($elementoinfra);
        $this->em->flush();

        $matrizMensajes = array('El proceso de eliminar termino con exito');

        return $matrizMensajes;
    } 
     */

}

?>
