<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06/04/15
 * Time: 17:34
 */

namespace Shop\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Shop\AppBundle\Entity\Order;

class OrderToNumberTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param Order|null $order
     *
     * @return string
     */
    public function transform($order)
    {
        if(null === $order){
            return "";
        }

        return $order->getId();
    }

    /**
     * Transforms a string (number) to object (issue).
     *
     * @param string $id
     *
     * @return Order|null
     *
     * @throws TransformationFailedException if object (issue) if not found.
     */
    public function reverseTransform($id)
    {
        if(!$id){
            return null;
        }

        $order = $this->om
            ->getRepository('ShopAppBundle:Order')
            ->findOneBy(array('id' => $id))
        ;

        if(null === $order){
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }

        return $order;
    }
}