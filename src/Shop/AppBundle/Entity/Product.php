<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 27.03.15
 * Time: 11:00
 */

namespace Shop\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name=product)
 *
 * Class Product
 * @package Shop\AppBundle\Entity
 */

class Product
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $product;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $price;

    /**
     * @Column(type="integer")
     */
    protected $amount;
}