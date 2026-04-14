# Panth Cache Manager -- User Guide

## Table of Contents

1. [Installation](#installation)
2. [General Settings](#general-settings)
3. [Full Page Cache](#full-page-cache)
4. [Cache Warmup](#cache-warmup)
5. [Cache Invalidation](#cache-invalidation)
6. [Warmup Log](#warmup-log)
7. [Troubleshooting](#troubleshooting)
8. [Support](#support)

---

## Installation

1. Upload or install the package via Composer:

   ```bash
   composer require mage2kishan/module-cachemanager
   ```

2. Enable the module and run setup:

   ```bash
   bin/magento module:enable Panth_CacheManager
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

3. Log in to the Magento Admin and navigate to **Stores > Configuration > Panth Extensions > Cache Manager**.

---

## General Settings

| Field                | Description                                      |
|----------------------|--------------------------------------------------|
| Enable Cache Manager | Master toggle for the entire module (Yes / No).  |

When disabled, neither smart invalidation nor cache warmup will run.

---

## Full Page Cache

| Field              | Description                                                        |
|--------------------|--------------------------------------------------------------------|
| Cache TTL (seconds)| Time-to-live for cached pages. Default: 86400 (24 hours).         |

The TTL field only appears when the module is enabled.

---

## Cache Warmup

| Field               | Description                                                                 |
|----------------------|-----------------------------------------------------------------------------|
| Enable Cache Warmup  | Turn automatic warmup on or off.                                           |
| Warmup Schedule      | Cron expression (default `0 */6 * * *` = every 6 hours).                  |
| Pages to Warm Up     | Multi-select: Home Page, Category Pages, Product Pages, CMS Pages.        |
| Concurrent Requests  | Number of parallel curl requests per batch (default 5).                    |

### How It Works

A cron job runs on the configured schedule. It collects URLs for the selected page types and sends HTTP GET requests in batches using `curl_multi`. Each request result (URL, HTTP status, response time, page type) is logged to the `panth_cache_warmup_log` database table.

---

## Cache Invalidation

| Field                          | Description                                             |
|--------------------------------|---------------------------------------------------------|
| Enable Smart Invalidation      | Master toggle for selective cache cleaning.             |
| Invalidate on Product Save     | Clean product cache tags when a product is saved.       |
| Invalidate on Category Save    | Clean category cache tags when a category is saved.     |
| Invalidate on CMS Save         | Clean CMS cache tags when a CMS page or block is saved. |

Smart invalidation cleans only the relevant cache tags rather than flushing the entire full-page cache.

---

## Warmup Log

Navigate to **Panth Extensions > Cache Manager > Warmup Log** in the admin sidebar to view a grid of all warmup requests.

The grid displays:

- **ID** -- Auto-increment log ID.
- **URL** -- The page URL that was warmed.
- **Page Type** -- home, category, product, or cms.
- **HTTP Status** -- Response code (200, 404, 500, etc.).
- **Status** -- success or failed.
- **Response Time (ms)** -- How long the request took.
- **Warmed At** -- Timestamp of the warmup request.

Use the built-in filters, sorting, and column controls to analyze results.

---

## Troubleshooting

| Symptom                          | Solution                                                              |
|----------------------------------|-----------------------------------------------------------------------|
| Warmup cron never runs           | Verify Magento cron is configured (`crontab -l`) and module is enabled. |
| All warmup requests fail         | Check server firewall, SSL certificates, and that the store URL is reachable from the server. |
| Smart invalidation not working   | Ensure both the module and smart invalidation toggles are set to Yes.  |
| No URLs collected for warmup     | Confirm the desired page types are selected in the Pages to Warm Up field. |

---

## Support

- **Email:** kishansavaliyakb@gmail.com
- **Website:** https://kishansavaliya.com
- **Company:** Panth Infotech
