<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Match as MatchQuery;
use FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class StyleKeySearchQueryExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $queryBuilderMock;

    /**
     * @var \FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander\StyleKeySearchQueryExpanderPlugin
     */
    protected $queryExpanderPlugin;

    /**
     * @var \FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \Elastica\Query|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $elasticaQueryMock;

    /**
     * @var \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $searchQueryMock;

    /**
     * @var \Elastica\Query\Match|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $matchQueryMock;

    /**
     * @var \Elastica\Query\BoolQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $boolQueryMock;

    /**
     * @return void
     */
    protected function _before()
    {
        parent::_before(); // TODO: Change the autogenerated stub

        $this->factoryMock = $this->getMockBuilder(ProductPageSearchExpanderFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchQueryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->elasticaQueryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->boolQueryMock = $this->getMockBuilder(BoolQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->matchQueryMock = $this->getMockBuilder(MatchQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryExpanderPlugin = new StyleKeySearchQueryExpanderPlugin();
        $this->queryExpanderPlugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuerySuccess()
    {
        $this->searchQueryMock->expects($this->once())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($this->queryBuilderMock);

        $this->elasticaQueryMock->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->queryBuilderMock->expects($this->once(1))
            ->method('createMatchQuery')
            ->willReturn($this->matchQueryMock);

        $this->matchQueryMock->expects($this->once())
            ->method('setField')
            ->willReturn($this->matchQueryMock);

        $this->queryExpanderPlugin->expandQuery($this->searchQueryMock, [
            'style_key' => 'style_key',
        ]);
    }

    /**
     * @return void
     */
    public function testExpandQueryFailedMissingParameter()
    {
        $this->searchQueryMock->expects($this->never())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->queryExpanderPlugin->expandQuery($this->searchQueryMock, [
            'wrong_key' => 'style_key',
        ]);
    }
}
