<?php
declare(strict_types=1);

namespace Panth\CacheManager\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Panth\CacheManager\Helper\Data as ConfigHelper;
use Magento\Framework\App\CacheInterface;
use Psr\Log\LoggerInterface;

class CacheInvalidate implements ObserverInterface
{
    private ConfigHelper $configHelper;

    private CacheInterface $cache;

    private LoggerInterface $logger;

    private const EVENT_CONFIG = [
        'catalog_product_save_after' => [
            'tags' => ['catalog_product'],
            'config_method' => 'shouldInvalidateOnProductSave'
        ],
        'catalog_category_save_after' => [
            'tags' => ['catalog_category'],
            'config_method' => 'shouldInvalidateOnCategorySave'
        ],
        'cms_page_save_after' => [
            'tags' => ['cms_page'],
            'config_method' => 'shouldInvalidateOnCmsSave'
        ],
        'cms_block_save_after' => [
            'tags' => ['cms_block'],
            'config_method' => 'shouldInvalidateOnCmsSave'
        ]
    ];

    public function __construct(
        ConfigHelper $configHelper,
        CacheInterface $cache,
        LoggerInterface $logger
    ) {
        $this->configHelper = $configHelper;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        if (!$this->configHelper->isEnabled() || !$this->configHelper->isSmartInvalidationEnabled()) {
            return;
        }

        try {
            $eventName = $observer->getEvent()->getName();

            if (!isset(self::EVENT_CONFIG[$eventName])) {
                return;
            }

            $eventConfig = self::EVENT_CONFIG[$eventName];
            $configMethod = $eventConfig['config_method'];

            if (!$this->configHelper->$configMethod()) {
                return;
            }

            $tags = $eventConfig['tags'];
            $this->cache->clean($tags);

            $this->logger->info(
                'CacheManager: Smart invalidation triggered',
                ['event' => $eventName, 'tags' => $tags]
            );
        } catch (\Exception $e) {
            $this->logger->error('CacheManager Observer Error: ' . $e->getMessage());
        }
    }
}
