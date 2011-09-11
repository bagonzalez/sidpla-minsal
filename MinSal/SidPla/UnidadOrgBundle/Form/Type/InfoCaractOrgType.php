<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MinSal\SidPla\UnidadOrgBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * Description of InfoCaractOrgType
 *
 * @author bgonzalez
 */
class InfoCaractOrgType extends AbstractType {
    
    public function buildForm(FormBuilder $builder, array $opciones)
    {
        //$builder->add('unidadOrganizativa',  'entity',  array( 'class' => 'MinSal\\SidPla\\AdminBundle\\Entity\\UnidadOrganizativa')); 
        $builder->add('telefono', 'text');
        $builder->add('fax', 'text');
        $builder->add('direccion', 'text');
        $builder->add('email', 'email');  
        $builder->add('fechaActualizacion', 'date', array(            
            'widget' => 'single_text',
        ));  
        
    }

    public function getName()
    {
        return 'infoCaractOrg';
    }
}

?>
