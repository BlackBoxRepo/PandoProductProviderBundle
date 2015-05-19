<?php
namespace BlackBoxCode\Pando\ProductProviderBundle\Tests\Entity;

use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductInterface;
use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderInterface;
use BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|ProductInterface */
    private $mProduct;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ProductProviderInterface */
    private $mProductProvider;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ProductProviderTypeInterface */
    private $mProductProviderType;

    public function setUp()
    {
        $this->mProduct = $this
            ->getMockBuilder('BlackBoxCode\Pando\ProductProviderBundle\Model\ProductTrait')
            ->setMethods([
                'getProviders',
                'getName'
            ])
            ->getMockForTrait()
        ;

        $this->mProductProvider = $this->getMock('BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderInterface');
        $this->mProductProviderType = $this->getMock('BlackBoxCode\Pando\ProductProviderBundle\Model\ProductProviderTypeInterface');
    }

    /**
     * @test
     */
    public function checkZeroOrOneProviderOfSameType_hasOneOfEach()
    {
        $mProductProviderX = clone $this->mProductProvider;
        $mProductProviderY = clone $this->mProductProvider;
        $mProductProviderTypeX = clone $this->mProductProviderType;
        $mProductProviderTypeY = clone $this->mProductProviderType;

        $this->mProduct
            ->expects($this->once())
            ->method('getProviders')
            ->willReturn(new ArrayCollection([$mProductProviderX, $mProductProviderY]))
        ;

        $mProductProviderX
            ->expects($this->once())
            ->method('getType')
            ->willReturn($mProductProviderTypeX)
        ;

        $mProductProviderY
            ->expects($this->once())
            ->method('getType')
            ->willReturn($mProductProviderTypeY)
        ;

        $this->mProduct->checkZeroOrOneProviderOfSameType();
    }

    /**
     * @test
     * @expectedException BlackBoxCode\Pando\ProductProviderBundle\Exception\Entity\LifeCycle\ZeroOrOneException
     */
    public function checkZeroOrOneProviderOfSameType_hasMoreThanOne()
    {
        $mProductProviderX = clone $this->mProductProvider;
        $mProductProviderY = clone $this->mProductProvider;

        $this->mProduct
            ->expects($this->once())
            ->method('getProviders')
            ->willReturn(new ArrayCollection([$mProductProviderX, $mProductProviderY]))
        ;

        $mProductProviderX
            ->expects($this->once())
            ->method('getType')
            ->willReturn($this->mProductProviderType)
        ;

        $mProductProviderY
            ->expects($this->once())
            ->method('getType')
            ->willReturn($this->mProductProviderType)
        ;

        $this->mProduct
            ->expects($this->once())
            ->method('getName')
            ->willReturn('Pen')
        ;

        $this->mProductProviderType
            ->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturn('Type X')
        ;

        $this->mProduct->checkZeroOrOneProviderOfSameType();
    }
}
