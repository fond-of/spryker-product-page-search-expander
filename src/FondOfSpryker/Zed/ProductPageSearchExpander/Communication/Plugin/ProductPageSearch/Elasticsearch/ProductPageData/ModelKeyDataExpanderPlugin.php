<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory getFactory()
 */
class ModelKeyDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    public const MODEL_KEY = 'model_key';

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

        if (array_key_exists(ProductPageSearchExpanderConstants::MODEL_KEY, $productAttributes)) {
            $productAbstractPageSearchTransfer->setModelKey($productAttributes[ProductPageSearchExpanderConstants::MODEL_KEY]);
        }
    }
}
