<!-- SEO Meta -->
<!--
  Title: Panth Cache Manager for Magento 2 - Smart Cache Invalidation & Automated Warmup | Panth Infotech
  Description: Panth Cache Manager for Magento 2 delivers smart cache invalidation on entity save plus automated full-page cache warmup with concurrent curl_multi requests and a warmup log. Compatible with Magento 2.4.6 - 2.4.8, PHP 8.1 - 8.4, Hyva and Luma themes. Built by Top Rated Plus Magento developer Kishan Savaliya.
  Keywords: magento 2 cache manager, magento 2 cache warmup, magento 2 smart cache invalidation, magento 2 full page cache, magento 2 curl_multi warmup, magento 2 cron warmup, hyva cache warmup, magento 2 performance, panth cache manager, panth infotech, hire magento developer, top rated plus upwork
  Author: Kishan Savaliya (Panth Infotech)
  Canonical: https://github.com/mage2sk/module-cachemanager
-->

# Panth Cache Manager for Magento 2 — Smart Cache Invalidation & Automated Warmup with Concurrent Requests

[![Visitors](https://visitor-badge.laobi.icu/badge?page_id=mage2sk.module-cachemanager&left_color=gray&right_color=0d9488&left_text=Visitors)](https://github.com/mage2sk/module-cachemanager)
[![Magento 2.4.6 - 2.4.8](https://img.shields.io/badge/Magento-2.4.6%20--%202.4.8-orange?logo=magento&logoColor=white)](https://magento.com)
[![PHP 8.1 - 8.4](https://img.shields.io/badge/PHP-8.1%20--%208.4-blue?logo=php&logoColor=white)](https://php.net)
[![License Proprietary](https://img.shields.io/badge/License-Proprietary-blue)]()
[![Packagist](https://img.shields.io/badge/Packagist-mage2kishan%2Fmodule--cachemanager-orange?logo=packagist&logoColor=white)](https://packagist.org/packages/mage2kishan/module-cachemanager)
[![Upwork Top Rated Plus](https://img.shields.io/badge/Upwork-Top%20Rated%20Plus-14a800?logo=upwork&logoColor=white)](https://www.upwork.com/freelancers/~016dd1767321100e21)
[![Panth Infotech Agency](https://img.shields.io/badge/Agency-Panth%20Infotech-14a800?logo=upwork&logoColor=white)](https://www.upwork.com/agencies/1881421506131960778/)
[![Website](https://img.shields.io/badge/Website-kishansavaliya.com-0D9488)](https://kishansavaliya.com)
[![Get a Quote](https://img.shields.io/badge/Get%20a%20Quote-Free%20Estimate-DC2626)](https://kishansavaliya.com/get-quote)

> **Keep your Magento 2 full-page cache hot and your store fast** — smart cache invalidation on product, category, and CMS save events, plus automated cron-driven warmup using concurrent `curl_multi` requests, with a full admin warmup log grid for visibility.

**Panth Cache Manager** is a production-grade cache optimization extension for Magento 2 and Hyva storefronts. Instead of flushing the entire full-page cache whenever a merchant edits a single product, Cache Manager invalidates only the tags that actually changed. On top of that, it runs a scheduled warmup crawler that re-primes the most important pages — home, categories, products, and CMS — in parallel batches, so real customers never hit a cold cache. Every warmup request is logged in an admin grid with HTTP status and response time, so you can see exactly what is happening.

Built to MEQP standards and compatible with Magento 2.4.6 — 2.4.8 on PHP 8.1 — 8.4, Cache Manager is part of the Panth Infotech extension suite and integrates cleanly with Hyva and Luma themes.

---

## 🚀 Need Custom Magento 2 Development?

> **Get a free quote for your project in 24 hours** — custom modules, Hyva themes, performance optimization, M1→M2 migrations, and Adobe Commerce Cloud.

<p align="center">
  <a href="https://kishansavaliya.com/get-quote">
    <img src="https://img.shields.io/badge/Get%20a%20Free%20Quote%20%E2%86%92-Reply%20within%2024%20hours-DC2626?style=for-the-badge" alt="Get a Free Quote" />
  </a>
</p>

<table>
<tr>
<td width="50%" align="center">

### 🏆 Kishan Savaliya
**Top Rated Plus on Upwork**

[![Hire on Upwork](https://img.shields.io/badge/Hire%20on%20Upwork-Top%20Rated%20Plus-14a800?style=for-the-badge&logo=upwork&logoColor=white)](https://www.upwork.com/freelancers/~016dd1767321100e21)

100% Job Success • 10+ Years Magento Experience
Adobe Certified • Hyva Specialist

</td>
<td width="50%" align="center">

### 🏢 Panth Infotech Agency
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

- [Why Panth Cache Manager](#why-panth-cache-manager)
- [Key Features](#key-features)
- [How It Works](#how-it-works)
- [Compatibility](#compatibility)
- [Installation](#installation)
- [Configuration](#configuration)
- [Warmup Log](#warmup-log)
- [Troubleshooting](#troubleshooting)
- [FAQ](#faq)
- [Support](#support)
- [About Panth Infotech](#about-panth-infotech)
- [Quick Links](#quick-links)

---

## Why Panth Cache Manager

Default Magento 2 cache handling is aggressive: saving a single product can blow away large portions of the full-page cache, forcing the very next visitor to wait for a cold render. On larger catalogs this shows up as intermittent TTFB spikes and poor Core Web Vitals.

**Panth Cache Manager fixes this in two ways:**

1. **Smart invalidation** — only the relevant cache tags are cleared on entity save, so unrelated pages stay hot.
2. **Automated warmup** — a cron job re-crawls the important pages in parallel, so even when cache does expire, the first real customer hits a warm page.

The result is consistently fast page loads, better Core Web Vitals, and less server load.

---

## Key Features

### Smart Cache Invalidation

- **Product save** — clears only the affected product's cache tags (not the entire FPC)
- **Category save** — clears the specific category tags
- **CMS save** — clears only the affected page/block tags
- **Per-entity toggles** — enable or disable invalidation per entity type

### Automated Cache Warmup

- **Cron-driven** — runs on a configurable schedule (default every 6 hours)
- **Concurrent requests** — uses PHP `curl_multi` to send N requests in parallel
- **Configurable concurrency** — tune parallel batch size to your server capacity
- **Selectable page types** — Home, Category pages, Product pages, CMS pages
- **Store-aware** — respects Magento scope and base URL

### Warmup Log Grid

- **Full admin grid** — every warmup request recorded
- **HTTP status** — 200, 404, 500, etc.
- **Response time (ms)** — diagnose slow pages at a glance
- **Page type, URL, timestamp** — filter, sort, and export

### Configurable Full Page Cache TTL

- Custom TTL per store view
- Default: 86400 seconds (24 hours)

### Quality & Compatibility

- **MEQP compliant** — passes Adobe's Magento Extension Quality Program
- **Hyva and Luma compatible** — works with any frontend theme
- **No core hacks** — pure observer and plugin architecture
- **Composer-installable** — no manual file copying

---

## How It Works

### Smart Invalidation Flow

```
Admin saves product/category/CMS
        ↓
Observer catches save event
        ↓
Cache Manager computes affected tags
        ↓
Only those tags are cleaned
        ↓
Unrelated pages remain cached
```

### Warmup Flow

```
Cron triggers (default: every 6 hours)
        ↓
Collect URLs (home, categories, products, CMS)
        ↓
Split into batches of N (configurable concurrency)
        ↓
curl_multi sends batch in parallel
        ↓
Each response logged to panth_cache_warmup_log
        ↓
FPC is now primed for real visitors
```

---

## Compatibility

| Requirement | Versions Supported |
|---|---|
| Magento Open Source | 2.4.6, 2.4.7, 2.4.8 |
| Adobe Commerce | 2.4.6, 2.4.7, 2.4.8 |
| Adobe Commerce Cloud | 2.4.6 — 2.4.8 |
| PHP | 8.1.x, 8.2.x, 8.3.x, 8.4.x |
| MySQL | 8.0+ |
| MariaDB | 10.4+ |
| Hyva Theme | 1.0+ (fully supported) |
| Luma Theme | Native support |
| Required Dependency | `mage2kishan/module-core` ^1.0 |
| PHP Extension | `ext-curl` |

Tested on Magento 2.4.8-p4 (PHP 8.4), 2.4.7 (PHP 8.3), and 2.4.6 (PHP 8.2).

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

1. Download the release ZIP from [Packagist](https://packagist.org/packages/mage2kishan/module-cachemanager) or [GitHub](https://github.com/mage2sk/module-cachemanager).
2. Extract to `app/code/Panth/CacheManager/`.
3. Ensure `Panth_Core` is also installed at `app/code/Panth/Core/`.
4. Run the commands above from `bin/magento module:enable` onward.

### Verify Installation

```bash
bin/magento module:status Panth_CacheManager
# Expected: Module is enabled
```

Then visit:
```
Admin → Stores → Configuration → Panth Extensions → Cache Manager
```

---

## Configuration

All settings live at **Stores → Configuration → Panth Extensions → Cache Manager**.

### General

| Setting | Default | Description |
|---|---|---|
| Enable Cache Manager | Yes | Master toggle. When No, neither invalidation nor warmup runs. |

### Full Page Cache

| Setting | Default | Description |
|---|---|---|
| Cache TTL (seconds) | 86400 | Lifetime of cached pages. 24 hours by default. |

### Cache Warmup

| Setting | Default | Description |
|---|---|---|
| Enable Cache Warmup | Yes | Turn automatic warmup on/off. |
| Warmup Schedule | `0 */6 * * *` | Cron expression — every 6 hours by default. |
| Pages to Warm Up | All | Multi-select: Home, Category, Product, CMS pages. |
| Concurrent Requests | 5 | Parallel `curl_multi` requests per batch. |

### Cache Invalidation

| Setting | Default | Description |
|---|---|---|
| Enable Smart Invalidation | Yes | Master toggle for selective cache cleaning. |
| Invalidate on Product Save | Yes | Clean product cache tags on product save. |
| Invalidate on Category Save | Yes | Clean category cache tags on category save. |
| Invalidate on CMS Save | Yes | Clean CMS tags on page or block save. |

---

## Warmup Log

Navigate to **Panth Extensions → Cache Manager → Warmup Log** in the admin sidebar.

The grid shows:

| Column | Description |
|---|---|
| ID | Auto-increment log ID |
| URL | The page that was warmed |
| Page Type | home, category, product, cms |
| HTTP Status | 200, 404, 500, etc. |
| Status | success or failed |
| Response Time (ms) | Request duration |
| Warmed At | Timestamp |

Use built-in filters and sorting to find slow pages, failed requests, or audit warmup frequency.

---

## Troubleshooting

| Issue | Cause | Resolution |
|---|---|---|
| Warmup cron never runs | Magento cron not configured | Verify `bin/magento cron:run` is scheduled in system crontab |
| All warmup requests fail | Server cannot reach its own URL | Check firewall, SSL, and base URL reachability from the server |
| Smart invalidation has no effect | Master or per-entity toggle off | Set both `Enable Smart Invalidation` and the entity toggle to Yes |
| No URLs collected | No page types selected | Pick at least one page type in `Pages to Warm Up` |
| Warmup too slow | Concurrency too low | Raise `Concurrent Requests` (test gradually — 5, 10, 20) |
| Warmup overloads server | Concurrency too high | Lower `Concurrent Requests` and/or schedule off-peak |

---

## FAQ

### Does Cache Manager work with Varnish?

Yes. Smart invalidation cleans Magento cache tags which Varnish honors via the standard Magento Varnish integration. Warmup simply issues HTTP GET requests, which Varnish caches like any other visitor.

### Does it work with Hyva?

Yes. Cache Manager operates at the cache layer, not the frontend, so it is theme-agnostic. It fully supports Hyva and Luma.

### Will warmup hit my analytics?

Warmup sends ordinary HTTP GET requests from the server. If you want to exclude warmup traffic, filter by User-Agent or IP in your analytics tool. You can customize the User-Agent via a plugin on the warmup service if needed.

### How much server load does warmup add?

Warmup runs on cron, not on every request. Typical concurrency of 5 parallel requests every 6 hours is negligible. Tune `Concurrent Requests` for your infrastructure.

### Does it flush the full cache?

No. That is the point. Cache Manager invalidates only the tags for the saved entity. Unrelated pages remain cached.

### Can I warm custom URLs?

The default warmup covers home, categories, products, and CMS. Custom URL providers can be added via DI by extending the URL collector service.

### Does this replace Magento's default FPC?

No. Cache Manager sits on top of Magento's Full Page Cache — it invalidates smarter and keeps it warm.

### Is the warmup log pruned automatically?

The log grows with every warmup cycle. For large stores, consider adding a periodic cleanup cron (roadmap) or truncate `panth_cache_warmup_log` manually as needed.

### Does it require Panth Core?

Yes. `mage2kishan/module-core` is a free, required dependency and is pulled in automatically by Composer.

### Is multi-store supported?

Yes. All settings respect Magento's scope hierarchy (default → website → store view), and warmup collects URLs per store view.

---

## Support

| Channel | Contact |
|---|---|
| Email | kishansavaliyakb@gmail.com |
| Website | [kishansavaliya.com](https://kishansavaliya.com) |
| WhatsApp | +91 84012 70422 |
| GitHub Issues | [github.com/mage2sk/module-cachemanager/issues](https://github.com/mage2sk/module-cachemanager/issues) |
| Upwork (Top Rated Plus) | [Hire Kishan Savaliya](https://www.upwork.com/freelancers/~016dd1767321100e21) |
| Upwork Agency | [Panth Infotech](https://www.upwork.com/agencies/1881421506131960778/) |

Response time: 1-2 business days.

### 💼 Need Custom Magento Development?

Looking for **custom Magento module development**, **Hyva theme customization**, **store migrations**, or **performance optimization**? Get a free quote in 24 hours:

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
  <a href="https://kishansavaliya.com">
    <img src="https://img.shields.io/badge/Visit%20Website-kishansavaliya.com-0D9488?style=for-the-badge" alt="Visit Website" />
  </a>
</p>

---

## License

Proprietary — see `LICENSE.txt`. Copyright © Panth Infotech. All rights reserved.

---

## About Panth Infotech

Built and maintained by **Kishan Savaliya** — [kishansavaliya.com](https://kishansavaliya.com) — a **Top Rated Plus** Magento developer on Upwork with 10+ years of eCommerce experience.

**Panth Infotech** is a Magento 2 development agency specializing in high-quality, security-focused extensions and themes for both Hyva and Luma storefronts. Our extension suite covers SEO, performance, caching, checkout, product presentation, customer engagement, and store management — over 34 modules built to MEQP standards and tested across Magento 2.4.4 to 2.4.8.

Browse the full extension catalog on the [Adobe Commerce Marketplace](https://commercemarketplace.adobe.com) or [Packagist](https://packagist.org/packages/mage2kishan/).

### Quick Links

- 🌐 **Website:** [kishansavaliya.com](https://kishansavaliya.com)
- 💬 **Get a Quote:** [kishansavaliya.com/get-quote](https://kishansavaliya.com/get-quote)
- 👨‍💻 **Upwork Profile (Top Rated Plus):** [upwork.com/freelancers/~016dd1767321100e21](https://www.upwork.com/freelancers/~016dd1767321100e21)
- 🏢 **Upwork Agency:** [upwork.com/agencies/1881421506131960778](https://www.upwork.com/agencies/1881421506131960778/)
- 📦 **Packagist:** [packagist.org/packages/mage2kishan/module-cachemanager](https://packagist.org/packages/mage2kishan/module-cachemanager)
- 🐙 **GitHub:** [github.com/mage2sk/module-cachemanager](https://github.com/mage2sk/module-cachemanager)
- 🛒 **Adobe Marketplace:** [commercemarketplace.adobe.com](https://commercemarketplace.adobe.com)
- 📧 **Email:** kishansavaliyakb@gmail.com
- 📱 **WhatsApp:** +91 84012 70422

---

<p align="center">
  <strong>Ready to speed up your Magento 2 store?</strong><br/>
  <a href="https://kishansavaliya.com/get-quote">
    <img src="https://img.shields.io/badge/%F0%9F%9A%80%20Get%20Started%20%E2%86%92-Free%20Quote%20in%2024h-DC2626?style=for-the-badge" alt="Get Started" />
  </a>
</p>

---

**SEO Keywords:** magento 2 cache manager, magento 2 cache warmup, magento 2 smart cache invalidation, magento 2 full page cache, magento 2 FPC warmup, magento 2 curl_multi warmup, magento 2 concurrent cache warmup, magento 2 cron cache warmup, magento 2 warmup log, hyva cache warmup, magento 2 cache tags invalidation, magento 2 product save cache, magento 2 category save cache, magento 2 CMS save cache, magento 2 TTL configuration, magento 2 performance optimization, magento 2 core web vitals, magento 2 TTFB optimization, panth cache manager, panth infotech, mage2kishan, mage2sk, magento 2.4.8 cache module, magento 2.4.7 cache warmup, PHP 8.4 magento cache, hire magento developer upwork, top rated plus magento freelancer, kishan savaliya magento, custom magento development, magento 2 hyva development, magento 2 luma customization, magento 2 SEO services, M1 to M2 migration, adobe commerce cloud expert, magento 2 checkout optimization, magento 2 varnish integration
