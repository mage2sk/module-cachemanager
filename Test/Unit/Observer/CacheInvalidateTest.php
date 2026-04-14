<?php
/**
 * Copyright © Panth Infotech. All rights reserved.
 */
declare(strict_types=1);

namespace Panth\CacheManager\Test\Unit\Observer;

use Panth\CacheManager\Observer\CacheInvalidate;
use Panth\CacheManager\Helper\Data as ConfigHelper;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event;
use Magento\Framework\App\CacheInterface;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CacheInvalidateTest extends TestCase
{
    /**
     * @var CacheInvalidate
     */
    private CacheInvalidate $observer;

    /**
     * @var ConfigHelper|MockObject
     */
    private $configHelperMock;

    /**
     * @var CacheInterface|MockObject
     */
    private $cacheMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private $loggerMock;

    /**
     * @var Observer|MockObject
     */
    private $observerMock;

    /**
     * @var Event|MockObject
     */
    private $eventMock;

    /**
     * Set up test fixtures
     */
    protected function setUp(): void
    {
        $this->configHelperMock = $this->createMock(ConfigHelper::class);
        $this->cacheMock = $this->createMock(CacheInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->observerMock = $this->createMock(Observer::class);
        $this->eventMock = $this->createMock(Event::class);

        $this->observer = new CacheInvalidate(
            $this->configHelperMock,
            $this->cacheMock,
            $this->loggerMock
        );
    }

    /**
     * Test execute returns early when module is disabled
     *
     * @test
     */
    public function testExecuteReturnEarlyWhenModuleDisabled(): void
    {
        $this->configHelperMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(false);

        $this->observerMock->expects($this->never())
            ->method('getEvent');

        $this->cacheMock->expects($this->never())
            ->method('clean');

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute returns early when smart invalidation is disabled
     *
     * @test
     */
    public function testExecuteReturnEarlyWhenSmartInvalidationDisabled(): void
    {
        $this->configHelperMock->expects($this->once())
            ->method('isEnabled')
            ->willReturn(true);

        $this->configHelperMock->expects($this->once())
            ->method('isSmartInvalidationEnabled')
            ->willReturn(false);

        $this->observerMock->expects($this->never())
            ->method('getEvent');

        $this->cacheMock->expects($this->never())
            ->method('clean');

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute invalidates product cache when product save config is enabled
     *
     * @test
     */
    public function testExecuteInvalidatesProductCacheOnProductSave(): void
    {
        $eventName = 'catalog_product_save_after';
        $expectedTags = ['catalog_product'];

        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);
        $this->configHelperMock->expects($this->once())
            ->method('shouldInvalidateOnProductSave')
            ->willReturn(true);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn($eventName);

        $this->cacheMock->expects($this->once())
            ->method('clean')
            ->with($expectedTags);

        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with(
                'CacheManager: Smart invalidation triggered',
                ['event' => $eventName, 'tags' => $expectedTags]
            );

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute skips invalidation when per-entity toggle is off
     *
     * @test
     */
    public function testExecuteSkipsWhenEntityToggleIsOff(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);
        $this->configHelperMock->expects($this->once())
            ->method('shouldInvalidateOnProductSave')
            ->willReturn(false);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn('catalog_product_save_after');

        $this->cacheMock->expects($this->never())
            ->method('clean');

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute invalidates category cache on category save
     *
     * @test
     */
    public function testExecuteInvalidatesCategoryCacheOnCategorySave(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);
        $this->configHelperMock->expects($this->once())
            ->method('shouldInvalidateOnCategorySave')
            ->willReturn(true);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn('catalog_category_save_after');

        $this->cacheMock->expects($this->once())
            ->method('clean')
            ->with(['catalog_category']);

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute invalidates CMS cache on CMS page save
     *
     * @test
     */
    public function testExecuteInvalidatesCmsCacheOnCmsPageSave(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);
        $this->configHelperMock->expects($this->once())
            ->method('shouldInvalidateOnCmsSave')
            ->willReturn(true);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn('cms_page_save_after');

        $this->cacheMock->expects($this->once())
            ->method('clean')
            ->with(['cms_page']);

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute invalidates CMS cache on CMS block save
     *
     * @test
     */
    public function testExecuteInvalidatesCmsCacheOnCmsBlockSave(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);
        $this->configHelperMock->expects($this->once())
            ->method('shouldInvalidateOnCmsSave')
            ->willReturn(true);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn('cms_block_save_after');

        $this->cacheMock->expects($this->once())
            ->method('clean')
            ->with(['cms_block']);

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute does not clean cache for unknown events
     *
     * @test
     */
    public function testExecuteDoesNotCleanCacheForUnknownEvents(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);

        $this->observerMock->method('getEvent')->willReturn($this->eventMock);
        $this->eventMock->method('getName')->willReturn('some_unknown_event');

        $this->cacheMock->expects($this->never())
            ->method('clean');

        $this->observer->execute($this->observerMock);
    }

    /**
     * Test execute handles exception gracefully
     *
     * @test
     */
    public function testExecuteHandlesExceptionGracefully(): void
    {
        $this->configHelperMock->method('isEnabled')->willReturn(true);
        $this->configHelperMock->method('isSmartInvalidationEnabled')->willReturn(true);

        $this->observerMock->method('getEvent')
            ->willThrowException(new \Exception('Event error'));

        $this->cacheMock->expects($this->never())
            ->method('clean');

        $this->loggerMock->expects($this->once())
            ->method('error')
            ->with($this->stringContains('CacheManager Observer Error'));

        $this->observer->execute($this->observerMock);
    }
}
