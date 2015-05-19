<?php
namespace BlackBoxCode\Pando\ProductProviderBundle\Tests\Entity;

use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductInterface;
use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderInterface;
use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ProductProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|ProductProviderInterface */
    private $mProductProvider;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ProductInterface */
    private $mProduct;

    public function setUp()
    {
        $this->mProductProvider = $this
            ->getMockBuilder('BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderTrait')
            ->setMethods([
                'getProducts'
            ])
            ->getMockForTrait()
        ;

        $this->mProduct = $this->getMock('BlackBoxCode\Pando\ProductProviderBundle\Model\ProductInterface');
    }

    /**
     * @test
     */
    public function checkZeroOrOneProviderOfSameType_correctCalls()
    {
        $mProduct1 = clone $this->mProduct;
        $mProduct2 = clone $this->mProduct;

        $this->mProductProvider
            ->expects($this->once())
            ->method('getProducts')
            ->willReturn(new ArrayCollection([$mProduct1, $mProduct2]))
        ;

        $mProduct1
            ->expects($this->once())
            ->method('checkZeroOrOneProviderOfSameType')
        ;

        $mProduct2
            ->expects($this->once())
            ->method('checkZeroOrOneProviderOfSameType')
        ;

        $this->mProductProvider->checkZeroOrOneProviderOfSameType();
    }
}
