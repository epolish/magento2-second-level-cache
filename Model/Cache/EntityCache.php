<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache;

use Zend_Cache;
use Magento2\SecondLevelCache\Model\Cache\Type\EntitySecondLevel;

class EntityCache
{
    private EntitySecondLevel $cache;

    public function __construct(
        EntitySecondLevel $cache
    ) {
        $this->cache = $cache;
    }

    public function loadEntity(EntityCacheRecord $entityKeyResolver): bool
    {
        $data = $this->cache->load($entityKeyResolver->getCacheKey());

        if ($data) {
            $entityKeyResolver->getSourceEntity()->setData($data);
        }

        return !!$data;
    }

    public function saveEntity(EntityCacheRecord $entityKeyResolver, $tags = [], $lifeTime = null): bool
    {
        return $this->cache->save(
            $entityKeyResolver->getSourceEntity()->getData(),
            $entityKeyResolver->getCacheKey(),
            array_merge($tags, [EntitySecondLevel::CACHE_TAG, $entityKeyResolver->getIdentityCacheKey()]),
            $lifeTime
        );
    }

    public function removeEntity(EntityCacheRecord $entityKeyResolver): bool
    {
        return $this->cache->remove($entityKeyResolver->getCacheKey());
    }

    public function cleanEntity(EntityCacheRecord $entityKeyResolver): bool
    {
        return $this->cache->clean(Zend_Cache::CLEANING_MODE_ALL, [$entityKeyResolver->getIdentityCacheKey()]);
    }
}
