<?php

namespace MinSal\SidPla\RRMedicoBundle\EntityDao;

use MinSal\SidPla\RRMedicoBundle\Entity\ResulPrograRRMed;
use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\RRMedicoBundle\Entity\TipoHorario;
use MinSal\SidPla\RRMedicoBundle\Entity\PrograRRMed;
use MinSal\SidPla\RRMedicoBundle\EntityDao\PrograRRMedDao;

class ResulPrograRRMedDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaRRMedicoBundle:ResulPrograRRMed');
    }

    /*
     * Obtiene una Resultado RRMed
     */

    public function getResulPrograRRMedEspecifico($codigo) {
        $resulPrograRRMed = $this->repositorio->find($codigo);
        return $resulPrograRRMed;
    }

    /*
     * calcula los minutos del recurso medico
     */

    public function calcularMin($cantPer, $horas, $turno) {

        if ($turno == 1) {
            if ($horas >= 6)
                $min = $cantPer * ($horas * 60 - 40);
            else
                $min = $cantPer * ($horas * 60);
        }
        else {
            if ($horas >= 12)
                $min = $cantPer * $horas * 60;
            else
                $min = $cantPer * ($horas * 60 - 40);
        }
        return $min;
    }

    /*
     * Editar un resultado programacion recurso
     */

    public function editarResulPrograRRMed($codResulProgra, $cantResult) {

        $resulPrograRR = $this->getResulPrograRRMedEspecifico($codResulProgra);


        $codPrograRRMed = $resulPrograRR->getPrograRRHH()->getCodPrograRRMed();

        $tipoHorario = $resulPrograRR->gettipoHorario();
        $horas = $tipoHorario->getTipoCantidadHor();
        $turno = $tipoHorario->getTipoHorTurno();

        $totalHorasdiarias = $cantResult * $horas;

        if ($tipoHorario->getTipoHorTurno() == 1) {
            $totalMinutosDiarios = $this->calcularMin($cantResult, $horas, $turno);
            $consultasDiasDisponibles = ($this->calcularMin($cantResult, $horas, $turno)) / 10;
        } else {
            $totalMinutosDiarios = $this->calcularMin($cantResult, $horas, $turno);
            if ($horas < 12)
                $consultasDiasDisponibles = ($this->calcularMin($cantResult, $horas, $turno)) / 10;
            else
                $consultasDiasDisponibles = ($this->calcularMin($cantResult, $horas, $turno)) / 30;
        }

        $resulPrograRR->setCantRRMedDispo($cantResult);
        $resulPrograRR->setTotalHorasRR($totalHorasdiarias);
        $resulPrograRR->setConsulasDispo($consultasDiasDisponibles);
        $resulPrograRR->settotalMinRR($totalMinutosDiarios);

        $this->em->persist($resulPrograRR);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar editar el resultado programacion recurso termino con exito');

        $prograRRMedDao = new PrograRRMedDao($this->doctrine);
        $resul = $prograRRMedDao->editarPrograRRMed($codPrograRRMed);

        return $matrizMensajes;
    }

}

?>