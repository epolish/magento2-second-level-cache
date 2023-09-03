<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Plugin;

use Magento\Framework\App\Cache\Manager;

class SkipGeneralCacheClean
{
    public function beforeClean(Manager $manager, array $types): array
    {
        if (count($types) === 1 && $types[0] === 'entities_cache') {
            return [$types];
        }

        if (($key = array_search('entities_cache', $types)) !== false) {
            unset($types[$key]);
        }

        return [$types];
    }
}
