<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 02/04/15
 * Time: 12:45
 */

namespace Shop\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('orderId', null)
            ->add('productId', 'number')
            ->add('count', 'number')
            ->add('save', 'submit', array('label' => 'Order'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\AppBundle\Entity\OrderTask',
        ));
    }

    public function getName()
    {
        return 'orderTask';
    }
}