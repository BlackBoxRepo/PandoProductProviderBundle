<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait ProductTrait
{
    /**
     * @ORM\ManyToMany(targetEntity="ProductProvider", mappedBy="products")
     */
    private $providers;
}
