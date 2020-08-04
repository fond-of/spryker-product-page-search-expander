<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductAbstractMap;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory getFactory()
 */
class AvailableMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands and returns the provided PageMapTransfer objects data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        if (
            !array_key_exists('locale', $productData) ||
            !array_key_exists('id_product_abstract', $productData) ||
            !array_key_exists('store', $productData)
        ) {
            return $pageMapTransfer;
        }

        $storeTransfer = $this->getFactory()
            ->getStoreFacade()
            ->findStoreByName($productData['store']);

        if ($storeTransfer === null) {
            return $pageMapTransfer;
        }

        $productAbstractAvailabilityTransfer = $this->getFactory()
            ->getAvailabilityFacade()
            ->findOrCreateProductAbstractAvailabilityBySkuForStore($productData['sku'], $storeTransfer);

        if ($productAbstractAvailabilityTransfer === null) {
            return $pageMapTransfer;
        }

        $available = $productAbstractAvailabilityTransfer
            ->getAvailability()
            ->greaterThan(0) ? true : false;

        if ($productAbstractAvailabilityTransfer->getIsNeverOutOfStock() === true) {
            $pageMapTransfer->setAvailable(true);
            $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchExpanderConstants::AVAILABLE, true);
        }

        $pageMapTransfer->setAvailable($available);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchExpanderConstants::AVAILABLE, $available);

        return $pageMapTransfer;
    }
}
