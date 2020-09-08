<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductAbstractMap;

use FondOfSpryker\Shared\ProductPageSearchExpander\ProductPageSearchExpanderConstants;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\PageMapTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearchExtension\Dependency\PageMapBuilderInterface;
use Spryker\Zed\ProductPageSearchExtension\Dependency\Plugin\ProductAbstractMapExpanderPluginInterface;

class ImageSetPageMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
{

    public function expandProductMap(PageMapTransfer $pageMapTransfer, PageMapBuilderInterface $pageMapBuilder, array $productData, LocaleTransfer $localeTransfer)
    {
        $pageMapBuilder->addSearchResultData($pageMapTransfer, ProductPageSearchExpanderConstants::IMAGE_SETS, $productData['image_sets']);

        return $pageMapTransfer;
    }
}
