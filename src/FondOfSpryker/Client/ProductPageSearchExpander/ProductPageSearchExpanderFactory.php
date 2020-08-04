<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander;

use FondOfSpryker\Client\ProductPageSearchExpander\Dependency\Client\ProductPageSearchExpanderToCatalogClientInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilderInterface;

class ProductPageSearchExpanderFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilderInterface
    {
        return new QueryBuilder();
    }

    /**
     * @return \FondOfSpryker\Client\ProductPageSearchExpander\Dependency\Client\ProductPageSearchExpanderToCatalogClientInterface
     */
    public function getCatalogClient(): ProductPageSearchExpanderToCatalogClientInterface
    {
        return $this->getProvidedDependency(ProductPageSearchExpanderDependencyProvider::CLIENT_CATALOG);
    }
}
