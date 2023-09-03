<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache\Type;

use Magento\Framework\App\Cache\Type\FrontendPool;
use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class EntitySecondLevel extends TagScope
{
    const CACHE_TAG = 'ENTITIES_CACHE';

    const TYPE_IDENTIFIER = 'entities_cache';

    private JsonSerializer $jsonSerializer;

    public function __construct(
        JsonSerializer $jsonSerializer,
        FrontendPool $cacheFrontendPool
    )
    {
        $this->jsonSerializer = $jsonSerializer;

        parent::__construct(
            $cacheFrontendPool->get(self::TYPE_IDENTIFIER)->_getFrontend(),
            self::CACHE_TAG
        );
    }

    public function load($identifier)
    {
        $data = parent::load($identifier);

        return $data ? $this->jsonSerializer->unserialize($data) : $data;
    }

    public function save($data, $identifier, array $tags = [], $lifeTime = null)
    {
        return parent::save($this->jsonSerializer->serialize($data), $identifier, $tags, $lifeTime);
    }
}
