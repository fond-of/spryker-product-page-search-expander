<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Dependency\Client;

interface ProductPageSearchExpanderToCatalogClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array;
}
