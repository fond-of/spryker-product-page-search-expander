<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class ProductPageSearchExpanderClient extends AbstractClient implements ProductPageSearchExpanderClientInterface
{
    /**
     * @param string $modelKey
     * @param string $size
     *
     * @return array|null
     */
    public function getProductsWithSameModelKeyAndSize(string $modelKey, string $size): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::MODEL_KEY => $modelKey,
                ProductPageSearchExpanderConstants::SIZE => $size,
            ]);
    }

    /**
     * @param string $modelKey
     * @param string $styleKey
     *
     * @return array|null
     */
    public function getProductsWithSameModelKeyAndStyleKey(string $modelKey, string $styleKey): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::MODEL_KEY => $modelKey,
                ProductPageSearchExpanderConstants::STYLE_KEY => $styleKey,
            ]);
    }

    /**
     * @param string $modelKey
     *
     * @return array|null
     */
    public function getProductsWithSameModelKey(string $modelKey): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::MODEL_KEY => $modelKey,
            ]);
    }

    /**
     * @param string $styleKey
     *
     * @return array|null
     */
    public function getProductsWithSameStyleKey(string $styleKey): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::STYLE_KEY => $styleKey,
            ]);
    }

    /**
     * @deprecated
     *
     * @param string $modelKey
     * @param string $styleKey
     * @param string|null $optionDontMergeSizes
     *
     * @return array|null
     */
    public function getSimilarProducts(string $modelKey, string $styleKey, ?string $optionDontMergeSizes): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::MODEL_KEY => $modelKey,
                ProductPageSearchExpanderConstants::STYLE_KEY => $styleKey,
                ProductPageSearchExpanderConstants::OPTION_DONT_MERGE_SIZES => $optionDontMergeSizes,
            ]);
    }

    /**
     * @param string $modelShort
     * @param string $styleKey
     * @param string|null $optionSizeSwitcher
     *
     * @return array|null
     *@deprecated use getProductsWithSameModelKeyAndStyleKey() instead
     *
     */
    public function getProductsSizeSwitcher(string $modelShort, string $styleKey, ?string $optionSizeSwitcher): ?array
    {
        return $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [
                ProductPageSearchExpanderConstants::STYLE_KEY => $styleKey,
                ProductPageSearchExpanderConstants::MODEL_SHORT => $modelShort,
                ProductPageSearchExpanderConstants::OPTION_SIZE_SWITCHER => $optionSizeSwitcher,
            ]);
    }
}
