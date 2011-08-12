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

/**
 * Description of OpcionSistemaType
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OpcionSistemaType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $opciones)
    {
        $builder->add('nombreOpcion',  'text');
        $builder->add('descripcionOpcion', 'text');
        $builder->add('enlace', 'text');
        $builder->add('idOpcionSistema2', 'integer');
    }

    public function getName()
    {
        return 'opcionSistema';
    }
}

?>
