<?php
/**
 * Copyright © TheMageMaster. All rights reserved.
 * @author Muhammad Umar
 */

declare(strict_types=1);

namespace TheMageMaster\Sortby\Model\Rewrite\Catalog;

class Config
{
    public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $subject, array $result): array
    {
        $result['popularity'] = __('Most Reviewed');
        $result['rating_summary'] = __('Top Rated');

        return $result;
    }
}
