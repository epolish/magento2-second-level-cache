<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Model\Cache;

use Magento2\SecondLevelCache\Model\Cache\Type\EntitySecondLevel;
use Magento\Framework\Model\AbstractModel;

class EntityKeyResolver
{
    private string $field;

    private string $modelId;

    private string $cacheTag;

    private AbstractModel $sourceEntity;

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(?string $field): void
    {
        $this->field = ($field ?: 'id');
    }

    public function getModelId(): string
    {
        return $this->modelId;
    }

    public function setModelId(string $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getCacheTag(): string
    {
        return $this->cacheTag;
    }

    public function setCacheTag(string $cacheTag): void
    {
        $this->cacheTag = mb_strtoupper($cacheTag);
    }

    public function getSourceEntity(): AbstractModel
    {
        return $this->sourceEntity;
    }

    public function setSourceEntity(AbstractModel $sourceEntity): void
    {
        $this->sourceEntity = $sourceEntity;
    }

    public function getCacheKey(): string
    {
        return EntitySecondLevel::TYPE_IDENTIFIER .
            "_{$this->getCacheTag()}_{$this->getField()}_{$this->getModelId()}";
    }

    public function getIdentityCacheTag(): string
    {
        $entity = $this->getSourceEntity();

        return EntitySecondLevel::TYPE_IDENTIFIER . "_{$this->getCacheTag()}_id_{$entity->getEntityId()}";
    }
}
