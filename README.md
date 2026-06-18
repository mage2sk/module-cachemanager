<!-- SEO Meta -->
<!--
  Title: Magento 2 Cache Manager Extension: Smart Cache Invalidation and Automated Warmup | Panth Infotech
  Description: Panth Cache Manager for Magento 2 adds smart cache invalidation on product, category, and CMS save events plus automated cron-driven cache warmup with concurrent curl_multi requests and an admin warmup log. Compatible with Magento 2.4.6 to 2.4.8, PHP 8.1 to 8.4, Hyva and Luma. Built by Top Rated Plus Magento developer Kishan Savaliya.
  Keywords: magento 2 cache manager, magento 2 cache warmup, magento 2 smart cache invalidation, magento 2 full page cache, magento 2 curl_multi warmup, magento 2 cron warmup, hyva cache warmup, magento 2 performance, panth cache manager, panth infotech, hire magento developer, top rated plus upwork, kishan savaliya magento
  Author: Kishan Savaliya (Panth Infotech)
  Canonical: https://kishansavaliya.com/magento-2-cachemanager.html
-->

# Magento 2 Cache Manager Extension: Smart Cache Invalidation and Automated Warmup (Hyva + Luma)

[![Magento 2.4.6 - 2.4.8](https://img.shields.io/badge/Magento-2.4.6%20--%202.4.8-orange?logo=magento&logoColor=white)](https://magento.com)
[![PHP 8.1 - 8.4](https://img.shields.io/badge/PHP-8.1%20--%208.4-blue?logo=php&logoColor=white)](https://php.net)
[![Hyva + Luma](https://img.shields.io/badge/Themes-Hyva%20%2B%20Luma-14b8a6)](https://www.hyva.io)
[![Live Demo & Details](https://img.shields.io/badge/Live%20Demo%20%26%20Details-magento--2--cachemanager-0D9488?style=flat)](https://kishansavaliya.com/magento-2-cachemanager.html)
[![Packagist](https://img.shields.io/badge/Packagist-mage2kishan%2Fmodule--cachemanager-orange?logo=packagist&logoColor=white)](https://packagist.org/packages/mage2kishan/module-cachemanager)
[![Upwork Top Rated Plus](https://img.shields.io/badge/Upwork-Top%20Rated%20Plus-14a800?logo=upwork&logoColor=white)](https://www.upwork.com/freelancers/~016dd1767321100e21)
[![Website](https://img.shields.io/badge/Website-kishansavaliya.com-0D9488)](https://kishansavaliya.com)

> **Keep your Magento 2 full-page cache hot without flushing everything.** Panth Cache Manager invalidates only the cache tags that changed when a product, category, or CMS page is saved. It also runs a scheduled warmup crawler that re-primes important pages in parallel using PHP `curl_multi`, and logs every request in an admin grid so you can see exactly what happened.

**Product page:** [kishansavaliya.com/magento-2-cachemanager.html](https://kishansavaliya.com/magento-2-cachemanager.html)

---

## Quick Answer

**What is Panth Cache Manager?** It is a Magento 2 extension that adds smart cache invalidation and automated cache warmup to your store. When you save a product, category, or CMS page, it clears only the affected cache tags instead of the whole FPC, and then a cron job re-crawls the important pages in parallel so real visitors always hit a warm cache.

**What does it add to my store?**

- **Smart cache invalidation** that clears only the relevant tags on product, category, or CMS save.
- **Automated cache warmup** via a cron job with configurable schedule and concurrency.
- A **warmup log grid** in the admin that shows every request, its HTTP status, and response time.
- A **configurable TTL** for full-page cached pages per store view.

**Which themes are supported?** Both **Hyva** and **Luma**. Cache Manager works at the cache layer, not the frontend, so it is theme-agnostic.

**What does it need?** Magento 2.4.6 to 2.4.8, PHP 8.1 to 8.4, the `ext-curl` PHP extension, and the free `mage2kishan/module-core` package.

---

## Need Custom Magento 2 Development?

> **Get a free quote for your project in 24 hours** for custom modules, Hyva themes, performance work, M1 to M2 migrations, and Adobe Commerce Cloud.

<p align="center">
  <a href="https://kishansavaliya.com/get-quote">
    <img src="https://img.shields.io/badge/Get%20a%20Free%20Quote%20%E2%86%92-Reply%20within%2024%20hours-DC2626?style=for-the-badge" alt="Get a Free Quote" />
  </a>
</p>

<table>
<tr>
<td width="50%" align="center">

### Kishan Savaliya
**Top Rated Plus on Upwork**

[![Hire on Upwork](https://img.shields.io/badge/Hire%20on%20Upwork-Top%20Rated%20Plus-14a800?style=for-the-badge&logo=upwork&logoColor=white)](https://www.upwork.com/freelancers/~016dd1767321100e21)

100% Job Success • 10+ Years Magento Experience
Adobe Certified • Hyva Specialist

</td>
<td width="50%" align="center">

### Panth Infotech Agency
**Magento Development Team**

[![Visit Agency](https://img.shields.io/badge/Visit%20Agency-Panth%20Infotech-14a800?style=for-the-badge&logo=upwork&logoColor=white)](https://www.upwork.com/agencies/1881421506131960778/)

Custom Modules • Theme Design • Migrations
Performance • SEO • Adobe Commerce Cloud

</td>
</tr>
</table>

**Visit our website:** [kishansavaliya.com](https://kishansavaliya.com) &nbsp;|&nbsp; **Get a quote:** [kishansavaliya.com/get-quote](https://kishansavaliya.com/get-quote)

---

## Table of Contents

- [Who Is It For](#who-is-it-for)
- [Key Features](#key-features)
- [Compatibility](#compatibility)
- [Installation](#installation)
- [Configuration](#configuration)
- [How It Works](#how-it-works)
- [Warmup Log](#warmup-log)
- [FAQ](#faq)
- [Support](#support)
- [About Panth Infotech](#about-panth-infotech)
- [Quick Links](#quick-links)

---

## Who Is It For

- **Merchants with active catalogs** who regularly update products, categories, and CMS pages and want those changes to go live without clearing the whole cache.
- **Stores seeing TTFB spikes** after content changes, where the default Magento cache flush is wiping too much and leaving visitors with cold pages.
- **Hyva storefronts** that need cache management that is completely frontend-agnostic and does not pull in any extra frontend dependencies.
- **Site owners who want visibility** into which pages were crawled, how fast they responded, and whether any warmup requests failed.
- **High-traffic stores** where keeping the FPC warm between content updates makes a measurable difference to page speed and Core Web Vitals.

---

## Key Features

### Smart Cache Invalidation
- **Product save** clears only the cache tags for that product, not the entire FPC.
- **Category save** clears the tags for that specific category.
- **CMS page or block save** clears only the affected CMS tags.
- **Per-entity toggles** let you enable or disable invalidation for each entity type independently.

### Automated Cache Warmup
- **Cron-driven warmup** runs on a configurable schedule (default: every 6 hours).
- **Concurrent requests** using PHP `curl_multi` so multiple pages are crawled in parallel.
- **Configurable concurrency** lets you tune the parallel batch size to your server capacity.
- **Selectable page types** covers home page, category pages, product pages, and CMS pages.
- **Store-aware URL collection** respects Magento scope and base URL per store view.

### Warmup Log Grid
- **Full admin grid** under Panth Extensions -> Cache Manager -> Warmup Log.
- **HTTP status code** per request (200, 404, 500, etc.) so failed pages are obvious.
- **Response time in milliseconds** to spot slow pages before customers do.
- **Page type, URL, and timestamp** columns with built-in filter and sort.

### Configurable Full Page Cache TTL
- **Custom TTL per store view**, with a default of 86400 seconds (24 hours).

### Quality
- **MEQP-style code** with constructor dependency injection only, no ObjectManager.
- **Observer and plugin architecture** with no core file edits.
- **Full Page Cache friendly** because warmup and invalidation work at the tag level.
- **Translation ready**: every label uses Magento's `__()` function.

---

## Compatibility

| Requirement | Versions Supported |
|---|---|
| Magento Open Source | 2.4.6, 2.4.7, 2.4.8 |
| Adobe Commerce | 2.4.6, 2.4.7, 2.4.8 |
| Adobe Commerce Cloud | 2.4.6 to 2.4.8 |
| PHP | 8.1.x, 8.2.x, 8.3.x, 8.4.x |
| MySQL | 8.0+ |
| MariaDB | 10.4+ |
| Hyva Theme | 1.0+ (fully supported) |
| Luma Theme | Native support |
| Required Dependency | `mage2kishan/module-core` (free) |
| PHP Extension | `ext-curl` |

---

## Installation

### Composer Installation (Recommended)

```bash
composer require mage2kishan/module-cachemanager
bin/magento module:enable Panth_Core Panth_CacheManager
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy -f
bin/magento cache:flush
```

### Manual Installation via ZIP

1. Download the latest release from [Packagist](https://packagist.org/packages/mage2kishan/module-cachemanager) or from the [product page](https://kishansavaliya.com/magento-2-cachemanager.html).
2. Extract it to `app/code/Panth/CacheManager/` in your Magento install.
3. Make sure `Panth_Core` is installed too (required dependency).
4. Run the commands above starting from `bin/magento module:enable`.

### Verify Installation

```bash
bin/magento module:status Panth_CacheManager
# Expected: Module is enabled
```

After install, open:
```
Admin -> Stores -> Configuration -> Panth Extensions -> Cache Manager
```

---

## Configuration

Go to **Stores -> Configuration -> Panth Extensions -> Cache Manager**.

| Setting | Group | Default | Description |
|---|---|---|---|
| Enable Cache Manager | General Settings | Yes | Master toggle. When set to No, neither invalidation nor warmup runs. |
| Cache TTL (seconds) | Full Page Cache | 86400 | Lifetime of cached pages in seconds. 86400 is 24 hours. |
| Enable Cache Warmup | Cache Warmup | Yes | Turn the automated warmup cron on or off. |
| Warmup Schedule (Cron) | Cache Warmup | `0 */6 * * *` | Cron expression for the warmup job. Default runs every 6 hours. |
| Pages to Warm Up | Cache Warmup | All | Multi-select: Home, Category, Product, CMS pages. |
| Concurrent Requests | Cache Warmup | 5 | Number of parallel `curl_multi` requests per warmup batch. |
| Enable Smart Invalidation | Cache Invalidation | Yes | Master toggle for selective cache tag clearing. |
| Invalidate on Product Save | Cache Invalidation | Yes | Clear product cache tags when a product is saved. |
| Invalidate on Category Save | Cache Invalidation | Yes | Clear category cache tags when a category is saved. |
| Invalidate on CMS Save | Cache Invalidation | Yes | Clear CMS tags when a CMS page or block is saved. |

---

## How It Works

### Smart Invalidation

1. A merchant saves a product, category, or CMS page in the admin.
2. A Magento observer catches the save event.
3. Cache Manager calculates the cache tags that belong to that specific entity.
4. Only those tags are cleaned from the full-page cache.
5. All other cached pages stay hot for real visitors.

### Automated Warmup

1. The Magento cron triggers the warmup job on the configured schedule.
2. Cache Manager collects URLs for the selected page types (home, categories, products, CMS) per store view.
3. URLs are split into batches based on the configured concurrency setting.
4. `curl_multi` sends each batch of requests in parallel.
5. Every response is written to the `panth_cache_warmup_log` table with HTTP status and response time.
6. The FPC is now primed, so the next real visitor hits a warm page.

---

## Warmup Log

Open **Admin -> Panth Extensions -> Cache Manager -> Warmup Log**.

The grid shows:

| Column | Description |
|---|---|
| ID | Auto-increment log ID |
| URL | The page that was warmed |
| Page Type | home, category, product, or cms |
| HTTP Status | 200, 404, 500, etc. |
| Status | success, failed, pending, or skipped |
| Response Time (ms) | Request duration in milliseconds |
| Warmed At | Timestamp of when the request was made |

Use the built-in column filters and sorting to find slow pages, failed requests, or check how often your warmup is running.

---

## FAQ

### Does Cache Manager work with Varnish?
Yes. Smart invalidation cleans Magento cache tags. Varnish honors these through the standard Magento Varnish integration. Warmup sends regular HTTP GET requests that Varnish caches like any other visitor would prime.

### Does it work with Hyva themes?
Yes. Cache Manager operates at the cache and observer layer, not the frontend, so it works with Hyva, Luma, or any other Magento 2 theme.

### Will the warmup crawl show up in my analytics?
Warmup sends HTTP GET requests from the server itself. If you want to exclude these from analytics, filter by IP address or User-Agent in your analytics tool.

### How much extra server load does the warmup add?
Very little. The default setting runs 5 concurrent requests every 6 hours. You can raise or lower the `Concurrent Requests` value to match your server capacity.

### Does it flush the full cache?
No. That is the main point of smart invalidation. Only the cache tags for the specific entity you saved are cleared. Unrelated pages stay cached.

### Can I warm custom page URLs?
The default warmup covers home, categories, products, and CMS. Custom URL providers can be added by extending the URL collector service through Magento DI.

### Does this replace Magento's built-in Full Page Cache?
No. Cache Manager sits on top of Magento's FPC. It invalidates more precisely and keeps the cache warm, but it uses the same underlying Magento FPC mechanism.

### Is the warmup log pruned automatically?
Not in the current version. The `panth_cache_warmup_log` table grows with every warmup cycle. For busy stores, truncate it periodically as needed.

### Does it require Panth Core?
Yes. `mage2kishan/module-core` is a free required dependency. Composer installs it for you automatically when you require this module.

### Is multi-store supported?
Yes. All settings respect Magento's scope hierarchy (default, website, store view), and the warmup collects URLs per store view based on its configured base URL.

---

## Support

| Channel | Contact |
|---|---|
| Product Page | [kishansavaliya.com/magento-2-cachemanager.html](https://kishansavaliya.com/magento-2-cachemanager.html) |
| Email | kishansavaliyakb@gmail.com |
| Website | [kishansavaliya.com](https://kishansavaliya.com) |
| WhatsApp | +91 84012 70422 |
| GitHub Issues | [github.com/mage2sk/module-cachemanager/issues](https://github.com/mage2sk/module-cachemanager/issues) |
| Upwork (Top Rated Plus) | [Hire Kishan Savaliya](https://www.upwork.com/freelancers/~016dd1767321100e21) |
| Upwork Agency | [Panth Infotech](https://www.upwork.com/agencies/1881421506131960778/) |

Response time: 1-2 business days.

### Need Custom Magento Development?

Looking for **custom Magento module development**, **Hyva theme work**, **store migrations**, or **performance tuning**? Get a free quote in 24 hours:

<p align="center">
  <a href="https://kishansavaliya.com/get-quote">
    <img src="https://img.shields.io/badge/%F0%9F%92%AC%20Get%20a%20Free%20Quote-kishansavaliya.com%2Fget--quote-DC2626?style=for-the-badge" alt="Get a Free Quote" />
  </a>
</p>

<p align="center">
  <a href="https://www.upwork.com/freelancers/~016dd1767321100e21">
    <img src="https://img.shields.io/badge/Hire%20Kishan-Top%20Rated%20Plus-14a800?style=for-the-badge&logo=upwork&logoColor=white" alt="Hire on Upwork" />
  </a>
  &nbsp;&nbsp;
  <a href="https://www.upwork.com/agencies/1881421506131960778/">
    <img src="https://img.shields.io/badge/Visit-Panth%20Infotech%20Agency-14a800?style=for-the-badge&logo=upwork&logoColor=white" alt="Visit Agency" />
  </a>
  &nbsp;&nbsp;
  <a href="https://kishansavaliya.com/magento-2-cachemanager.html">
    <img src="https://img.shields.io/badge/View%20Product%20Page-magento--2--cachemanager-0D9488?style=for-the-badge" alt="View Product Page" />
  </a>
</p>

---

## About Panth Infotech

Built and maintained by **Kishan Savaliya** ([kishansavaliya.com](https://kishansavaliya.com)), a **Top Rated Plus** Magento developer on Upwork with 10+ years of eCommerce experience.

**Panth Infotech** is a Magento 2 development agency that builds high quality, security focused extensions and themes for both Hyva and Luma storefronts. The extension suite covers SEO, performance, caching, checkout, product presentation, customer engagement, and store management, with each module built to MEQP standards and tested across Magento 2.4.6 to 2.4.8.

Browse the full extension catalog on our [Magento extensions page](https://kishansavaliya.com/magento-extensions.html) or on [Packagist](https://packagist.org/packages/mage2kishan/).

---

## Quick Links

| Resource | Link |
|---|---|
| **Product Page** | [magento-2-cachemanager.html](https://kishansavaliya.com/magento-2-cachemanager.html) |
| **Packagist** | [mage2kishan/module-cachemanager](https://packagist.org/packages/mage2kishan/module-cachemanager) |
| **GitHub** | [mage2sk/module-cachemanager](https://github.com/mage2sk/module-cachemanager) |
| **Website** | [kishansavaliya.com](https://kishansavaliya.com) |
| **Free Quote** | [kishansavaliya.com/get-quote](https://kishansavaliya.com/get-quote) |
| **Upwork (Top Rated Plus)** | [Hire Kishan Savaliya](https://www.upwork.com/freelancers/~016dd1767321100e21) |
| **Upwork Agency** | [Panth Infotech](https://www.upwork.com/agencies/1881421506131960778/) |
| **Email** | kishansavaliyakb@gmail.com |
| **WhatsApp** | +91 84012 70422 |

---

<p align="center">
  <strong>Ready to keep your Magento 2 store fast without flushing the whole cache?</strong><br/>
  <a href="https://kishansavaliya.com/magento-2-cachemanager.html">
    <img src="https://img.shields.io/badge/%F0%9F%9A%80%20See%20Cache%20Manager%20%E2%86%92-Product%20Page%20%26%20Details-DC2626?style=for-the-badge" alt="See Cache Manager" />
  </a>
</p>

---

**SEO Keywords:** magento 2 cache manager, magento 2 cache warmup, magento 2 smart cache invalidation, magento 2 full page cache, magento 2 FPC warmup, magento 2 curl_multi warmup, magento 2 concurrent cache warmup, magento 2 cron cache warmup, magento 2 warmup log, hyva cache warmup, magento 2 cache tags invalidation, magento 2 product save cache, magento 2 category save cache, magento 2 CMS save cache, magento 2 cache TTL, magento 2 performance optimization, magento 2 core web vitals, magento 2 TTFB improvement, panth cache manager, panth infotech, mage2kishan, magento 2.4.8 cache module, magento 2.4.7 cache warmup, PHP 8.4 magento cache, hire magento developer upwork, top rated plus magento developer, kishan savaliya magento, custom magento development, magento 2 hyva development, magento 2 luma cache, magento 2 varnish integration, magento 2 full page cache extension
