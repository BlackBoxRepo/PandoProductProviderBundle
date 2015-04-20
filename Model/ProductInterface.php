<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

interface ProductInterface extends \BlackBoxCode\Pando\Bundle\ProductSaleBundle\Model\ProductInterface
{
    /**
     * @return ArrayCollection<ProviderInterface>
     */
    public function getProviders();

    /**
     * @param ProductProviderInterface $provider
     * @return $this
     */
    public function addProvider(ProductProviderInterface $provider);

    /**
     * @param ProductProviderInterface $provider
     * @return $this
     */
    public function removeProvider(ProductProviderInterface $provider);
}
