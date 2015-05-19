<?php
namespace BlackBoxCode\Pando\ProductProviderBundle\Model;

use BlackBoxCode\Pando\BaseBundle\Model\TypeTrait;
use BlackBoxCode\Pando\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
trait ProductProviderTrait
{
    use TypeTrait;

    /**
     * @var ProductProviderTypeInterface
     *
     * @ORM\ManyToOne(targetEntity="ProductProviderType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var ArrayCollection<ProductInterface>
     *
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="providers")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(nullable=false)}
     * )
     */
    private $products;


    /**
     * {@inheritdoc}
     */
    public function getPathDescription()
    {
        return 'ProductProvider: ' . $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(ProductProviderTypeInterface $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        if (is_null($this->products)) $this->products = new ArrayCollection();

        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product)
    {
        if (is_null($this->products)) $this->products = new ArrayCollection();
        $this->products->add($product);
        $product->addProvider($this);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product)
    {
        if (is_null($this->products)) $this->products = new ArrayCollection();
        $this->products->removeElement($product);
        $product->removeProvider($this);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * {@inheritdoc}
     */
    public function checkZeroOrOneProviderOfSameType()
    {
        foreach ($this->getProducts() as $product) {
            $product->checkZeroOrOneProviderOfSameType();
        }
    }
}
