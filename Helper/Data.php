<?php
declare(strict_types=1);

namespace Panth\CacheManager\Helper;

use Panth\Core\Helper\AbstractConfig;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractConfig
{
    public const XML_PATH_CACHE_MANAGER = 'panth_cachemanager/';

    protected function getConfigValue(string $group, string $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CACHE_MANAGER . $group . '/' . $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->getConfigValue('general', 'enabled', $storeId);
    }

    public function getCacheTtl($storeId = null): int
    {
        return (int)$this->getConfigValue('full_page', 'ttl', $storeId) ?: 86400;
    }

    public function isWarmupEnabled($storeId = null): bool
    {
        return $this->isEnabled($storeId) && (bool)$this->getConfigValue('warmup', 'enabled', $storeId);
    }

    public function getWarmupPages($storeId = null): array
    {
        $pages = $this->getConfigValue('warmup', 'warmup_pages', $storeId);
        return $pages ? explode(',', (string)$pages) : [];
    }

    public function getWarmupSchedule($storeId = null): string
    {
        return (string)$this->getConfigValue('warmup', 'warmup_schedule', $storeId) ?: '0 */6 * * *';
    }

    public function getConcurrentRequests($storeId = null): int
    {
        return (int)$this->getConfigValue('warmup', 'concurrent_requests', $storeId) ?: 5;
    }

    public function isSmartInvalidationEnabled($storeId = null): bool
    {
        return $this->isEnabled($storeId)
            && (bool)$this->getConfigValue('invalidation', 'smart_invalidation', $storeId);
    }

    public function shouldInvalidateOnProductSave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_product_save', $storeId);
    }

    public function shouldInvalidateOnCategorySave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_category_save', $storeId);
    }

    public function shouldInvalidateOnCmsSave($storeId = null): bool
    {
        return (bool)$this->getConfigValue('invalidation', 'invalidate_on_cms_save', $storeId);
    }
}
