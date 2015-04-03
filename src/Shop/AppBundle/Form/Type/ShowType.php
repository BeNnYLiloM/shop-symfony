<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 03/04/15
 * Time: 15:29
 */

namespace Shop\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('id', 'number')
            ->add('save', 'submit', array('label' => 'Go'));
    }

    public function getName()
    {
        return 'show';
    }
}