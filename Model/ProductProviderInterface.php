<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use BlackBoxCode\Pando\Bundle\BaseBundle\Model\IdInterface;
use BlackBoxCode\Pando\Bundle\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException;
use Doctrine\Common\Collections\ArrayCollection;

interface ProductProviderInterface extends IdInterface
{
    /**
     * @return ProductProviderTypeInterface
     */
    public function getType();

    /**
     * @param ProductProviderTypeInterface $type
     * @return $this
     */
    public function setType(ProductProviderTypeInterface $type);

    /**
     * @return ArrayCollection<ProductInterface>
     */
    public function getProducts();

    /**
     * @param ProductInterface $product
     * @return $this
     */
    public function addProduct(ProductInterface $product);

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product);

    /**
     * Checks if all Products this ProductProvider is assigned to don't already
     * have a provider with the same ProductProviderType and throws an exception
     * if one or more do
     *
     * @throws ZeroOrOneException
     */
    public function checkZeroOrOneProviderOfSameType();
}
