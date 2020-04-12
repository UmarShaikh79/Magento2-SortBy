<?php
/**
 * Copyright © TheMageMaster. All rights reserved.
 * @author Muhammad Umar
 */

declare(strict_types=1);

namespace TheMageMaster\Sortby\Block\Rewrite\Catalog\Product;

use Magento\Catalog\Model\Layer;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    protected function _getProductCollection(): AbstractCollection
    {
        if ($this->_productCollection === null) {
            $layer = $this->getLayer();
            /* @var $layer Layer */
            if ($this->getShowRootCategory()) {
                $this->setCategoryId($this->_storeManager->getStore()->getRootCategoryId());
            }

            // if this is a product view page
            if ($this->_coreRegistry->registry('product')) {
                // get collection of categories this product is associated with
                $categories = $this->_coreRegistry->registry('product')
                    ->getCategoryCollection()->setPage(1, 1)
                    ->load();
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $this->setCategoryId(current($categories->getIterator()));
                }
            }

            $origCategory = null;
            if ($this->getCategoryId()) {
                try {
                    $category = $this->categoryRepository->get($this->getCategoryId());
                } catch (NoSuchEntityException $e) {
                    $category = null;
                }

                if ($category) {
                    $origCategory = $layer->getCurrentCategory();
                    $layer->setCurrentCategory($category);
                }
            }
            $this->_productCollection = $layer->getProductCollection();

            $objectManager = ObjectManager::getInstance();
            /** @var StoreManagerInterface $manager */
            $_storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');

            $this->_productCollection->joinField(
                'rating_summary',
                'review_entity_summary',
                'rating_summary',
                'entity_pk_value=entity_id',
                array('entity_type'=>1, 'store_id'=> $_storeManager->getStore()->getId()),
                'left'
            );

            $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

            if ($origCategory) {
                $layer->setCurrentCategory($origCategory);
            }
        }

        return $this->_productCollection;
    }
}
