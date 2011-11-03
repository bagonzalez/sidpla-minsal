<?php
namespace MinSal\SidPla\CensoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

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
        $builder->add('divTabla','choice', array('choices'   => array('sidpla_informacionrelevante' => 'Informacion Relevante', 'sidpla_poblacionhumana' => 'Poblacion Humana','sidpla_infcomplementario' => 'Informacion Complementaria')));  
        
    }

    public function getName()
    {
        return 'categoriaCenso';
    }
    
}

?>
