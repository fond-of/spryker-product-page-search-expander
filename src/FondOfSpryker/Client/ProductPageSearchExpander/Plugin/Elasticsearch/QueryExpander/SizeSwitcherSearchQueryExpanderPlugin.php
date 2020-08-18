<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory getFactory()
 */
class SizeSwitcherSearchQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        $needle = [
            ProductPageSearchExpanderConstants::STYLE_KEY,
            ProductPageSearchExpanderConstants::MODEL_SHORT,
            ProductPageSearchExpanderConstants::OPTION_SIZE_SWITCHER,
        ];

        foreach ($needle as $item) {
            if (!array_key_exists($item, $requestParameters)) {
                return $searchQuery;
            }
        }

        $boolQuery = $this->getBoolQuery($searchQuery->getSearchQuery());

        $matchQueryModelShort = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(
                ProductPageSearchExpanderConstants::MODEL_SHORT,
                $requestParameters[ProductPageSearchExpanderConstants::MODEL_SHORT]
            );

        $matchQueryStyleKey = $this->getFactory()
            ->createQueryBuilder()
            ->createMatchQuery()
            ->setField(
                ProductPageSearchExpanderConstants::STYLE_KEY,
                $requestParameters[ProductPageSearchExpanderConstants::STYLE_KEY]
            );

        $boolQuery->addMust($matchQueryModelShort);
        $boolQuery->addMust($matchQueryStyleKey);

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
