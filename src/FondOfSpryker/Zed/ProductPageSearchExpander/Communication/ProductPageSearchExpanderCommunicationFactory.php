<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication;

use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToAvailabilityFacadeInterface;
use FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToStoreFacadeInterface;
use FondOfSpryker\Zed\ProductPageSearchExpander\ProductPageSearchExpanderDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class ProductPageSearchExpanderCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToStoreFacadeInterface
     */
    public function getStoreFacade(): ProductPageSearchExpanderToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductPageSearchExpanderDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade\ProductPageSearchExpanderToAvailabilityFacadeInterface
     */
    public function getAvailabilityFacade(): ProductPageSearchExpanderToAvailabilityFacadeInterface
    {
        return $this->getProvidedDependency(ProductPageSearchExpanderDependencyProvider::FACADE_AVAILABILITY);
    }
}
