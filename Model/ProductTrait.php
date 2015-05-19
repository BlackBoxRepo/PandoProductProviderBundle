<?php
namespace BlackBoxCode\Pando\ProductProviderBundle\Model;

use BlackBoxCode\Pando\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait ProductTrait
{
    /**
     * @var ArrayCollection<ProductProviderInterface>
     *
     * @ORM\ManyToMany(targetEntity="ProductProvider", mappedBy="products")
     */
    private $providers;


    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        if (is_null($this->providers)) $this->providers = new ArrayCollection();
        
        return $this->providers;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addProvider(ProductProviderInterface $provider)
    {
        if (is_null($this->providers)) $this->providers = new ArrayCollection();
        $this->providers->add($provider);
        $provider->addProduct($this);
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeProvider(ProductProviderInterface $provider)
    {
        if (is_null($this->providers)) $this->providers = new ArrayCollection();
        $this->providers->removeElement($provider);
        $provider->removeProduct($this);
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * {@inheritdoc}
     */
    public function checkZeroOrOneProviderOfSameType()
    {
        $providerTypes = [];

        $providerType = null;
        $duplicate = false;
        foreach ($this->getProviders() as $provider) {
            $providerType = $provider->getType();
            if (in_array($providerType, $providerTypes, true)) {
                $duplicate = true;
                break;
            }

            $providerTypes[] = $providerType;
        }

        if ($duplicate)
        {
            throw new ZeroOrOneException(
                sprintf(
                    'Product "%s" already belongs to a ProductProvider of type "%s"',
                    $this->getName(),
                    $providerType->getName()
                )
            );
        }
    }
}
