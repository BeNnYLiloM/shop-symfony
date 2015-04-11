<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 27.03.15
 * Time: 12:12
 */

namespace Shop\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="orderProduct")
 */

class OrderProduct
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     */
    protected $product;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return OrderProduct
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set order
     *
     * @param \Shop\AppBundle\Entity\Order $order
     * @return OrderProduct
     */
    public function setOrder(\Shop\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Shop\AppBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Shop\AppBundle\Entity\Product $product
     * @return OrderProduct
     */
    public function setProduct(\Shop\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Shop\AppBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}
