<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductAbstractMap;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

/**
 * @method \FondOfSpryker\Zed\ProductPageSearchExpander\Communication\ProductPageSearchExpanderCommunicationFactory getFactory()
 */
class IsSoldOutMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands and returns the provided PageMapTransfer objects data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PageMapTransfer $pageMapTransfer
     * @param \Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface $pageMapBuilder
     * @param array $productData
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\PageMapTransfer
     */
    public function expandProductMap(
        PageMapTransfer $pageMapTransfer,
        PageMapBuilderInterface $pageMapBuilder,
        array $productData,
        LocaleTransfer $localeTransfer
    ): PageMapTransfer {
        $soldOut = array_key_exists(ProductPageSearchExpanderConstants::IS_SOLD_OUT, $productData) ?? false;

        $pageMapTransfer->setIsSoldOut($soldOut);
        $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchExpanderConstants::IS_SOLD_OUT, $soldOut);

        return $pageMapTransfer;
    }
}
