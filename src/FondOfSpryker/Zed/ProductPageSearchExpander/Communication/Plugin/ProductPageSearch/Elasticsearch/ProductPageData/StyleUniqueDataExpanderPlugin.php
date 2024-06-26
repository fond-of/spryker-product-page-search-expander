<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory getFactory()
 */
class StyleUniqueDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
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
        if (!isset($productData[ProductPageSearchExpanderConstants::PRODUCT_ATTRIBUTES])) {
            return;
        }

        $productAttributes = json_decode($productData[ProductPageSearchExpanderConstants::PRODUCT_ATTRIBUTES], true);

        if (array_key_exists(ProductPageSearchExpanderConstants::STYLE_UNIQUE, $productAttributes)) {
            $productAbstractPageSearchTransfer->setStyleKey($productAttributes[ProductPageSearchExpanderConstants::STYLE_UNIQUE]);
        }
    }
}
