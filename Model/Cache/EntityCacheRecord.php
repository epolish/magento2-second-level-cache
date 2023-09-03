<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache;

use Magento2\SecondLevelCache\Model\Cache\Type\EntitySecondLevel;
use Magento\Framework\Model\AbstractModel;

class EntityCacheRecord
{
    private string $field;

    private string $modelId;

    private string $basicCacheTag;

    private string $idFieldName = 'entity_id';

    private AbstractModel $sourceEntity;

    public function __construct(
        AbstractModel $sourceEntity,
        ?string $modelId = null,
        ?string $field = null
    ) {
        $this->sourceEntity = $sourceEntity;
        $this->field = mb_strtoupper($field ?: $this->idFieldName);
        $this->basicCacheTag = mb_strtoupper($sourceEntity::ENTITY);
        $this->modelId = mb_strtoupper($modelId ?: $sourceEntity->getEntityId());
    }

    public function getSourceEntity(): AbstractModel
    {
        return $this->sourceEntity;
    }

    public function getCacheKey(): string
    {
        return EntitySecondLevel::TYPE_IDENTIFIER .
            "__{$this->basicCacheTag}__{$this->field}__{$this->modelId}";
    }

    public function getIdentityCacheKey(): string
    {
        return EntitySecondLevel::TYPE_IDENTIFIER .
            "__{$this->basicCacheTag}__{$this->idFieldName}__{$this->sourceEntity->getEntityId()}";
    }
}
