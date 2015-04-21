<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use BlackBoxCode\Pando\Bundle\BaseBundle\Model\TypeTrait;
use BlackBoxCode\Pando\Bundle\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * Checks if all Products this ProductProvider is assigned to don't already
     * have a provider with the same ProductProviderType and throws an exception
     * if one or more do
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @throws ZeroOrOneException
     */
    public function checkZeroOrOneProviderOfSameType()
    {
        $providerType = $this->getType();

        $products = $this->getProducts()->filter(
            function($product) use ($providerType) {
                $providers = $product->getProviders()->filter(
                    function($provider) use ($providerType) {
                        return $provider->getType() == $providerType;
                    }
                );

                return $providers->count() > 0;
            }
        );

        if ($products->count() > 0) {
            throw new ZeroOrOneException(
                sprintf(
                    'ProductProvider "%s" cannot belong to Products that already have a ProductProvider of type "%s"',
                    $this->getName(),
                    $providerType->getName()
                )
            );
        }
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product)
    {
        if (is_null($this->products)) $this->products = new ArrayCollection();
        $this->products->removeElement($product);
    }
}
