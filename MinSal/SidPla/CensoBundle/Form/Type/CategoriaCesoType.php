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
namespace MinSal\SidPla\CensoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoriaCesoType
 *
 * @author Bruno González
 */
class CategoriaCesoType  extends AbstractType  {
    
      public function buildForm(FormBuilder $builder, array $opciones)
    {
        $builder->add('bloque', 'entity',
                array( 'class' => 'MinSal\\SidPla\\CensoBundle\\Entity\\BloqueCenso',
               'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                    ->orderBy('u.nombreBloque', 'ASC');
                },
        ));
        $builder->add('descripcionCategoria',  'text');
        $builder->add('activo','choice', array('choices'   => array('true' => 'Activar', 'false' => 'Desactivar')));  
        $builder->add('divTabla', 'text');        
        
    }

    public function getName()
    {
        return 'categoriaCenso';
    }
    
}

?>
