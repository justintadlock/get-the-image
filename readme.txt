=== Get the Image ===

Contributors: greenshady
Donate link: http://themehybrid.com/donate
Tags: image, images, thumbnail
Requires at least: 3.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An easy-to-use image script for adding things such as thumbnail, slider, gallery, and feature images.

== Description ==

Get the Image is one of the most advanced thumbnail/image scripts ever created for WordPress. 

It is used everywhere from small blogs to large, enterprise-level solutions like [WordPress.com VIP](http://vip.wordpress.com/).  Get the Image offers something for everybody. Much of the reason for its success is because it uses standard WordPress code and methods for doing what it needs to do, which is to simply grab images.

The plugin was designed to make the process of adding thumbnail, featured, slider, gallery, and other images to your blog much easier, but it's so much more than that.  It is an image-based representation of your WordPress posts.

This is a highly intuitive script that can grab an image by custom field input, WordPress' featured image, post attachment, or extracting it from the post's content.  Plus, a lot more!

### A little history ###

The original plugin was in launched 2008, which means it has several years of solid testing and development behind it.  It was created at a time when WordPress had very little native media support.  At the time, it was mostly used as a "thumbnail" script for magazine-/news-style sites.  But, it has grown into a much more flexible script over the years.

Even with WordPress' more recent advancements in image management, many users still continue using this plugin because it offers a more robust image script than core WordPress.

The plugin has been downloaded 100,000s of times and is used on millions of sites as part of WordPress theme packages.

Other image plugins have come and gone, but Get the Image has stood the test of time with several years of successful installs and happy users.

### Professional support ###

If you need professional plugin support from me, the plugin author, you can access the support forums at [Theme Hybrid](http://themehybrid.com/support), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 40,000+ users (and growing).

### Plugin Development ###

If you're a theme author, plugin author, or just a code hobbyist, you can follow the development of this plugin on its [GitHub repository](https://github.com/justintadlock/get-the-image). 

### Donations ###

Yes, I do accept donations.  If you want to buy me a beer or whatever, you can do so from my [donations page](http://themehybrid.com/donate).  I appreciate all donations, no matter the size.  Further development of this plugin is not contingent on donations, but they are always a nice incentive.

== Installation ==

1. Upload `get-the-image` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the appropriate code to your template files as outlined in the `readme.md` file.

== Frequently Asked Questions ==

### Why was this plugin created? ###

It was originally created to work with magazine/news themes.  These types of themes typically required a lot of work when inputting images to make them look good.  This plugin was developed to make that process much easier for the end user.  But, at the same time, it needed to be flexible enough to handle anything.

However, over the years, it has grown to be one of the most robust image scripts for WordPress.

### How does it grab images? ###

1.  Looks for an image by custom field (one of your choosing).
2. If no image is added by custom field, check for an image using `the_post_thumbnail()` (WordPress featured image).
3. If no image is found, it grabs an image attached to your post.
4. If no image is attached, it can extract an image from your post content (off by default).
5. If no image is found at this point, it will fall back to a default image (not set by default).

### How do I add it to my theme? ###

There are several methods, but in general, you would use this call within The Loop.

	<?php if ( function_exists( 'get_the_image' ) ) get_the_image(); ?>

To see all methods and options, refer to the `readme.md` file included with the plugin download or view it on the plugin's [GitHub page](https://github.com/justintadlock/get-the-image)

== Screenshots ==

1. Slider plus thumbnails.
2. Portfolio images.
3. Gallery-style thumbnails.

== Changelog ==

### Version 1.0.0 ###

#### General Changes: ####

* `the_post_thumbnail` argument deprecated in favor of `featured`.
* `image_scan` argument deprecated in favor of `scan` or `scan_raw`.
* `default_image` argument deprecated in favor of `default`.
* `order_of_image` argument removed with no replacement.

#### Enhancements: ####

* Re-coded how the image script works by encapsulating the functionality into a single class rather than multiple functions. This makes it much easier to reuse code and paves the way for more improvements in the future.
* New `scan_raw` argument for pulling an image (straight HTML) directly from the post content.
* New `split_content` argument for removing an image from the post content if one is found. Used only in conjunction with the `scan_raw` argument.
* New `order` argument for changing the order in which the script looks for images.
* Better support and handling for sub-attachments (e.g., featured images for audio/video attachments).
* Support for Schema.org microdata.  `itemprop="image"` attribute added to image outputs where possible.
* New image orientation class if the width and height are available. Class can be `landscape` or `portrait`.
* Default image size is `post-thumbnail` if the theme has set this size. Otherwise, `thumbnail` is the default size.
* Supports the ability to get embedded images via WordPress' image embeds (Instagram, Flickr, etc.) via the `scan*` methods.
* New filter hook: `get_the_image_post_content`. Used when checking the post content.
* Added `min_width` and `min_height` arguments (doesn't work with `scan*` methods).

### Version 0.9.0 ###

#### Enhancements: ####

* Caption support. FTW!
* Multiple image classes now allowed via the `image_class` argument.
* Use current theme's `post-thumbnail` as default image size if set via `set_post_thumbnail_size()`.

#### Bug fixes: ####

* Use the WordPress-saved attachment alt text for the image.
* Only add `$out['src']` if `$out['url']` is set when returning as an array.
* Allow `https` when returning as an array.
* Use the correct variable (`$attachment_id`) when getting an image via attachment. 

### Version 0.8.1 ###

* Use correct `$attachment_id` variable instead of `$id`.
* Pass full `$image` array to the `get_the_image_meta_key_save()` function so that it saves correctly.
* Only use `before` and `after` arguments if an image is found.
* General code formatting updated.

### Version 0.8 ###

* Inline docs updates.
* Added the `before` argument to output HTML before the image.
* Added the `after` argument to output HTML after the image.
* Added the `thumbnail_id_save` argument to allow the attached image to be saved as the thumbnail/featured image.
* Get the post ID via `get_the_ID()` rather than the global `$post` object.
* Fixed debug notice with `$image_html`.
* Moved the `*_fetch_post_thumbnail_html` hooks into the main function and only fire them if displaying to the screen.
* Simplified the `meta_key` logic.
* Completely rewrote the `attachment` logic.
* Sanitize classes with `sanitize_html_class()`.

### Version 0.7 ###

* Deprecated and replaced functions that lacked the `get_the_image_` prefix.
* New cache delete functions that delete when a post or post meta is updated.
* Fixed notice when `image_scan` was used.

### Version 0.6.2 ###

* Updated the cache to save by post ID instead of a single object.
* Minor code adjustments.

### Version 0.6.1 ###

* Updated inline documentation of the code.
* Smarter `meta_key` logic, which allows a single meta key or an array of keys to be used.
* Set `custom_key` and `default_size` to `null` by default since they're deprecated.

### Version 0.6 ###

* Deprecated `custom_key` in favor of `meta_key`.
* Added the `meta_key_save` argument to allow users to save the image as a meta key/value pair.
* Added a `callback` argument to allow developers to create a custom callback function.
* Added a `cache` argument, which allows users to turn off caching.

### Version 0.5 ###

* Added support for persistent-caching plugins.
* Switched the `default_size` argument to `size` to be more in line with the WordPress post thumbnail arguments, but `default_size` will still work.
* Now using `wp_kses_hair()` to extract image attributes when using the `array` value for `format`.
* Image `alt` text will now use the attachment description if one has been given rather than the post title.
* Updated the `readme.html` instructions for using the plugin.

### Version 0.4 ###

* Dropped support for older versions of WordPress. Now only compatible with 2.9+.
* Added support for `the_post_thumbnail()`, which is WordPress 2.9's new image functionality.
* New function: `image_by_the_post_thumbnail()`.
* Documented more of the code, so the inline PHP doc is updated.
* Cleaned up some of the old legacy code that's no longer needed.

### Version 0.3.3 ###

* General code cleanup
* Added the `get_the_image` filter hook.

### Version 0.3.2 ###

* General code cleanup.
* More efficient and logical code.
* Beefed up the inline documentation so developers can better understand the code.
* Added a GPL license.txt file.

### Version 0.3.1 ###

* Fixed the default image and image scan features.

### Version 0.3 ###

* Changed methods of calling the image script.
* Added more parameters.