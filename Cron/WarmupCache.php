<?php
/**
 * Copyright © Panth Infotech. All rights reserved.
 */
declare(strict_types=1);

namespace Panth\CacheManager\Cron;

use Panth\CacheManager\Helper\Data as ConfigHelper;
use Panth\CacheManager\Model\WarmupLogFactory;
use Panth\CacheManager\Model\ResourceModel\WarmupLog as WarmupLogResource;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as CmsPageCollectionFactory;
use Psr\Log\LoggerInterface;

class WarmupCache
{
    /**
     * @var ConfigHelper
     */
    private ConfigHelper $configHelper;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var CategoryCollectionFactory
     */
    private CategoryCollectionFactory $categoryCollectionFactory;

    /**
     * @var ProductCollectionFactory
     */
    private ProductCollectionFactory $productCollectionFactory;

    /**
     * @var CmsPageCollectionFactory
     */
    private CmsPageCollectionFactory $cmsPageCollectionFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;
    private WarmupLogFactory $warmupLogFactory;
    private WarmupLogResource $warmupLogResource;

    public function __construct(
        ConfigHelper $configHelper,
        StoreManagerInterface $storeManager,
        CategoryCollectionFactory $categoryCollectionFactory,
        ProductCollectionFactory $productCollectionFactory,
        CmsPageCollectionFactory $cmsPageCollectionFactory,
        LoggerInterface $logger,
        WarmupLogFactory $warmupLogFactory,
        WarmupLogResource $warmupLogResource
    ) {
        $this->configHelper = $configHelper;
        $this->storeManager = $storeManager;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->cmsPageCollectionFactory = $cmsPageCollectionFactory;
        $this->logger = $logger;
        $this->warmupLogFactory = $warmupLogFactory;
        $this->warmupLogResource = $warmupLogResource;
    }

    /**
     * Execute cache warmup via cron. Honors the warmup-enabled toggle and
     * swallows exceptions so a single failure can't break the cron group.
     *
     * @return void
     */
    public function execute(): void
    {
        if (!$this->configHelper->isWarmupEnabled()) {
            return;
        }

        try {
            $this->runWarmup();
        } catch (\Exception $e) {
            $this->logger->error('CacheManager Cron Error: ' . $e->getMessage());
        }
    }

    /**
     * Run a warmup pass synchronously and return per-URL results. Shared by
     * the cron and the `panth:cachemanager:warmup` CLI command. Bypasses
     * the warmup-enabled toggle on purpose — a CLI invocation is an explicit
     * action and shouldn't be silently skipped because the cron is off.
     *
     * Each result row is shaped:
     *   ['url' => string, 'page_type' => string, 'status' => 'success'|'failed',
     *    'http_code' => int, 'response_time_ms' => float, 'error' => string]
     *
     * @param callable|null $onResult Optional callback fired per URL as the
     *                                response arrives — useful for live CLI
     *                                progress reporting.
     * @return array<int, array<string, mixed>>
     */
    public function runWarmup(?callable $onResult = null): array
    {
        $urls = $this->collectUrls();
        if (empty($urls)) {
            $this->logger->info('CacheManager: No URLs to warm up');
            return [];
        }

        $concurrentRequests = max(1, $this->configHelper->getConcurrentRequests());
        $this->logger->info('CacheManager: Starting cache warmup', [
            'url_count' => count($urls),
            'concurrent' => $concurrentRequests
        ]);

        $results = $this->warmUpUrls($urls, $concurrentRequests, $onResult);

        $this->logger->info('CacheManager: Cache warmup completed', [
            'total_urls' => count($urls)
        ]);
        return $results;
    }

    /**
     * Collect all URLs to warm up based on configured page types
     *
     * @return array
     */
    private function collectUrls(): array
    {
        $pageTypes = $this->configHelper->getWarmupPages();
        $baseUrl = rtrim($this->storeManager->getStore()->getBaseUrl(), '/');
        $urls = [];

        foreach ($pageTypes as $type) {
            $type = trim($type);
            switch ($type) {
                case 'home':
                    $urls[] = $baseUrl . '/';
                    break;
                case 'catalog_category':
                    $urls = array_merge($urls, $this->getCategoryUrls());
                    break;
                case 'catalog_product':
                    $urls = array_merge($urls, $this->getProductUrls());
                    break;
                case 'cms':
                    $urls = array_merge($urls, $this->getCmsPageUrls());
                    break;
            }
        }

        return array_unique($urls);
    }

