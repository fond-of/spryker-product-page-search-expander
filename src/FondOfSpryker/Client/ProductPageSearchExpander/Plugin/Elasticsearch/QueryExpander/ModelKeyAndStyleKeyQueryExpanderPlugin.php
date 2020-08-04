<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchElasticsearch\Config\SortConfig;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class ModelKeyAndStyleKeyQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
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

        if (!array_key_exists(ProductPageSearchExpanderConstants::STYLE_KEY, $requestParameters)) {
            return $searchQuery;
        }

        $modelKey = $requestParameters[ProductPageSearchExpanderConstants::MODEL_KEY];
        $styleKey = $requestParameters[ProductPageSearchExpanderConstants::STYLE_KEY];
        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        $matchModelKeyQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(ProductPageSearchExpanderConstants::MODEL_KEY, $modelKey);

        $matchStyleKeyQuery = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(ProductPageSearchExpanderConstants::STYLE_KEY, $styleKey);

        $boolQuery->addMust($matchModelKeyQuery);
        $boolQuery->addMust($matchStyleKeyQuery);

        $this->addSort($searchQuery->getSearchQuery());

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $searchQuery
     *
     * @return void
     */
    protected function addSort(Query $searchQuery): void
    {
        $searchQuery->addSort([
            PageIndexMap::INTEGER_SORT . '.' . PageIndexMap::SIZE => [
                'order' => SortConfig::DIRECTION_ASC,
                'mode' => 'min',
            ],
        ]);
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
