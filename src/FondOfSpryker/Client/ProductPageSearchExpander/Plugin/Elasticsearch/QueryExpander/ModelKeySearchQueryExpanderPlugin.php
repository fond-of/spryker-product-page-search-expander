<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class ModelKeySearchQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * Specification:
     *  - Expands base query.
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!array_key_exists(ProductPageSearchExpanderConstants::MODEL_KEY, $requestParameters)) {
            return $searchQuery;
        }

        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        $matchQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(
                ProductPageSearchExpanderConstants::MODEL_KEY,
                $requestParameters[ProductPageSearchExpanderConstants::MODEL_KEY]
            );

        $boolQuery->addMust($matchQuery);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @throws \InvalidArgumentException
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function getBoolQuery(Query $query)
    {
        $boolQuery = $query->getQuery();
        if (!$boolQuery instanceof BoolQuery) {
            throw new InvalidArgumentException(sprintf(
                'Localized query expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery)
            ));
        }

        return $boolQuery;
    }
}
