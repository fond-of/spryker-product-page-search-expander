<?php

namespace FondOfSpryker\Client\ProductPageSearchExpander;

use FondOfSpryker\Client\ProductPageSearchExpander\Dependency\Client\ProductPageSearchExpanderToCatalogClientBridge;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

class ProductPageSearchExpanderDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_CATALOG = 'CLIENT_CATALOG';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container = $this->addCatalogSearchClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addCatalogSearchClient(Container $container): Container
    {
        $container[static::CLIENT_CATALOG] = function (Container $container) {
            return new ProductPageSearchExpanderToCatalogClientBridge(
                $container->getLocator()->catalog()->client()
            );
        };

        return $container;
    }
}
