<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Dependency\Client;

use Spryker\Client\Catalog\CatalogClientInterface;

class ProductPageSearchExpanderToCatalogClientBridge implements ProductPageSearchExpanderToCatalogClientInterface
{
    /**
     * @var \Spryker\Client\Catalog\CatalogClientInterface
     */
    protected $catalogClient;

    /**
     * @param \Spryker\Client\Catalog\CatalogClientInterface $catalogClient
     */
    public function __construct(CatalogClientInterface $catalogClient)
    {
        $this->catalogClient = $catalogClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function catalogSearch(string $searchString, array $requestParameters): array
    {
        return $this->catalogClient->catalogSearch($searchString, $requestParameters);
    }
}
