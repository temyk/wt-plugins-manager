=== WP Plugins Manager ===
Contributors: webtemyk
Tags: plugins, bulk, manager, developer,
Requires at least: 4.6
Tested up to: 5.4.0
Stable tag: trunk
Requires PHP: 5.6.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Plugins Manager plugin adds the ability to deactivate and immediately delete plugins by clicking on a single link.
It also adds features to the plugin page, such as icons and GIT status.

== Description ==

An additional "Deactivate and remove" link appears in the list of plugins. When you click on it, the plugin is deactivated and immediately deleted.
The plugin list also displays logos and icons if the plugin is loaded via GIT.
You can also sort plugins: the active first or the inactive first.
The update notification for these plug-ins is reduced so as not to distract attention from updating other plug-ins.
Displays a changelog in the plugin update notice.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugins-manager` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==
= If I accidentally deactivated and removed the plugin =
Deleted plugins cannot be restored. However, most plugins do not remove their settings, so you can reinstall it

== Screenshots ==

1. All plugin improvements are marked with a red line

== Changelog ==

= 1.2.6 =
* Add settings page
* Show changelog in update notices
* Fix bug after upload plugin

= 1.2.2 =
* Fix git icon

= 1.2.1 =
* Add icon if the plugin is loaded via GIT

= 1.2.0 =
* Performance has been improved.
* Added sorting of plugins

= 1.1.2 =
* Fixed "Check all" doesn’t work

= 1.1.1 =
* Fixed white screen on plugins page

= 1.1.0 =
* [NEW] To the list of plugins added the column with a plugin icon.
* The "Deactivate and delete" link has been replaced with "Delete"

= 1.0.1 =
* Temporarily hide settings page
* Up version

= 1.0.0 =
* First release.