<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06/04/15
 * Time: 11:35
 */

namespace Shop\AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Shop\AppBundle\Entity\Product;

class ProductToNumberTransformer implements DataTransformerInterface
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
     * @param Product|null $product
     *
     * @return string
     */
    public function transform($product)
    {
        if(null === $product){
            return "";
        }

        return $product->getId();
    }

    /**
     * Transforms a string (number) to object (issue).
     *
     * @param string $id
     *
     * @return Product|null
     *
     * @throws TransformationFailedException if object (issue) if not found.
     */
    public function reverseTransform($id)
    {
        if(!$id){
            return null;
        }

        $product = $this->om
            ->getRepository('ShopAppBundle:Product')
            ->findOneBy(array('id' => $id))
        ;

        if(null === $product){
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }

        return $product;
    }
}