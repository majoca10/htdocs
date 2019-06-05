=== WP Coming Soon ===
Contributors: miriamdepaula 
Donate link: http://wpmidia.com.br
Tags: countdown, clock, coming soon
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: 1.2.1

WP Coming Soon is a simple plugin that adds a countdown clock in your Coming Soon page... Nothing more! 

== Installation ==

1) Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

2) Go to Settings > WP Coming Soon Options and insert the requested info.

3) Put this `if ( function_exists('get_countdown')) get_countdown();` where you want to display the countdown clock... If you want to use the countdown timer within a page or page template, you can use the shortcode `[wp_coming_soon]`

That´s it! =)

== Description ==

WP Coming Soon is a plugin that adds a countdown clock in the Coming Soon page. This plugin uses Keith Wood jQuery plugin. See it at: http://keith-wood.name/countdown.html.

[BASIC USAGE]

Put this `if ( function_exists('get_countdown')) get_countdown();` where you want to display the countdown clock... 

If you want to use the countdown timer within a page or page template, you can use the shortcode `[wp_coming_soon]`

== Frequently Asked Questions ==

= No questions at the momment =

Good!

== Screenshots ==

1. The options screen.

2. The countdown in action

== Changelog ==
= 1.2.1 =
* CSS bug fixes
* Added WordPress Settings default timezone in the code

= 1.2 =
* jQuery Countdown script was updated solving the problem of compatibility with jQuery on the new version of WordPress.
* Added Albanian, Gujarati, Malayalam and Uzbek localizations.

= 1.1 =
* Fixed issues with localization of the plugin Options Page
* Added Portuguese (Portugal) - jquery countdown translation - /js/jquery.countdown-pt.js
* Fixed some issues with CSS
* Added Shortcode featured -- [wp_coming_soon]

= 1.0 =
* Initial release


== Upgrade Notice ==
