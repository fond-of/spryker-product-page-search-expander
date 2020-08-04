<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander;

use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToAvailabilityFacadeBridge;
use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToStoreFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductPageSearchExpanderDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_STORE = 'FACADE_STORE';
    public const FACADE_AVAILABILITY = 'FACADE_AVAILABILITY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addStoreFacade($container);
        $container = $this->addAvailabilityFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return new ProductPageSearchExpanderToStoreFacadeBridge(
                $container->getLocator()->store()->facade()
            );
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAvailabilityFacade(Container $container): Container
    {
        $container[static::FACADE_AVAILABILITY] = function (Container $container) {
            return new ProductPageSearchExpanderToAvailabilityFacadeBridge(
                $container->getLocator()->availability()->facade()
            );
        };

        return $container;
    }
}
