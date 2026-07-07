<?php
declare(strict_types=1);

namespace Panth\CacheManager\Test\Unit\Cron;

use Panth\CacheManager\Cron\WarmupCache;
use Panth\CacheManager\Helper\Data as ConfigHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Store;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory as CmsPageCollectionFactory;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class WarmupCacheTest extends TestCase
{
    private WarmupCache $cron;

    private $configHelperMock;

    private $storeManagerMock;

    private $categoryCollectionFactoryMock;

    private $productCollectionFactoryMock;

    private $cmsPageCollectionFactoryMock;

    private $loggerMock;

    private $storeMock;

    protected function setUp(): void
    {
        $this->configHelperMock = $this->createMock(ConfigHelper::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->categoryCollectionFactoryMock = $this->createMock(CategoryCollectionFactory::class);
        $this->productCollectionFactoryMock = $this->createMock(ProductCollectionFactory::class);
        $this->cmsPageCollectionFactoryMock = $this->createMock(CmsPageCollectionFactory::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->storeMock = $this->createMock(Store::class);

        $this->cron = new WarmupCache(
            $this->configHelperMock,
            $this->storeManagerMock,
            $this->categoryCollectionFactoryMock,
            $this->productCollectionFactoryMock,
            $this->cmsPageCollectionFactoryMock,
            $this->loggerMock
        );
    }

    public function testExecuteReturnEarlyWhenWarmupDisabled(): void
    {
        $this->configHelperMock->expects($this->once())
            ->method('isWarmupEnabled')
            ->willReturn(false);

        $this->configHelperMock->expects($this->never())
            ->method('getWarmupPages');

        $this->cron->execute();
    }

    public function testExecuteLogsInfoWhenNoUrls(): void
    {
        $this->configHelperMock->method('isWarmupEnabled')->willReturn(true);
        $this->configHelperMock->method('getWarmupPages')->willReturn([]);

        $this->storeManagerMock->method('getStore')->willReturn($this->storeMock);
        $this->storeMock->method('getBaseUrl')->willReturn('https://example.com/');

        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with('CacheManager: No URLs to warm up');

        $this->cron->execute();
    }

    public function testExecuteHandlesGeneralExceptionDuringWarmup(): void
    {
        $this->configHelperMock->expects($this->once())
            ->method('isWarmupEnabled')
            ->willReturn(true);

        $this->configHelperMock->expects($this->once())
            ->method('getWarmupPages')
            ->willThrowException(new \Exception('Config error'));

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($this->stringContains('CacheManager Cron Error'));

        $this->cron->execute();
    }
}
