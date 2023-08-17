<?php
declare(strict_types=1);

namespace Magento2\SecondLevelCache\Plugin;

use Closure;
use Magento\Catalog\Model\Product as Subject;
use Magento\Framework\App\CacheInterface;

class Product
{
    private $cache;

    public function __construct(
        CacheInterface $cache
    ) {
        $this->cache = $cache;
    }

    public function aroundLoad(Subject $product, Closure $proceed, $modelId, $field = null)
    {
        if ($data = $this->cache->load('PRODUCT_' . $modelId . ($field ?: ''))) {
            $product->setData(\json_decode($data, true));

            return;
        }

        /** @var Subject $product */
        $product = $proceed($modelId, $field);

        $this->cache->save(\json_encode($product->getData()), 'PRODUCT_' . $modelId . ($field ?: ''));
    }
}
