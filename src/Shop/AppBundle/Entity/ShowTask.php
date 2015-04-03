<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 03/04/15
 * Time: 15:27
 */

namespace Shop\AppBundle\Entity;

class ShowTask
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}