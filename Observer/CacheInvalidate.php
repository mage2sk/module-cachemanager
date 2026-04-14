<?php
/**
 * Copyright © Panth Infotech. All rights reserved.
 */
declare(strict_types=1);

namespace Panth\CacheManager\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Panth\CacheManager\Helper\Data as ConfigHelper;
use Magento\Framework\App\CacheInterface;
use Psr\Log\LoggerInterface;

class CacheInvalidate implements ObserverInterface
{
    /**
     * @var ConfigHelper
     */
    private ConfigHelper $configHelper;

    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Map of event names to cache tags and config check methods
     */
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

    /**
     * @param ConfigHelper $configHelper
     * @param CacheInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(
        ConfigHelper $configHelper,
        CacheInterface $cache,
        LoggerInterface $logger
    ) {
        $this->configHelper = $configHelper;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * Smart cache invalidation based on entity changes
     *
     * @param Observer $observer
     * @return void
     */
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

            // Check per-entity toggle (e.g., shouldInvalidateOnProductSave)
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
