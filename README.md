# magento2-second-level-cache

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
