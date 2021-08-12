<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

class ModelProductDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    protected const KEY_MODEL = 'model';

    /**
     * @api
     *
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): void
    {
        $attributes = json_decode($productData['attributes'], true);
        if (array_key_exists(static::KEY_MODEL, $attributes)) {
            $productAbstractPageSearchTransfer->setModel($attributes['model']);
        }
    }
}
