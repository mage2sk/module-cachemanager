# Changelog

All notable changes to the Panth Cache Manager module will be documented in this file.

## [1.0.0] - 2026-04-13

### Added
- Smart cache invalidation on product, category, and CMS page/block save events.
- Automated cache warmup via cron with configurable schedule.
- Concurrent request support using curl_multi with configurable batch size.
- Warmup log database table and admin UI grid for monitoring warmup results.
- Configurable full-page-cache TTL per store view.
- Admin configuration under Stores > Configuration > Panth Extensions > Cache Manager.
- ACL resources for Cache Manager configuration access.
- Unit tests for helper, cron, and observer classes.
