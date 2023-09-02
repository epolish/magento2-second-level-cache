<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento2\SecondLevelCache\Model\Cache\Type\EntitySecondLevel;
use Magento\Framework\Cache\FrontendInterface;

abstract class AbstractCache implements CacheInterface
{
    private $cache;

    private $jsonSerializer;

    public function __construct(
        CacheInterface $cache,
        JsonSerializer $jsonSerializer
    ) {
        $this->cache = $cache;
        $this->jsonSerializer = $jsonSerializer;
    }

    public function loadEntity(EntityKeyResolver $entityKeyResolver): bool
    {
        $entityKeyResolver->setCacheTag($this->getCacheTag());

        $data = $this->cache->load($entityKeyResolver->getCacheKey());

        if ($data) {
            $entityKeyResolver->getSourceEntity()->setData($this->jsonSerializer->unserialize($data));
        }

        return !!$data;
    }

    public function saveEntity(EntityKeyResolver $entityKeyResolver, $tags = [], $lifeTime = null): bool
    {
        $entityKeyResolver->setCacheTag($this->getCacheTag());

        return $this->cache->save(
            $this->jsonSerializer->serialize($entityKeyResolver->getSourceEntity()->getData()),
            $entityKeyResolver->getCacheKey(),
            array_merge($tags, [EntitySecondLevel::CACHE_TAG, $entityKeyResolver->getIdentityCacheTag()]),
            $lifeTime
        );
    }

    public function removeEntity(EntityKeyResolver $entityKeyResolver): bool
    {
        $entityKeyResolver->setCacheTag($this->getCacheTag());

        return $this->cache->remove($entityKeyResolver->getCacheKey());
    }

    public function cleanEntity(EntityKeyResolver $entityKeyResolver): bool
    {
        $entityKeyResolver->setCacheTag($this->getCacheTag());

        return $this->cache->clean([$entityKeyResolver->getIdentityCacheTag()]);
    }

    public function load($identifier): string
    {
        return $this->cache->load($identifier);
    }

    public function save($data, $identifier, $tags = [], $lifeTime = null): bool
    {
        return $this->cache->save($data, $identifier, $tags, $lifeTime);
    }

    public function clean($tags = []): bool
    {
        return $this->cache->clean($tags);
    }

    public function remove($identifier): bool
    {
        return $this->cache->remove($identifier);
    }

    public function getFrontend(): FrontendInterface
    {
        return $this->cache->getFrontend();
    }

    abstract protected function getCacheTag(): string;
}
