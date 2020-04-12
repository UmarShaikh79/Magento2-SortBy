<?php
/**
 * Copyright © TheMageMaster. All rights reserved.
 * @author Muhammad Umar
 */

declare(strict_types=1);

namespace TheMageMaster\Sortby\Block\Rewrite\Catalog\Produssct\ProductList;

use Magento\Framework\Data\Collection;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{

    public function setCollection(Collection $collection): Toolbar
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        // we need to set pagination only if passed value integer and more that 0
        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            if (($this->getCurrentOrder()) == 'position') {
                $this->_collection->addAttributeToSort(
                    $this->getCurrentOrder(),
                    $this->getCurrentDirection()
                );
            } elseif ($this->getCurrentOrder() === 'popularity') {
                $this->_collection->getSelect()
                     ->joinLeft(
                            array('soi' => $collection->getResource()->getTable('sales_order_item')),
                             'e.entity_id = soi.product_id',
                             array('qty_ordered' => 'SUM(soi.qty_ordered)')
                         )
                     ->group('e.entity_id')
                     ->order('qty_ordered ' . $this->getCurrentDirection());
            } else {
                $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
            }
        }
        return $this;
    }
}
