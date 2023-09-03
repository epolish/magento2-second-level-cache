<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Plugin;

use Magento\Framework\Model\AbstractModel;
use Magento2\SecondLevelCache\Model\Cache\EntityCache;
use Magento2\SecondLevelCache\Model\Cache\EntityCacheRecordFactory;

class RemoveEntityFromCache
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

    public function afterAfterSave(AbstractModel $entity, $result)
    {
        $this->entityCache->cleanEntity($this->entityCacheRecordFactory->create([
            'sourceEntity' => $entity
        ]));

        return $result;
    }
}
