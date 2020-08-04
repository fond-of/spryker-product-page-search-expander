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
class SizeMapExpanderPlugin extends AbstractPlugin implements ProductAbstractMapExpanderPluginInterface
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
        $size = (ctype_digit($productData[ProductPageSearchExpanderConstants::SIZE]) === true) ? $productData[ProductPageSearchExpanderConstants::SIZE] : 0;

        $pageMapBuilder->addIntegerSort($pageMapTransfer, ProductPageSearchExpanderConstants::SIZE, $size);
        $pageMapBuilder->addIntegerFacet($pageMapTransfer, ProductPageSearchExpanderConstants::SIZE, $size);

        if (isset($productData[ProductPageSearchExpanderConstants::SIZE])) {
            $pageMapTransfer->setSize($productData[ProductPageSearchExpanderConstants::SIZE]);
        }

        return $pageMapTransfer;
    }
}
