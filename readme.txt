=== Get the Image ===

Contributors: greenshady
Donate link: https://themehybrid.com/donate
Tags: image, images, thumbnail
Requires at least: 3.9
Tested up to: 4.8.2
Requires PHP: 5.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An easy-to-use image script for adding things such as thumbnail, slider, gallery, and feature images.

== Description ==

Get the Image is one of the most advanced thumbnail/image scripts ever created for WordPress.

It is used everywhere from small blogs to large, enterprise-level solutions like [WordPress.com VIP](http://vip.wordpress.com/).  Get the Image offers something for everybody. Much of the reason for its success is because it uses standard WordPress code and methods for doing what it needs to do, which is to simply grab images.

The plugin was designed to make the process of adding thumbnail, featured, slider, gallery, and other images to your blog much easier, but it's so much more than that.  It is an image-based representation of your WordPress posts.

This is a highly intuitive script that can grab an image by custom field input, WordPress' featured image, post attachment, or extracting it from the post's content.  Plus, a lot more!

### Before using

Please note that Get the Image requires that you understand and know how to edit your theme's PHP code, at least to the extent of copying and pasting one line of code.  If you're not comfortable doing this, it's best to ask that your theme author integrate the code necessary to support this plugin.

### A little history

The original plugin was in launched 2008, which means it has several years of solid testing and development behind it.  It was created at a time when WordPress had very little native media support.  At the time, it was mostly used as a "thumbnail" script for magazine-/news-style sites.  But, it has grown into a much more flexible script over the years.

Even with WordPress' more recent advancements in image management, many users still continue using this plugin because it offers a more robust image script than core WordPress.

The plugin has been downloaded 100,000s of times and is used on millions of sites as part of WordPress theme packages.

Other image plugins have come and gone, but Get the Image has stood the test of time with several years of successful installs and happy users.

### Professional support

If you need professional plugin support from me, the plugin author, you can join the club at [Theme Hybrid](https://themehybrid.com/club), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 75,000+ users (and growing).

### Plugin Development

If you're a theme author, plugin author, or just a code hobbyist, you can follow the development of this plugin on its [GitHub repository](https://github.com/justintadlock/get-the-image).

### Donations

Yes, I do accept donations.  If you want to donate, you can do so from my [donations page](https://themehybrid.com/donate) or grab me something from my [Amazon Wish List](http://a.co/flUb0ns).

I appreciate all donations, no matter the size.  Further development of this plugin is not contingent on donations, but they are always a nice incentive.

== Frequently Asked Questions ==

### Why was this plugin created?

It was originally created to work with magazine/news themes.  These types of themes typically required a lot of work when inputting images to make them look good.  This plugin was developed to make that process much easier for the end user.  But, at the same time, it needed to be flexible enough to handle anything.

However, over the years, it has grown to be one of the most robust image scripts for WordPress.

### How does it grab images?

1. Looks for an image by custom field (one of your choosing).
2. If no image is added by custom field, check for a featured image.
3. If no image is found, it grabs an image attached to your post.
4. If no image is attached, it can extract an image from your post content (off by default).
5. If no image is found at this point, it will fall back to a default image (not set by default).

### How do I add it to my theme?

There are several methods, but in general, you would use this call within The Loop.

```
<?php if ( function_exists( 'get_the_image' ) ) get_the_image(); ?>
```

To see all methods and options, refer to the `readme.md` file included with the plugin download or [view the readme online](https://github.com/justintadlock/breadcrumb-trail/blob/master/readme.md).

== Screenshots ==

1. Slider plus thumbnails.
2. Portfolio images.
3. Gallery-style thumbnails.

== Changelog ==

Please see the `changelog.md` file included with the plugin file.  Or, you can view the [online change log](https://github.com/justintadlock/breadcrumb-trail/blob/master/changelog.md).
