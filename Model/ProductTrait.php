<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
