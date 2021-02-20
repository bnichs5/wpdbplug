
=== AddFunc Adaptive Content ===

Contributors: AddFunc,joerhoney
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7AF7P3TFKQ2C2
Tags: adaptive, adaptive shortcode, adaptive content, adaptive function, adaptive quicktags, adaptive image, device detection, device based, device-based, device specific, mobile detection, mobile detect, mobile device, mobileonly, mobile only, notmobile, not mobile, tablet detection, tabletonly, tablet only, nottablet, not tablet, desktop detection, desktoponly, desktop only, notdesktop, notdesk top, iosonly, ios only, iphoneonly, iphone only, ipadonly, ipad only, androidonly, android only, windowsmobileonly, windows mobile only, responsive
Requires at least: 3.0.1
Tested up to: 5.0
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds functions, shortcodes & quicktags to empower WordPress users to have better control of when content is served, based on device.

== Description ==

With all of the new web enabled devices springing up in the market and with the wide range of screen sizes and data transfer speeds, a website can no longer serve the same content upon every request (not without some degree of limitation and/or traffic-loss).

This lightweight plugin lets content writers and theme authors choose when WordPress should or shouldn't show any give content item using shortcodes and quicktags or theme elements using functions. It uses [Mobile Detect](http://mobiledetect.net/) (a PHP script) to identify the website visitor's device as either mobile, tablet or desktop, enabling you to allow or disallow content to be output. Use it to prevent large files such as images from outputting to devices that generally have a lower data transfer speed available to them (e.g. mobile devices). Serve more extensive copy and more elaborate userinterfaces to desktop devices and laptops. Target tablets to market a tablet oriented product or service. You can also detect iOS, iPhone, iPad, Android OS and Windows Mobile OS.

Example of a shortcode: [notmobile]Write anything you want between these two tags and WordPress will only output it when the visitor is viewing your website with a desktop/laptop or tablet and not with a mobile device.[/notmobile]

Easily add these shortcodes using the Quicktags in Text view.

All shortcodes also exist as functions (prefixed with aFAC_ for namespacing), which can be used in your theme as needed. See the [FAQs][1] for more detail. Each function is a boolean and simply returns true or false.

[1]: http://wordpress.org/plugins/addfunc-adaptive-content/faq/

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the `addfunc-adaptive-content` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Start using the shortcodes in your content and/or the functions in your theme

== Frequently Asked Questions ==

= What shortcodes are available with AddFunc Adaptive Content? =

All available shortcodes are documented in the Help tab under "Adaptive Content" (on the content editing page).

= What functions are available with AddFunc Adaptive Content? =

*   aFAC_mobileonly()  — Returns true only when device is mobile (and not tablet)
*   aFAC_notmobile()   — Returns true only when device is not mobile (or is tablet)
*   aFAC_tabletonly()  — Returns true only when device is tablet
*   aFAC_nottablet()   — Returns true only when device is not tablet
*   aFAC_desktoponly() — Returns true only when device is not mobile (and not tablet)
*   aFAC_notdesktop()  — Returns true only when device is mobile (or is tablet)
*   aFAC_iosonly()     — Returns true only when device is iOS
*   aFAC_iphoneonly()  — Returns true only when device is iPhone
*   aFAC_ipadonly()    — Returns true only when device is iPad
*   aFAC_androidonly() — Returns true only when device is Android OS
*   aFAC_windowsmobileonly() — Returns true only when device is Windows Mobile OS

= Does AddFunc Adaptive Content rely on JavaScript for anything? =

To use the Quicktags you must have your JavaScript enabled. Other than that, nope.

= Does AddFunc Adaptive Content rely on PHP for anything? =

Yep.

= Does AddFunc Adaptive Content work by browser sniffing? =

Yes. That is what it's base script ([Mobile_Detect.php](http://mobiledetect.net/)) is designed for and it does the job well.

= Wouldn't a JavaScript solution be more reliable? =

Can I get a statistic? It really depends on how often you get visitors who have javascript turned off and whether you can do without them. Likewise, I suppose, it depends on whether many of your visitors withhold their browser and system data when requesting your website. Neither of these are very common, but they both happen.

= Wouldn't a JavaScript solution be faster? =

Not likely. PHP generally runs very fast on web servers, and with JavaScript the you're relying on the speed of your visitors system. Beside that, the point of this plugin is to serve the right content to the right devices, and only that. If you have to load a Javascript to detect the device before loading the rest of the page, that's an additional script served and another query to your server would be necessary, when here we're trying to minimize data transfer. Plus, waiting until your visitor's machine has finish running a script before you can serve up the entire page isn't as efficient as catching the device and OS specs when they first come to you automatically and thusly knowing what to serve up right from the start of the initial query.

= Wouldn't it be better to serve up images at an appropriate size based on the screen size or image area width, rather than the device type? =

Yes. That's quite a trick and we would love to see someone develop a plugin which makes that easy. I haven't found one yet.

== Screenshots ==

1. Quicktags available in Text view.

2. This handy Help tip is easily at hand whenever you're editing content.

== Changelog ==

= 2.0 =
Feb-2016

*   Adds Quicktags
*   Includes updated Mobile_Detect.php to the latest stable release (2.8.19)

= 1.0 =
Sep-2015

*   Includes updated Mobile_Detect.php to the latest stable release (2.8.16)
*   Includes updated readme.txt (hereafter goes without mention)
*   Submitted to WordPress repository

= 0.1.2.0 =
Apr-2015

*   Repurposed WP Mobile Detect as AddFunc Adaptive Content, to alter the shortcodes and to reinstate maintenance of this valuable plugin
