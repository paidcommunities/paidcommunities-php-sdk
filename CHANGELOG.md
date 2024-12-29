# Changelog

## 1.0.1 - 2024-12-29
* Changed constructor args for PaidCommunities\WordPress\PluginConfig.
    * $version is replaced with $product_id. The version is parsed from the plugin file's metadata like standard
      WordPress. This change
      was necessary in order to support product bundling.
* License settings default option name is {$product_id}_license_settings. The previous naming convention used
  was {$slug}_license_settings.
* `PaidCommunities\WordPress\UpdateController` - `product_id` was added to plugin update request.
* `PaidCommunities\WordPress\AdminAdminAjaxController` - `product_id` was added to license activation request.