# UPGRADE FROM 1.x to 2.0

## PHP version support

- Support for PHP < 7.4 was dropped

## Classes

- `Feather\Icons` was renamed to `Feather\IconManager`

## Icons

- `Feather\Icons::get()` was renamed to `Feather\IconManager::getIcon()`
- `Feather\Icon` objects are returned by `Feather\IconManager::getIcon()` instead of a `string`
