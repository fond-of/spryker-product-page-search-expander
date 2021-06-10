<?php

namespace FondOfSpryker\Zed\ProductPageSearchExpander\Communication\Plugin\ProductPageSearch\Elasticsearch\ProductPageData;

use ArrayObject;
use Exception;
use Generated\Shared\Transfer\ProductPageSearchImageSetsTransfer;
use Generated\Shared\Transfer\ProductPageSearchImageTransfer;
use Generated\Shared\Transfer\ProductPageSearchTransfer;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductPageSearch\Dependency\Plugin\ProductPageDataExpanderInterface;

/**
 * @method \Spryker\Zed\ProductPageSearch\Persistence\ProductPageSearchQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductPageSearch\Communication\ProductPageSearchCommunicationFactory getFactory()
 */
class ImageSetDataExpanderPlugin extends AbstractPlugin implements ProductPageDataExpanderInterface
{
    use LoggerTrait;

    /**
     * Specification:
     * - Expands the provided ProductAbstractPageSearch transfer object's data by reference.
     *
     * @api
     *
     * @param array $productData
     * @param \Generated\Shared\Transfer\ProductPageSearchTransfer $productAbstractPageSearchTransfer
     *
     * @return void
     */
    public function expandProductPageData(array $productData, ProductPageSearchTransfer $productAbstractPageSearchTransfer): void
    {
        try {
            $imageSets = $this->generateImagesSets(
                $productData['PRODUCT_ABSTRACT_PAGE_LOAD_DATA']['images'][$productData['fk_locale']]
            );

            $productAbstractPageSearchTransfer->setImageSets($imageSets);
        } catch (Exception $exception) {
            $this->getLogger()->notice(
                sprintf('No images for abstract product with id: %s', $productData['fk_product_abstract'])
            );
        }
    }

    /**
     * @param array $images
     *
     * @return \ArrayObject
     */
    protected function generateImagesSets(array $images): ArrayObject
    {
        $imageSets = new ArrayObject();

        if (count($images) < 1) {
            return $imageSets;
        }

        usort($images, static function (SpyProductImageSet $a, SpyProductImageSet $b) {
            if ($a->getIdProductImageSet() == $b->getIdProductImageSet()) {
                return 0;
            }

            return ($a->getIdProductImageSet() < $b->getIdProductImageSet()) ? -1 : 1;
        });

        foreach ($images as $imageSet) {
            $imageSetTransfer = new ProductPageSearchImageSetsTransfer();
            $imageSetTransfer->setName($imageSet->getName());

            $productImagesCollection = $imageSet->getSpyProductImageSetToProductImages();

            foreach ($productImagesCollection->getData() as $image) {
                $spyImage = $image->getSpyProductImage();

                $imageSetTransfer->addImage(
                    (new ProductPageSearchImageTransfer())
                        ->setExternalUrlLarge($spyImage->getExternalUrlLarge())
                        ->setExternalUrlSmall($spyImage->getExternalUrlSmall())
                        ->setIdProductImage($spyImage->getIdProductImage())
                        ->setSortOrder($image->getSortOrder())
                );
            }

            $imageSets[] = $imageSetTransfer;
        }

        return $imageSets;
    }
}
