<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Plugin;

use Closure;
use Magento\Framework\Model\AbstractModel;
use Magento2\SecondLevelCache\Model\Cache\EntityCache;
use Magento2\SecondLevelCache\Model\Cache\EntityCacheRecordFactory;

class PlaceEntityIntoCache
{
    private EntityCache $entityCache;

    private EntityCacheRecordFactory $entityCacheRecordFactory;

    public function __construct(
        EntityCache $entityCache,
        EntityCacheRecordFactory $entityCacheRecordFactory
    ) {
        $this->entityCache = $entityCache;
        $this->entityCacheRecordFactory = $entityCacheRecordFactory;
    }

    public function aroundLoad(AbstractModel $entity, Closure $proceed, $modelId, $field = null)
    {
        $isLoaded = $this->entityCache->loadEntity(
            $this->entityCacheRecordFactory->create([
                'sourceEntity' => $entity,
                'modelId' => (string)$modelId,
                'field' => $field,
            ])
        );

        if (!$isLoaded) {
            $entity = $proceed($modelId, $field);

            $this->entityCache->saveEntity(
                $this->entityCacheRecordFactory->create([
                    'sourceEntity' => $entity,
                    'modelId' => (string)$modelId,
                    'field' => $field,
                ])
            );
        }

        return $entity;
    }
}
