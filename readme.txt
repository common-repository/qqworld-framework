=== QQWorld Framework ===
Contributors: Michael Wang
Tags: framework
Requires at least: 3.5
Tested up to: 3.6.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

QQWorld Framework for Wordpress Theme development.

== Description ==

QQWorld Framework for Wordpress Theme development.

== Installation ==

1. Upload `qqworld-framework` directory to `/wp-content/plugins/` directory.
上传 `qqworld-framework` 目录到 `/wp-content/plugins/` 文件夹.
2. Activate the plugin through the 'Plugins' menu in WordPress.
在wordpress的 '插件' 菜单中激活该插件.

== Changelog ==

= 1.2.1 =
fixed some error when debug config is true.

= 1.2.0 =
Complated the 'user roles' of runtime.
remove taxonomies function from 'posttype' of runtime
add 'taxonomies' of runtime.
add 'QQWorld e-Commerce' of plugins
fixed some bugs with 'framework forms' of lib
replace 'framework forms select style' that using 'chosen' jQuery plugin
fixed some bugs with 'metabox' of runtime
Upgrade 'slider' of sliders (it can save multi-sliders with shortcode)
add 'attachment meta' of runtime.

= 1.1.4 =
add 'Local Avatars' of plugins: supports to uplaod local avatar.
update 'metabox' of runtime: supports to add system field, such as Excerpt for page.

= 1.1.3 =
add 'common' of runtime.

= 1.1.2 =
Update I18n language.
update 'qqworld-flybox' of resource to 1.6 (Fixed error in IE8).
update 'qqworld-responsive-slider' of resource to 1.3.1 (Fixed can not open link in webkit core mobile explorer. such as safari & chrome ).
update 'qqworld-touch' of resource to 1.2.1.
add 'patch' of core and add 'WP e-Commerce' of patch.

= 1.1.1 =
add 'User Meta' of Runtime.

= 1.1.0 =
Rewrite the core of framework, uses 'theme_supports' to activate the members.

= 1.0.13 =
update 'Form FW' of core: uses 3.5+ uploader & wp-color-picker.
add 'file uploader' of 'Form FW'.

= 1.0.12 =
update 'qqworld-zoom' of Resources to v1.2.
update 'qqworld-flybox' of Resources to v1.5.
update 'qqworld-matrix-slider' of Resources to v1.0.3.

= 1.0.11 =
Move 'QRCode' from runtime to plugins.
Remove all global variable of members, used one global variable: $qqworld_fw_members.
add 'init_js' of runtime.
update 'jquery.qqworld_loadimgs-min.js' in Resource.
add 'qqworld-zoom' of Resources: v1.0.

= 1.0.10 =
add 'roles' of Runtime.
add 'template' of Runtime.
update 'qqworld_responsive_slicer' of Sliders: uses json_encode($arr, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT) convert PHP array to json.
fixed error of 'theme support' of Runtime: 'post-thumbnails' must run before init hook, so i used load_textdomain hook.
fixed 'qqworld-flybox' of Resources: Some thumbnail picture that width is not a integer. so even it's top style is 0, but looks the position going down.
update 'qqworld-dropdown-menu' of Resource: change 'qqworld-drapdown-menu' to 'qqworld-dropdown-menu'.
add 'dropdown' of Menu.
add 'primary_menu' of Menu.

= 1.0.9 =
add 'nav_menu' of Runtime.
add default customize object.

= 1.0.8 =
add 'theme_support' of Runtime.
update 'metabox' of Runtime.
update 'posttype' of Runtime.
update 'shortcode' of Runtime.
update 'customize' of Runtime.

= 1.0.7 =
add 'Customize' of Runtime.
fixed error of Constants that can't load textdomain language.

= 1.0.6 =
update 'editor_buttons' & 'shortcode' runtime.
update 'syntaxHighLighter' of Plugins to uses editor_buttons & shortcode runtime.
update 'syntaxHighLighter2' of Plugins to uses editor_buttons & shortcode runtime.

= 1.0.5 =
update Editor buttons in text mode for 'syntaxHighLighter' of Plugins.
update Editor buttons in text mode for 'syntaxHighLighter2' of Plugins.

= 1.0.4 =
add 'Sidebar' of Runtime.
add 'Widgets' of Runtime.

= 1.0.3 =
finished 'Shortcode' of Runtime.

= 1.0.2 =
* update "Editor Buttons" of Runtime.
update language

= 1.0.1 =
* update "Editor Buttons" of Runtime.
update default.php

= 1.0 =
* tada. powerful plugin was born.