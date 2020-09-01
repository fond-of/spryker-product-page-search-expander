<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander;

interface ProductPageSearchExpanderClientInterface
{
    /**
     * @param string $modelKey
     * @param string $size
     *
     * @return array|null
     */
    public function getProductsWithSameModelKeyAndSize(string $modelKey, string $size): ?array;

    /**
     * @param string $modelKey
     * @param string $styleKey
     *
     * @return array|null
     */
    public function getProductsWithSameModelKeyAndStyleKey(string $modelKey, string $styleKey): ?array;

    /**
     * @param string $modelKey
     *
     * @return array|null
     */
    public function getProductsWithSameModelKey(string $modelKey): ?array;

    /**
     * @param string $styleKey
     *
     * @return array|null
     */
    public function getProductsWithSameStyleKey(string $styleKey): ?array;

    /**
     * @deprecated
     *
     * @param string $modelKey
     * @param string $styleKey
     * @param string|null $optionDontMergeSizes
     *
     * @return array|null
     */
    public function getSimilarProducts(string $modelKey, string $styleKey, ?string $optionDontMergeSizes): ?array;

    /**
     * @deprecated use getProductsWithSameModelKeyAndStyleKey() instead
     *
     * @param string $modelShort
     * @param string $styleKey
     * @param string|null $optionSizeSwitcher
     *
     * @return array|null
     */
    public function getProductsSizeSwitcher(string $modelShort, string $styleKey, ?string $optionSizeSwitcher): ?array;
}
