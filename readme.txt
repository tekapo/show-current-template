=== Show Current Template ===
Contributors: tai
Donate link: https://wp.tekapo.com/is-my-plugin-useful/
Tags: template, toolbar
Requires at least: 3.5
Tested up to: 5.8
Stable tag: 0.5.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==
A WordPress plugin which shows the current template filename, the current theme name and included template files in the admin toolbar.

Inspired by (and big thanks to):

* https://gist.github.com/gatespace/4482529
* https://wordpress.org/plugins/reveal-template/


== Installation ==

= The Good Way =

1. In your WordPress Admin, go to the Add New Plugins page
1. Search for: Show Current Template
1. Show Current Template should be the first result. Click the Install link.

= The Old Way =

1. Upload the plugin to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I don't see the new part of the admin toolbar, do I have to enable it? =
The option "Show Toolbar when viewing site" in your user's profile should already be checked off by default, but in case it is not, make sure to check that option.
You can find your profile page in your WordPress admin -> Users -> Profile.

= I don't see the current template file name in the toolbar even though that option is checked.  Where is the plugin data? =
You must be logged in as "Administrator" to see the plugin in action. Users with other roles like "Editor" can't see the toolbar menu item. If your WordPress uses multisite, only super admins can see the entry in the admin toolbar.

= I'dont think this plugin is working properly.

Please try below:

* Activate one of the default themes.

Does the plugin work properly upon activation of the default theme? If the plugin works with a WordPress theme, that shows that there may be a compatibility issue between your theme and this plugin, so please send us your theme’s name and where we can get it.

* Try to stop all plugins other than this plugin.

Now the plugin work properly? Then it means there may be a compatibility issue between one of those other plugins and this plugin, so let me know those plugins names and where I can get it so we can potentially fix the issue.

== Screenshots ==

1. Shows the current template file.

== Upgrade Notice ==

None so far.

== Changelog ==

= 0.5.0 =
* Added CSS and JS file to the menu
* Color-coded the different filetypes in the menu
* Added type prefix to each item in the menu

= 0.4.6 =
* Fix JS Error when No Admin Bar. Special thanks to @taupecat for reporting the issue!

= 0.4.5 =
* Fix showing included files at bottom when your WordPress site in multisite when you are a normal admin (not super admin). Special thanks to @dmchale for reporting the issue!

= 0.4.4 =
* Fix not showing included files on Windows local. Special thanks to @lindt01 for helping me identify the cause!

= 0.4.3 =
* Fix the JavaScript error reported by @flexer. Special thanks to @dmchale for the fix!

= 0.4.2 =
* Fix showing included files at bottom when the logged in user's roles other than admin.

= 0.4.1 =
* Fix showing included files at bottom when visitor visits the site. This issue was reported by @tsato. Thank you very much!

= 0.4.0 =
* Fix not showing all included files with WordPress version 5.4 or greater.
* Clean up some code. 

= 0.3.4 =
* No functional change at all except the version number in the plugin php file and donation url.

= 0.3.3 =
* No functional change at all except the version number in the plugin php file and donation url.

= 0.3.2 =
* No change at all except the version number in the plugin php file.

= 0.3.1 =
* Just add a donate link.

= 0.3.0 =
* UPDATED: Make the file list scrollable.
* UPDATED: Change css to sass.

= 0.2.2 =
* Oops, too short.

= 0.2.1 =
* UPDATED: Make the height of included files names shorter

= 0.1.8 =
* UPDATED: update for 3.8.

= 0.1.6 =
* FIXED: update for 3.8.

= 0.1.5 =
* FIXED: Fixed the issue of not displaying the parent theme name when using a child theme.

= 0.1.4 =
* UPDATED: Make not to show the current file in the included files list.

= 0.1.3 =
* FIXED: Fixed some notices.

= 0.1.2 =
* FIXED: Fixed potential conflict text domain (https://github.com/tekapo/show-current-template/pull/1).
  Thanks to @wokamoto san.

= 0.1.1 =
* UPDATED: readme.txt

= 0.1.0 =
* Initial release
