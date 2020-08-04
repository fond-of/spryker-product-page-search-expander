<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class ProductViewSizeSwitcherProductsExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
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

        $productsInDifferentSizes = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::STYLE_KEY => $productAttributes[ProductPageSearchExpanderConstants::STYLE_KEY],
                ProductPageSearchExpanderConstants::MODEL_SHORT => $productAttributes[ProductPageSearchExpanderConstants::MODEL_SHORT],
                ProductPageSearchExpanderConstants::OPTION_SIZE_SWITCHER => ProductPageSearchExpanderConstants::OPTION_SIZE_SWITCHER,
            ]);

        if (!isset($productsInDifferentSizes['products'])) {
            return $productViewTransfer;
        }

        return $productViewTransfer->setProductsSizeSwitcher($productsInDifferentSizes['products']);
    }
}
