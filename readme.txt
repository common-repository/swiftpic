=== SwiftPic ===
Contributors: sharespring
Tags: image, resize, scale
Requires at least: 3.7
Tested up to: 6.0.0
Stable tag: 1.0.0
Requires PHP: 5.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Helper functions for image resizing in theme development using SwiftPic. https://swiftpic.io/

== Description ==
Image resize service for web dev.
Let our servers crop, compress, and deliver your images.
Save time. Improve page speed. Crop automatically.
Define image sizes in code and display everything at the right dimensions.
We think this is how all sites should render images.

== Installation ==

Enter your account credentials into WP Admin > Settings > SwiftPic.
You could also choose to define a constant, which will override the dashboard settings.
The available constants are SWIFTPIC_USERNAME, SWIFTPIC_SECRET_KEY, and SWIFTPIC_SITE_URL.
You can add a filter to swiftpic_settings if you want to change these settings dynamically.
The Site URL is optional, and can be used if your assets load from a different URL, such as a CDN.

== Frequently Asked Questions ==

= How do I get a SwiftPic account? =

SwiftPic is currently in a private beta. You may email us to request access.

== Changelog ==

= 1.0.0 =
* Initial release with swiftPic() function, and settings