    /**
     * Get all active category URLs
     *
     * @return array
     */
    private function getCategoryUrls(): array
    {
        $urls = [];

        try {
            $collection = $this->categoryCollectionFactory->create();
            $collection->addAttributeToSelect('url_path')
                ->addAttributeToFilter('is_active', 1)
                ->addAttributeToFilter('level', ['gt' => 1]);

            $baseUrl = rtrim($this->storeManager->getStore()->getBaseUrl(), '/');

            foreach ($collection as $category) {
                $urlPath = $category->getUrlPath();
                if ($urlPath) {
                    $urls[] = $baseUrl . '/' . ltrim($urlPath, '/');
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('CacheManager: Failed to collect category URLs', [
                'error' => $e->getMessage()
            ]);
        }

        return $urls;
    }

    /**
     * Get all visible product URLs
     *
     * @return array
     */
    private function getProductUrls(): array
    {
        $urls = [];

        try {
            $collection = $this->productCollectionFactory->create();
            $collection->addAttributeToSelect('url_key')
                ->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
                ->addAttributeToFilter(
                    'visibility',
                    ['in' => [
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                    ]]
                );

            $baseUrl = rtrim($this->storeManager->getStore()->getBaseUrl(), '/');

            foreach ($collection as $product) {
                $urlKey = $product->getUrlKey();
                if ($urlKey) {
                    $urls[] = $baseUrl . '/' . ltrim($urlKey, '/') . '.html';
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('CacheManager: Failed to collect product URLs', [
                'error' => $e->getMessage()
            ]);
        }

        return $urls;
    }

    /**
     * Get all active CMS page URLs
     *
     * @return array
     */
    private function getCmsPageUrls(): array
    {
        $urls = [];

        try {
            $collection = $this->cmsPageCollectionFactory->create();
            $collection->addFieldToFilter('is_active', 1);

            $baseUrl = rtrim($this->storeManager->getStore()->getBaseUrl(), '/');

            foreach ($collection as $page) {
                $identifier = $page->getIdentifier();
                if ($identifier && $identifier !== 'no-route') {
                    $urls[] = $baseUrl . '/' . ltrim($identifier, '/');
                }
            }
        } catch (\Exception $e) {
            $this->logger->error('CacheManager: Failed to collect CMS page URLs', [
                'error' => $e->getMessage()
            ]);
        }

        return $urls;
    }

    /**
     * Warm up URLs using curl_multi for concurrent requests.
     *
     * @param array $urls
     * @param int $concurrentRequests
     * @param callable|null $onResult Optional per-URL callback — receives the
     *                                same row that's added to the return value,
     *                                so a CLI consumer can stream progress.
     * @return array<int, array<string, mixed>>
     */
    private function warmUpUrls(array $urls, int $concurrentRequests, ?callable $onResult = null): array
    {
        $chunks = array_chunk($urls, $concurrentRequests);
        $results = [];

        foreach ($chunks as $chunk) {
            $multiHandle = curl_multi_init();
            $curlHandles = [];

            foreach ($chunk as $url) {
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_USERAGENT => 'PanthCacheManager/1.0 (Warmup)',
                    CURLOPT_NOBODY => false,
                    CURLOPT_SSL_VERIFYPEER => true,
                ]);
                curl_multi_add_handle($multiHandle, $ch);
                $curlHandles[$url] = $ch;
            }

            $running = null;
            do {
                curl_multi_exec($multiHandle, $running);
                if ($running > 0) {
                    curl_multi_select($multiHandle, 1.0);
                }
            } while ($running > 0);

            foreach ($curlHandles as $url => $ch) {
                $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $totalTime = round(curl_getinfo($ch, CURLINFO_TOTAL_TIME) * 1000, 2);
                $error = (string) curl_error($ch);

                $status = ($error !== '' || $httpCode >= 400) ? 'failed' : 'success';
                $pageType = $this->guessPageType($url);

                $row = [
                    'url' => $url,
                    'page_type' => $pageType,
                    'status' => $status,
                    'http_code' => $httpCode,
                    'response_time_ms' => $totalTime,
                    'error' => $error,
                ];
                $results[] = $row;

                try {
                    $log = $this->warmupLogFactory->create();
                    $log->setData([
                        'url' => $url,
                        'page_type' => $pageType,
                        'http_status' => $httpCode,
                        'status' => $status,
                        'response_time' => $totalTime,
                    ]);
                    $this->warmupLogResource->save($log);
                } catch (\Exception) {
                    // Silent — don't break warmup if logging fails
                }

                if ($onResult !== null) {
                    $onResult($row);
                }

                curl_multi_remove_handle($multiHandle, $ch);
                curl_close($ch);
            }

            curl_multi_close($multiHandle);
        }
        return $results;
    }

    /**
     * Guess page type from URL path
     */
    private function guessPageType(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '/';
        $path = trim($path, '/');

        if ($path === '' || $path === 'index.php') {
            return 'home';
        }
        if (preg_match('/\.html$/', $path) && strpos($path, '/') !== false) {
            return 'product';
        }
        if (preg_match('/\.html$/', $path)) {
            return 'category';
        }
        return 'cms';
    }
}
