<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory;
use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToAvailabilityFacadeBridge;
use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToStoreFacadeBridge;
use Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\DecimalObject\Decimal;

class AvailableDataExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData\ModelKeyDataExpanderPlugin
     */
    protected $plugin;

    /**
     * @var \Generated\Shared\Transfer\ProductPageSearchTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productPageSearchTransfer;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractAvailabilityTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productAbstractAvailabilityTransfer;

    /**
     * @var \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $communicationFactoryMock;

    /**
     * @var \FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \Spryker\DecimalObject\Decimal|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $decimalMock;

    /**
     * @var \FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToAvailabilityFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $availablityFacadeMock;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before();

        $this->productPageSearchTransfer = $this->getMockBuilder(ProductPageSearchTransfer::class)
            ->setMethods(['getStore', 'getSku', 'setAvailable', 'setStore', 'setSku'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractAvailabilityTransfer = $this->getMockBuilder(ProductAbstractAvailabilityTransfer::class)
            ->setMethods(['getIsNeverOutOfStock', 'getAvailability'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransfer = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->communicationFactoryMock = $this->getMockBuilder(ProductPageSearchExpanderCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(ProductPageSearchExpanderToStoreFacadeBridge::class)
            ->setMethods(['findStoreByName'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->availablityFacadeMock = $this->getMockBuilder(ProductPageSearchExpanderToAvailabilityFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->decimalMock = $this->getMockBuilder(Decimal::class)
            ->setMethods(['greaterThan'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new AvailableDataExpanderPlugin();
        $this->plugin->setFactory($this->communicationFactoryMock);
    }

    /**
     * @return void
     */
    public function testAvailableExpanderPluginTestSuccessInStock(): void
    {
        $this->communicationFactoryMock->expects($this->atLeastOnce())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->storeFacadeMock->expects($this->once())
            ->method('findStoreByName')
            ->willReturn($this->storeTransfer);

        $this->productPageSearchTransfer->expects($this->once())
            ->method('getStore')
            ->willReturn('STORE_NAME');

        $this->productPageSearchTransfer->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn('SKU-111-111');

        $this->communicationFactoryMock->expects($this->once())
            ->method('getAvailabilityFacade')
            ->willReturn($this->availablityFacadeMock);

        $this->availablityFacadeMock->expects($this->once())
            ->method('findOrCreateProductAbstractAvailabilityBySkuForStore')
            ->with($this->productPageSearchTransfer->getSku(), $this->storeTransfer)
            ->willReturn($this->productAbstractAvailabilityTransfer);

        $this->productAbstractAvailabilityTransfer->expects($this->atLeastOnce())
            ->method('getIsNeverOutOfStock')
            ->willReturn(false);

        $this->productAbstractAvailabilityTransfer->expects($this->atLeastOnce())
            ->method('getAvailability')
            ->willReturn($this->decimalMock);

        $this->decimalMock->expects($this->atLeastOnce())
            ->method('greaterThan')
            ->willReturn(true);

        $this->productPageSearchTransfer->expects($this->atLeastOnce())
            ->method('getStore')
            ->willReturn('STORE_NAME');

        $this->plugin->expandProductPageData([], $this->productPageSearchTransfer);
    }

    /**
     * @return void
     */
    public function testAvailableExpanderPluginTestSuccessNeverOutOfStock(): void
    {
        $this->communicationFactoryMock->expects($this->atLeastOnce())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->storeFacadeMock->expects($this->once())
            ->method('findStoreByName')
            ->willReturn($this->storeTransfer);

        $this->productPageSearchTransfer->expects($this->once())
            ->method('getStore')
            ->willReturn('STORE_NAME');

        $this->productPageSearchTransfer->expects($this->atLeastOnce())
            ->method('getSku')
            ->willReturn('SKU-111-111');

        $this->communicationFactoryMock->expects($this->once())
            ->method('getAvailabilityFacade')
            ->willReturn($this->availablityFacadeMock);

        $this->availablityFacadeMock->expects($this->once())
            ->method('findOrCreateProductAbstractAvailabilityBySkuForStore')
            ->with($this->productPageSearchTransfer->getSku(), $this->storeTransfer)
            ->willReturn($this->productAbstractAvailabilityTransfer);

        $this->productAbstractAvailabilityTransfer->expects($this->atLeastOnce())
            ->method('getIsNeverOutOfStock')
            ->willReturn(true);

        $this->productAbstractAvailabilityTransfer->expects($this->never())
            ->method('getAvailability');

        $this->plugin->expandProductPageData([], $this->productPageSearchTransfer);
    }

    /**
     * @return void
     */
    public function testAvailableExpanderPluginTestFailedStoreNotFound()
    {
        $this->communicationFactoryMock->expects($this->atLeastOnce())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->productPageSearchTransfer->expects($this->once())
            ->method('getStore')
            ->willReturn('STORE_NAME');

        $this->storeFacadeMock->expects($this->atLeastOnce())
            ->method('findStoreByName')
            ->willReturn(null);

        $this->communicationFactoryMock->expects($this->never())
            ->method('getAvailabilityFacade');

        $this->plugin->expandProductPageData([], $this->productPageSearchTransfer);
    }
}
