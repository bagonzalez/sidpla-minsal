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

namespace  MinSal\SidPla\UsersBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Doctrine\ORM\EntityRepository;


/**
 * Description of RegistrationFormType
 *
 * @author Bruno González
 */

class RegistrationFormType  extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('empleado', 'entity',
                array( 'class' => 'MinSal\\SidPla\\AdminBundle\\Entity\\Empleado',
               'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                    ->orderBy('u.primerNombre', 'ASC');
                },
        ));
                
       /* $builder->add('rol', 'entity',
                array( 'class' => 'MinSal\\SidPla\\AdminBundle\\Entity\\RolSistema',
               'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                    ->orderBy('u.nombreRol', 'ASC');
                },
        ));*/
    }

    public function getName()
    {
        return 'sidpla_user_registration';
    }
}


?>
