=== Flickr-stream ===
Contributors: dman25560
Donate link: http://www.codeclouds.net/
Tags: photos, flickr, gallery
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: 1.2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to include photosets and gallerys from flickr in your wordpress site, either embedded in a page or post, or as a sidebar widget

== Description ==

This plugin allows you to embed your own or others photosets and galleries directly into your wordpress site. This plugin was designed to create a cleaner and simpler interface, both in adminstration and the frontend of the site. 

The only task that has to be completed to use this plugin is to get a API key from flickr. Afterwards it is as simple as plugining in options to generate the widget or to create shortcodes that can be placed on any page or post within your wordpress site. 

To create a shortcode first click 'Create Shortcode' and enter the various options for the photoset or gallery. Make sure to use the right 'ID' format (see FAQ's) based on whether you are adding a photoset or gallery. Click 'Save New Shortcode' and then copy and paste the shortcode into where you want it to appear within your site. For the widget the instructions are the same except for the copy and pasting part, of course. 

Features Include:

- Hide or show title of photoset or gallery
- Choose between small or medium thumbnails for shortcode embeds
- Cache photo data to prevent Flickr api calls each time a page is generated
- Random or from the top photo thumbnail selection
- Link photos to either Flickr or a lightbox (Magnific Popup plugin included, if needed)
- Choose to hide photo captions or not
- Set photoset / gallery alignment to either left, right, or center
- Set color of photo highlights

== Installation ==

1. Unzip 'flickr-stream.zip' and upload `flickr-stream` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Get a Flickr API key and place it in the Flickrstream settings menu under Settings
4. Start creating shortcodes and or a sidebar widget


== Frequently Asked Questions ==

= How many images can I include on a page or in the widget? =

The widget will take up to 10 photos, while a page or post can have up to 30 photos per shortcode. The amount of shortcodes that can be used per page or post is limitless.

= Should I include the Magnific Popup scripts? = 

Most likely yes, since it is a newer lightbox added with version 1.2 of this plugin. The Magnific Popup scripts should only be included if you are not already using another Magnific Popup plugin that adds the scripts already.

= Should I cache my photosets / gallerys? =

Caching removes the need to query the Flickr API everytime a page is loaded that contains a gallery or photoset, which will speed up your site. However, not caching allows you to have the photos change every time a page is loaded.

== Screenshots ==

1. A Flickr Set embedded on a page
2. The main settings admin page
3. The shortcode admin page

== Changelog ==

= 1.2.5 =

* Fixed mobile lightbox bug
* Fixed overflow issue when adding more images than are in a gallery/set
* Separated main options and shortcodes into two sections
* Added server-side validation/api checks
* Fixed issue with widget options not displaying correctly
* Fixed various api call issues
* Added ability to change photo highlight color globally

= 1.2.1 =

* Fixed Flickr HTTPS Api changeover

= 1.2 = 

* Changed lightbox from Fancybox to Magnific Popup, a better responsive lightbox
* Added the ability to sort shortcodes in the admin screen
* Prepared plugin for localization
* Hopefully fixed upgrade scripting issues
* Isolated multiple galleries on one page / post from one another
* Added spanish translation - Andrew Kurtis - WebHostingHub

= 1.1.5 =

* Rebuilt plugin structure to a object based setup
* Added a mobile photo viewer option for mobile devices
* Improved administrative interface
* Added previews of photos in admin interface
* Improved plugin security 

= 1.1 =

* Simplified code and fixed some random bugs
* Added the inclusion of Fancybox scripts in case user does not have Fancybox
* Added alignment setting to galleries / photosets
* Added hide caption setting to galleries / photosets
* Fixed admin form confirmation messages
* Added confirmation dialog for deletions

= 1.0.2 =

* Fixed activation issue for updates resetting options

= 1.0.1 =

* Fixed script include issue for stylesheet

= 1.0 =

* Inital release of Flickr-stream