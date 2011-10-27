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
namespace MinSal\SidPla\TemplateUnisalBundle\EntityDao;

/**
 * Description of ActividadUniSalDao
 *
 * @author bagonzalez
 */
class ActividadUniSalDao {
    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaTemplateUnisalBundle:ActividadUniSal');
    }
    
    public function getActividadUniSal($codigo) {
        $actividadUnisal = $this->repositorio->find($codigo);
        return $actividadUnisal;
    }
    
     public function guardarActividad($actividad) {
        $this->em->persist($actividad);
        $this->em->flush();
    }

}

?>
