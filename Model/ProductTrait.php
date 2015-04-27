<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use BlackBoxCode\Pando\Bundle\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;
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
     * Checks if this Product belongs to more than one ProductProvider
     * of the same type and throws an exception if it does
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @throws ZeroOrOneException
     */
    public function checkZeroOrOneProviderOfSameType()
    {
        $providerTypes = [];

        $providerType = null;
        $duplicate = false;
        foreach ($this->getProviders() as $provider) {
            $providerType = $provider->getType()->getName();
            if (in_array($providerType, $providerTypes)) {
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
                    $providerType
                )
            );
        }
    }
    
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
    
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeProvider(ProductProviderInterface $provider)
    {
        if (is_null($this->providers)) $this->providers = new ArrayCollection();
        $this->providers->removeElement($provider);
    }
}
