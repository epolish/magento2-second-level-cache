# magento2-second-level-cache

How to add an entity to cache (frontend area)

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Catalog\Model\Product">
        <plugin name="magento2SecondLevelCachePluginPlaceEntityIntoCache"
                type="Magento2\SecondLevelCache\Plugin\PlaceEntityIntoCache"/>
    </type>
</config>
```

How to add an entity's eviction from cache (adminhtml area)

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Catalog\Model\Product">
        <plugin name="magento2SecondLevelCachePluginRemoveEntityFromCache"
                type="Magento2\SecondLevelCache\Plugin\RemoveEntityFromCache"/>
    </type>
</config>
```

How to add a different redis instance for replication

```php
'cache' => [
    'frontend' => [
        ######PREVIOUS CACHES CONFIGS#####
        'entities_cache' => [
            'id_prefix' => '69d_',
            'backend' => 'Magento\\Framework\\Cache\\Backend\\Redis',
            'backend_options' => [
                'server' => 'redis',
                'database' => '5',##use unique value here 
                'port' => '6379',
                'password' => '',
                'compress_data' => '0',
                'compression_lib' => ''
            ]
        ]
],
'type' => [
    'entities_cache' => [
        'frontend' => 'entities_cache'
    ]
]
```
