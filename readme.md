# Get the Image

Get the Image is a plugin that grabs images for you.  It was designed to make the process of things such as adding thumbnails, feature images, and/or other images to your blog much easier, but it's so much more than that.  It is an image-based representation of your WordPress posts.

## What the plugin does

This plugin was made to easily get an image related to a post.  This is the default method order in which the plugin attempts to grab an image.

* Meta key (custom field).
* Post thumbnail (WP featured image).
* Image attachment.
* Image embedded in the post content.
* Default/fallback image.

## Usage

The basic function call for the plugin is like so:

```
<?php get_the_image(); ?>
```

This is the only function you should use from the plugin.  It expects to be called within the WordPress posts loop unless you pass it a post ID directly (`post_id` argument).

To do more with the image script, you'll need to use what's called [function-style parameters](http://codex.wordpress.org/Template_Tags/How_to_Pass_Tag_Parameters#Tags_with_PHP_function-style_parameters).  The following is a basic example of using function-style parameters.

```
<?php get_the_image( array( 'meta_key' => 'thumbnail', 'size' => 'thumbnail' ) ); ?>
```

### Parameters

The `get_the_image()` function accepts a single parameter of `$args`, which is an array of parameters for deciding how to load an image.  The following is the list of all the default arguments.

```
$defaults = array(

	// Post the image is associated with.
	'post_id'            => get_the_ID(),

	// Method order (see methods below).
	'order'              => array( 'meta_key', 'featured', 'attachment', 'scan', 'scan_raw', 'callback', 'default' ),

	// Methods of getting an image (in order).
	'meta_key'           => array( 'Thumbnail', 'thumbnail' ), // array|string
	'featured'           => true,
	'attachment'         => true,
	'scan'               => false,
	'scan_raw'           => false, // Note: don't use the array format option with this.
	'callback'           => null,
	'default'            => false,

	// Split image from post content (by default, only used with the 'scan_raw' option).
	'split_content'      => false,

	// Attachment-specific arguments.
	'size'               => has_image_size( 'post-thumbnail' ) ? 'post-thumbnail' : 'thumbnail',

	// Key (image size) / Value ( width or px-density descriptor) pairs (e.g., 'large' => '2x' )
	'srcset_sizes'       => array(),

	// Format/display of image.
	'link'               => 'post', // string|bool - 'post' (true), 'file', 'attachment', false
	'link_class'         => '',
	'image_class'        => false,
	'image_attr'         => array(),
	'width'              => false,
	'height'             => false,
	'before'             => '',
	'after'              => '',

	// Minimum allowed sizes.
	'min_width'          => 0,
	'min_height'         => 0,

	// Captions.
	'caption'            => false, // Default WP [caption] requires a width.

	// Saving the image.
	'meta_key_save'      => false, // Save as metadata (string).
	'thumbnail_id_save'  => false, // Set 'featured image'.
	'cache'              => true,  // Cache the image.

	// Return/echo image.
	'format'             => 'img',
	'echo'               => true,

	// Deprecated arguments.
	'custom_key'         => null, // @deprecated 0.6.0 Use 'meta_key'.
	'default_size'       => null, // @deprecated 0.5.0 Use 'size'.
	'the_post_thumbnail' => null, // @deprecated 1.0.0 Use 'featured'.
	'image_scan'         => null, // @deprecated 1.0.0 Use 'scan' or 'scan_raw'.
	'default_image'      => null, // @deprecated 1.0.0 Use 'default'.
	'order_of_image'     => null, // @deprecated 1.0.0 No replacement.
	'link_to_post'       => null, // @deprecated 1.1.0 Use 'link'.
);
```

* `post_id` - The ID of the post to get the image for.  This defaults to the current post in the loop.
* `order` - Order of methods used to grab images. Defaults to `array( 'meta_key', 'featured', 'attachment', 'scan', 'scan_raw', 'callback', 'default' )`.
* `meta_key` - This parameter refers to post meta keys (custom fields) that you use.  Remember, meta keys are case-sensitive (defaults are `Thumbnail` and `thumbnail`).  By default, this is an array of meta keys, but it can also be a string for a single meta key.
* `featured` - This refers to the `the_post_thumbnail()` WordPress function. By having this set to `true`, you may select an image from the featured image meta box while on the edit post screen.
* `attachment` - The script will look for images attached to the post (set to `true` by default).
* `scan` - If set to `true`, the script will search within your post for an image that's been added.
* `scan_raw` - If set to `true`, the script will search within your post for an image and pull the raw HTML for that image.
* `callback` - A custom callback function that will be called if set.  It's only called if no images are found by any other options of the plugin.  However, it will be run before the `default` is set.  The `$args` array is passed to the callback function as the only parameter.
* `default` - Will take the input of an image URL and use it if no other images are found (no default set).
* `split_content` - Whether to split the raw HTML of the found image from the post content. Default is `false`. This method is only used with the `scan_raw` method.
* `size` - This refers to the size of an attached image.  You can choose between `thumbnail`, `medium`, `large`, `full`, or any custom image size you have available (the default is `thumbnail` or `post-thumbnail` if theme has set a thumbnail size).
* `link` - What to link the image to. `'post'` (links to the post), `'file'` (links to the image file), `'attachment'` (links to the attachment page if image is attachment), or `false` (link to nothing).
* `link_class` - Add a custom HTML class to the link.
* `image_attr` - Array of image attributes (key is the attribute name, value is the attribute value).
* `image_class` - You can give an additional class to the image for use in your CSS.
* `width` - Set the width of the image on output.
* `height` - Set the height of the image on output.
* `before` - HTML to place before the output of the image.
* `after` - HTML to place after the output of the image.
* `min_width` - Minimum width of the image to get.  This won't work with the `scan*` methods. Defaults to `0`.
* `min_height` - Minimum height of the image to get.  This won't work with the `scan*` methods. Defaults to `0`.
* `caption` - Whether to display the image caption if it exists.  Defaults to `false`.
* `meta_key_save` - A meta key to save the image URL as.  This is useful if you're not using custom fields but want to cut back on database queries by having the script automatically set the custom field for you.  By default, this is set to `false`.
* `thumbnail_id_save` - Whether to save the attachment ID as the post thumbnail (featured image) ID if no featured image is set for the post.  By default, this is set to `false`
* `cache` - Whether to use the WordPress Cache API (integrates with caching plugins) to serve the post images.  By default, this is set to `true`.
* `format` - What format to return the image in.  If set to `array` the return value of the function will be an array of `<img>` attributes.  All other values will return the `<img>` element.
* `echo` - If set to `true`, the image is shown on the page.  If set to `false`, the image will be returned to use in your own function. (Set to `true` by default.)

### Some usage examples

#### Example 1

Let's suppose that you want to add thumbnails to your category archive pages.  What you'll need to do is open your `category.php` file and add this code within the Loop:

```
<?php get_the_image(); ?>
```

By default, that will look for an image with the custom field **key** `Thumbnail` and `thumbnail`.  If that image doesn't exist, it will check if a post image has been set.  If that image doesn't exist, it will search for any images attached to your post.

#### Example 2

Let's suppose you want a full-sized image and maybe you want to grab it by a custom field key of `feature`.  Depending on your theme, this will need to go within the Loop in whatever file is calling the featured article.

```
<?php get_the_image( array( 'meta_key' => 'feature', 'size' => 'full' ) ); ?>
```

If no feature image exists by custom field, it will look for images attached to your post.

#### Example 3

If you want to have a sort of fallback image, then you can set an image for the script to default to if no other images are found.

```
<?php get_the_image( array( 'default' => 'http://mysite.com/wp-content/uploads/example.jpg' ) ); ?>
```

#### Example 4

You can even make the script scan for images that have been added to your post with this:

```
<?php get_the_image( array( 'scan' => true ) ); ?>
```

#### Example 5

Saving an image to the `thumbnail` custom field automatically.

```
<?php get_the_image( array( 'meta_key_save' => 'thumbnail' ) ); ?>
```

### A real-world example

This is an example Loop, which may differ slightly from your theme, but the concept is the same.  The call to get the image can go anywhere between the opening and closing lines.  In the following example, the image will appear before the post title.

```
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php get_the_image( array( size' => 'medium', 'image_class' => 'feature' ) ); ?>

		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="entry-summary">
			<?the_excerpt(); ?>
		</div>

	</div>

<?php endwhile; endif; ?>
```

### Protect yourself from errors in the future

Sometimes, we stop using plugins, but we forget to remove the function calls to the plugin in our theme files.  When deactivated, this causes errors.  To protect yourself from these errors, you can call the image script like this:

```
<?php if ( function_exists( 'get_the_image' ) ) {
	get_the_image();
} ?>
```

Basically, this just checks to see if the plugin is activated and has loaded the appropriate function.

## Styling your images

The plugin will help you style your images by giving you some CSS classes to work with.  It will turn your custom field keys and default size into CSS classes.  You can also choose to input your own class.

By default, you can add this to your CSS:

```
img.thumbnail {}
```

Let's suppose you've used this code:

```
<?php get_the_image( array( 'meta_key' => array( 'Donkey Kong', 'mario' ), 'size' => 'full' ) ); ?>
```

This will give you these CSS classes to work with:

```
img.full {}
img.donkey-kong {}
img.mario {}
```

You can also input a custom CSS class like so:

```
<?php get_the_image( array( 'image_class' => 'custom-image' ) ); ?>
```

You will still have the `size` and `meta_key` classes plus your additional class:

```
img.custom-image {}
img.thumbnail {}
```

## Support

I run a WordPress community called [Theme Hybrid](https://themehybrid.com), which is where I fully support all of my WordPress projects, including plugins.  You can sign up for an account to get plugin support for a small yearly fee.

I know.  I know.  You might not want to pay for support, but just consider it a donation to the project.  To continue making cool, GPL-licensed plugins and having the time to support them, I must pay the bills.

## Copyright and License

Get the Image is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2008&thinsp;&ndash;&thinsp;2017 &copy; [Justin Tadlock](http://justintadlock.com).
