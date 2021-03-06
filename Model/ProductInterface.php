<?php
namespace BlackBoxCode\Pando\ProductProviderBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use BlackBoxCode\Pando\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;

interface ProductInterface extends \BlackBoxCode\Pando\ProductSaleBundle\Model\ProductInterface
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

    /**
     * Checks if this Product belongs to more than one ProductProvider
     * of the same type and throws an exception if it does
     *
     * @throws ZeroOrOneException
     */
    public function checkZeroOrOneProviderOfSameType();
}
