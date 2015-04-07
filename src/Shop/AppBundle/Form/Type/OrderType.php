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
use Shop\AppBundle\Form\DataTransformer\ProductToNumberTransformer;
use Shop\AppBundle\Form\DataTransformer\OrderToNumberTransformer;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $em = $option['em'];
        $transformerOrder = new OrderToNumberTransformer($em);
        $transformerProduct = new ProductToNumberTransformer($em);

        $builder
            ->add(
                $builder
                    ->create('order', 'text')
                    ->addModelTransformer($transformerOrder)
            )
            ->add(
                $builder
                    ->create('product', 'text')
                    ->addModelTransformer($transformerProduct)
            )
            ->add('count', 'number')
            ->add('save', 'submit', array('label' => 'Order'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => 'Shop\AppBundle\Entity\OrderProduct',
            ))
            ->setRequired(array('em'))
            ->setAllowedTypes('em', 'Doctrine\Common\Persistence\ObjectManager');
    }

    public function getName()
    {
        return 'orderProduct';
    }
}