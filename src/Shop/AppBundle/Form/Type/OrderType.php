<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 07/04/15
 * Time: 12:57
 */

namespace Shop\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('product', 'text');
    }

    public function getName()
    {
        return 'order';
    }
}