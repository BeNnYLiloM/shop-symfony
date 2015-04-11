<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 03/04/15
 * Time: 19:03
 */

namespace Shop\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('order', 'text')
            ->add('product', 'collection', array(
                'type' => new EditProductType(),
                'allow_add' => true
            ))
            ->add('count', null)
            ->add('save', 'submit', array('label' => 'Edit'));
    }

    public function getName()
    {
        return 'edit';
    }
}