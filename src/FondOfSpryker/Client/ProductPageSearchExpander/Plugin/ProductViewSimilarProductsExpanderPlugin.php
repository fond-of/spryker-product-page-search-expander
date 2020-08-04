<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class ProductViewSimilarProductsExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands and returns the provided ProductView transfer objects.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(
        ProductViewTransfer $productViewTransfer,
        array $productData,
        $localeName
    ): ProductViewTransfer {
        $productAttributes = $productViewTransfer->getAttributes();

        if (!isset($productAttributes[ProductPageSearchExpanderConstants::MODEL_KEY])) {
            return $productViewTransfer;
        }

        if (!isset($productAttributes[ProductPageSearchExpanderConstants::STYLE_KEY])) {
            return $productViewTransfer;
        }

        $similiarProducts = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::MODEL_KEY => $productAttributes[ProductPageSearchExpanderConstants::MODEL_KEY],
                ProductPageSearchExpanderConstants::STYLE_KEY => $productAttributes[ProductPageSearchExpanderConstants::STYLE_KEY],
                ProductPageSearchExpanderConstants::OPTION_DONT_MERGE_SIZES => ProductPageSearchExpanderConstants::OPTION_DONT_MERGE_SIZES,
            ]);

        if (!isset($similiarProducts['products'])) {
            return $productViewTransfer;
        }

        return $productViewTransfer->setSimilarProducts($similiarProducts['products']);
    }
}
