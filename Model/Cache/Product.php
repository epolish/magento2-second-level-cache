<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache;

class Product extends AbstractCache
{
    public function getCacheTag(): string
    {
        return 'product';
    }
}
