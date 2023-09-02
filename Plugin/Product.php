<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Plugin;

use Closure;
use Magento\Catalog\Model\Product as ProductModel;
use Magento2\SecondLevelCache\Model\Cache\Product as ProductCache;
use Magento2\SecondLevelCache\Model\Cache\EntityKeyResolver;
use Magento2\SecondLevelCache\Model\Cache\EntityKeyResolverFactory;

class Product
{
    private $productCache;

    private $entityKeyResolverFactory;

    public function __construct(
        ProductCache $productCache,
        EntityKeyResolverFactory $entityKeyResolverFactory
    ) {
        $this->productCache = $productCache;
        $this->entityKeyResolverFactory = $entityKeyResolverFactory;
    }

    public function aroundLoad(ProductModel $product, Closure $proceed, $modelId, $field = null)
    {
        /** @var EntityKeyResolver $entityKeyResolver */
        $entityKeyResolver = $this->entityKeyResolverFactory->create();

        $entityKeyResolver->setField($field);
        $entityKeyResolver->setModelId((string)$modelId);
        $entityKeyResolver->setSourceEntity($product);

        if ($this->productCache->loadEntity($entityKeyResolver)) {
            return $product;
        }

        $product = $proceed($modelId, $field);

        $entityKeyResolver->setSourceEntity($product);
        $this->productCache->saveEntity($entityKeyResolver);

        return $product;
    }
}
