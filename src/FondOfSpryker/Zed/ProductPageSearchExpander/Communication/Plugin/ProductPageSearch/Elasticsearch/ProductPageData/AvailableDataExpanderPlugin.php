<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory getFactory()
 */
class AvailableDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    /**
     * Specification:
     * - Expands the provided ProductAbstractPageSearch transfer object's data by reference.
     *
     * @api
     *
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(
        array $productData,
        ProductPageSearchTransfer $productAbstractPageSearchTransfer
    ): void {
        $storeTransfer = $this->getFactory()
            ->getStoreFacade()
            ->findStoreByName($productAbstractPageSearchTransfer->getStore());

        if ($storeTransfer === null) {
            return;
        }

        $productAbstractAvailabilityTransfer = $this->getFactory()
            ->getAvailabilityFacade()
            ->findOrCreateProductAbstractAvailabilityBySkuForStore($productAbstractPageSearchTransfer->getSku(), $storeTransfer);

        if ($productAbstractAvailabilityTransfer === null) {
            return;
        }

        if ($productAbstractAvailabilityTransfer->getIsNeverOutOfStock() === true) {
            $productAbstractPageSearchTransfer->setAvailable(true);

            return;
        }

        $available = $productAbstractAvailabilityTransfer->getAvailability()->greaterThan(0) ? true : false;

        $productAbstractPageSearchTransfer->setAvailable($available);
    }
}
