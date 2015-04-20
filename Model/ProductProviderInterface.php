<?php
namespace BlackBoxCode\Pando\Bundle\ProductProviderBundle\Model;

use BlackBoxCode\Pando\Bundle\BaseBundle\Model\IdInterface;
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
}
