<?php
/**
 * Copyright © Panth Infotech. All rights reserved.
 */
declare(strict_types=1);

namespace Panth\CacheManager\Helper;

use Panth\Core\Helper\AbstractConfig;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractConfig
{
    public const XML_PATH_CACHE_MANAGER = 'panth_cachemanager/';

    /**
     * Get configuration value for CacheManager
     *
     * @param string $group
     * @param string $field
     * @param int|string|null $storeId
     * @return mixed
     */
    protected function getConfigValue(string $group, string $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CACHE_MANAGER . $group . '/' . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if CacheManager module is enabled
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->getConfigValue('general', 'enabled', $storeId);
    }

    // -------------------------------------------------------------------------
    // Full Page Cache
    // -------------------------------------------------------------------------

    /**
     * Get cache TTL in seconds
     *
     * @param int|string|null $storeId
     * @return int
     */
    public function getCacheTtl($storeId = null): int
    {
        return (int)$this->getConfigValue('full_page', 'ttl', $storeId) ?: 86400;
    }

    // -------------------------------------------------------------------------
    // Cache Warmup
    // -------------------------------------------------------------------------

    /**
     * Check if cache warmup is enabled
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function isWarmupEnabled($storeId = null): bool
    {
        return $this->isEnabled($storeId) && (bool)$this->getConfigValue('warmup', 'enabled', $storeId);
    }

    /**
     * Get list of page types to warm up
     *
     * @param int|string|null $storeId
     * @return array
     */
    public function getWarmupPages($storeId = null): array
    {
        $pages = $this->getConfigValue('warmup', 'warmup_pages', $storeId);
        return $pages ? explode(',', (string)$pages) : [];
    }

    /**
     * Get warmup cron schedule expression
     *
     * @param int|string|null $storeId
     * @return string
     */
    public function getWarmupSchedule($storeId = null): string
    {
        return (string)$this->getConfigValue('warmup', 'warmup_schedule', $storeId) ?: '0 */6 * * *';
    }

    /**
     * Get number of concurrent warmup requests
     *
     * @param int|string|null $storeId
     * @return int
     */
    public function getConcurrentRequests($storeId = null): int
    {
        return (int)$this->getConfigValue('warmup', 'concurrent_requests', $storeId) ?: 5;
    }

    // -------------------------------------------------------------------------
    // Cache Invalidation
    // -------------------------------------------------------------------------

    /**
     * Check if smart cache invalidation is enabled
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function isSmartInvalidationEnabled($storeId = null): bool
    {
        return $this->isEnabled($storeId)
            && (bool)$this->getConfigValue('invalidation', 'smart_invalidation', $storeId);
    }

    /**
     * Check if cache should be invalidated on product save
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function shouldInvalidateOnProductSave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_product_save', $storeId);
    }

    /**
     * Check if cache should be invalidated on category save
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function shouldInvalidateOnCategorySave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_category_save', $storeId);
    }

    /**
     * Check if cache should be invalidated on CMS page/block save
     *
     * @param int|string|null $storeId
     * @return bool
     */
    public function shouldInvalidateOnCmsSave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_cms_save', $storeId);
    }
}
