<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/04/15
 * Time: 13:35
 */

namespace Shop\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'text')
            ->add('name', null)
            ->add('price', null)
            ->add('amount', null);
    }

    public function getName()
    {
        return 'editProduct';
    }
}