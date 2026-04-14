# Panth Cache Manager for Magento 2

Smart cache invalidation on entity save and automated cache warmup with concurrent requests for Magento 2 / Hyva stores.

## Features

- **Smart Cache Invalidation** -- Selectively invalidate cache entries when products, categories, or CMS pages/blocks are saved instead of flushing the entire cache.
- **Automated Cache Warmup** -- Cron-based warmup that crawls home, category, product, and CMS pages to keep the full-page cache hot.
- **Concurrent Requests** -- Uses `curl_multi` to warm multiple pages in parallel, with a configurable concurrency level.
- **Warmup Log Grid** -- Admin UI listing that records every warmup request with HTTP status, response time, and page type.
- **Configurable TTL** -- Set a custom full-page-cache time-to-live per store view.

## Requirements

- Magento 2.4.6 or later (Adobe Commerce / Magento Open Source)
- PHP 8.1 or later
- Panth Core module (`mage2kishan/module-core ^1.0`)
- ext-curl

## Installation

```bash
composer require mage2kishan/module-cachemanager
bin/magento module:enable Panth_CacheManager
bin/magento setup:upgrade
bin/magento cache:flush
```

## Configuration

Navigate to **Stores > Configuration > Panth Extensions > Cache Manager** to configure:

1. **General** -- Enable / disable the module.
2. **Full Page Cache** -- Set the cache TTL in seconds.
3. **Cache Warmup** -- Enable warmup, choose page types, set cron schedule, and concurrency.
4. **Cache Invalidation** -- Toggle smart invalidation per entity type (product, category, CMS).

## Support

- **Email:** kishansavaliyakb@gmail.com
- **Website:** https://kishansavaliya.com

## License

Proprietary -- see LICENSE.txt.

Copyright (c) Panth Infotech. All rights reserved.
