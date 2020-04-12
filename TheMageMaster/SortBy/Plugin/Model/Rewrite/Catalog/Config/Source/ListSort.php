<?php
/**
 * Copyright © TheMageMaster. All rights reserved.
 * @author Muhammad Umar
 */

declare(strict_types=1);

namespace TheMageMaster\Sortby\Plugin\Model\Rewrite\Catalog\Config\Source;

class ListSort
{
    public function afterToOptionArray(\Magento\Catalog\Model\Config\Source\ListSort $subject, array $result): array
    {
        $result[] = ['label' => __('Most Reviewed'), 'value' => 'popularity'];
        $result[] = ['label' => __('Top Rated'), 'value' => 'rating_summary'];

        return $result;
    }
}
