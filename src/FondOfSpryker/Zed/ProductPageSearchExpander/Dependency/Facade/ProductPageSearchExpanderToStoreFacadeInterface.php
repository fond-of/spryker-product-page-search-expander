<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ProductPageSearchExpanderToStoreFacadeInterface
{
    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer|null
     */
    public function findStoreByName(string $storeName): ?StoreTransfer;
}
