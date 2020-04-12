<?php
/**
 * Copyright © TheMageMaster. All rights reserved.
 * @author Muhammad Umar
 */

declare(strict_types=1);

namespace TheMageMaster\Sortby\Plugin\Model\Rewrite\Catalog\Category\Attribute\Source;

class Sortby
{
    public function afterGetAllOptions(\Magento\Catalog\Model\Category\Attribute\Source\Sortby $subject, array $result)
    : array
    {
        $result[] = ['label' => __('Most Reviewed'), 'value' => 'popularity'];
        $result[] = ['label' => __('Top Rated'), 'value' => 'rating_summary'];

        return $result;
    }
}
