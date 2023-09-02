<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento2\SecondLevelCache\Model\Cache\EntityKeyResolver;
use Magento2\SecondLevelCache\Model\Cache\Product as ProductCache;
use Magento2\SecondLevelCache\Model\Cache\EntityKeyResolverFactory;

class CleanProductCache implements ObserverInterface
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

    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();

        /** @var EntityKeyResolver $entityKeyResolver */
        $entityKeyResolver = $this->entityKeyResolverFactory->create();

        $entityKeyResolver->setField('id');
        $entityKeyResolver->setModelId($product->getEntityId());
        $entityKeyResolver->setSourceEntity($product);

        $this->productCache->cleanEntity($entityKeyResolver);
    }
}
