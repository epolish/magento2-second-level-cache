<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache\Type;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;

class EntitySecondLevel extends TagScope
{
    const TYPE_IDENTIFIER = 'entities_cache';

    const CACHE_TAG = 'ENTITIES_CACHE';

    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER),
            self::CACHE_TAG
        );
    }
}
