<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use BlackBoxCode\Pando\Bundle\BaseBundle\Model\TypeTrait;
use Doctrine\ORM\Mapping as ORM;

trait ProductProviderTrait
{
    use TypeTrait;

    /**
     * @ORM\ManyToOne(targetEntity="ProductProviderType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="providers")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(nullable=false)}
     * )
     */
    private $products;
}
