<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Match as MatchQuery;
use FondOfSpryker\Client\ProductPageSearchExpander\ProductPageSearchExpanderFactory;
use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ModelKeyAndStyleKeyQueryExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Client\Search\Model\Elasticsearch\Query\QueryBuilder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $queryBuilderMock;

    /**
     * @var \FondOfSpryker\Client\ProductPageSearchExpander\Plugin\Elasticsearch\QueryExpander\ModelKeyAndStyleKeyQueryExpanderPlugin
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

        $this->queryExpanderPlugin = new ModelKeyAndStyleKeyQueryExpanderPlugin();
        $this->queryExpanderPlugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuerySuccess()
    {
        $this->searchQueryMock->expects($this->exactly(2))
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects($this->exactly(2))
            ->method('createQueryBuilder')
            ->willReturn($this->queryBuilderMock);

        $this->elasticaQueryMock->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->queryBuilderMock->expects($this->exactly(2))
            ->method('createMatchQuery')
            ->willReturn($this->matchQueryMock);

        $this->matchQueryMock->expects($this->exactly(2))
            ->method('setField')
            ->willReturn($this->matchQueryMock);

        $this->queryExpanderPlugin->expandQuery($this->searchQueryMock, [
            ProductPageSearchExpanderConstants::MODEL_KEY => 'model_key',
            ProductPageSearchExpanderConstants::STYLE_KEY => 'style_key',
        ]);
    }
}
