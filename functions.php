<?php
/*
 *  Author: Roger Flanagan | @thisisroger
 *  URL: http://www.rarelyproper.com
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	Theme Support
\*------------------------------------*/
if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_enqueue_style( 'wp-google-fonts','https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&display=swap',false);
    // include the css file
    $cssFilePath = glob( get_template_directory() . '/css/build/main.min.*' );
    $cssFileURI = get_template_directory_uri() . '/css/build/' . basename($cssFilePath[0]);
    wp_enqueue_style( 'site_main_css', $cssFileURI );
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 40;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="post__link" href="' . get_permalink($post->ID) . '">' . __('Read More', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}


// include the javascript file
$jsFilePath = glob( get_template_directory() . '/js/build/app.min.*.js' );
$jsFileURI = get_template_directory_uri() . '/js/build/' . basename($jsFilePath[0]);
wp_enqueue_script( 'site_main_js', $jsFileURI , null , null , true );











if ( ! function_exists( 'tenUpSvgSystem' ) ) {
	/**
	 * Output and Get Theme SVG.
	 * Output and get the SVG markup for an icon in the tenUpSvgIcons class.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function tenUpSvgSystem( $svg_name, $group = 'ui', $color = '' ) {
		echo tenUpGetSvgSystem( $svg_name, $group, $color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in tenUpGetSvgSystem().
	}
}

if ( ! function_exists( 'tenUpGetSvgSystem' ) ) {

	/**
	 * Get information about the SVG icon.
	 *
	 * @param string $svg_name The name of the icon.
	 * @param string $group The group the icon belongs to.
	 * @param string $color Color code.
	 */
	function tenUpGetSvgSystem( $svg_name, $group = 'ui', $color = '' ) {

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses(
			tenUpSvgIcons::get_svg( $svg_name, $group, $color ),
			array(
				'svg'     => array(
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true,
				),
				'path'    => array(
					'fill'      => true,
					'fill-rule' => true,
					'd'         => true,
					'transform' => true,
				),
				'polygon' => array(
					'fill'      => true,
					'fill-rule' => true,
					'points'    => true,
					'transform' => true,
					'focusable' => true,
				),
			)
		);

		if ( ! $svg ) {
			return false;
		}
		return $svg;
	}
}

if ( ! class_exists( 'tenUpSvgIcons' ) ) {
	/**
	 * SVG ICONS CLASS
	 * Retrieve the SVG code for the specified icon. Based on a solution in Twenty Nineteen.
	 */
	class tenUpSvgIcons {
		/**
		 * GET SVG CODE
		 * Get the SVG code for the specified icon
		 *
		 * @param string $icon Icon name.
		 * @param string $group Icon group.
		 * @param string $color Color.
		 */
		public static function get_svg( $icon, $group = 'ui', $color = '#1A1A1B' ) {
			if ( 'ui' === $group ) {
				$arr = self::$ui_icons;
			}

			if ( array_key_exists( $icon, $arr ) ) {
				$repl = '<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" ';
				$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
				$svg  = str_replace( '#1A1A1B', $color, $svg );   // Replace the color.
				$svg  = str_replace( '#', '%23', $svg );          // Urlencode hashes.
				$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
				$svg  = preg_replace( '/>\s*</', '><', $svg );    // Remove whitespace between SVG tags.
				return $svg;
			}
			return null;
		}

		/**
		 * ICON STORAGE
		 * Store the code for all SVGs in an array.
		 *
		 * @var array
		 */
		public static $ui_icons = array(
			'logo' => '<svg viewBox="0 0 86 66" xmlns="http://www.w3.org/2000/svg">
			<path d="M7.167 29.432h71.666a4.345 4.345 0 003.225-1.427c.807-.891 1.165-2.14.986-3.389C80.714 10.792 63.514.356 43 .356 22.485.357 5.285 10.793 3.046 24.528c-.18 1.249.179 2.408.985 3.39.717.98 1.881 1.515 3.136 1.515zm-.627-4.28C8.51 13.021 24.188 3.923 43 3.923c18.813 0 34.49 9.098 36.46 21.227 0 .268-.09.446-.179.535 0 0-.179.179-.448.179H7.167c-.27 0-.359-.09-.448-.179-.09-.089-.18-.267-.18-.535zm73.1 24.258c.716-.891 1.164-2.05 1.164-3.21v-2.051c0-2.944-2.329-5.263-5.285-5.263H10.302c-2.956 0-5.285 2.32-5.285 5.263V46.2c0 1.249.448 2.319 1.164 3.21-1.97 1.517-3.314 3.925-3.314 6.6v1.428c0 4.46 3.583 8.116 7.883 8.116h64.32c4.39 0 7.884-3.657 7.884-8.116V56.01c0-2.676-1.344-5.084-3.314-6.6zm-69.338-1.515A1.697 1.697 0 018.6 46.2v-2.051c0-.981.806-1.695 1.702-1.695H75.52c.985 0 1.702.803 1.702 1.695V46.2c0 .981-.806 1.695-1.702 1.695H44.614a4.997 4.997 0 00-5.017 4.994v4.103a.801.801 0 01-.806.803.801.801 0 01-.807-.803v-4.103a4.997 4.997 0 00-5.016-4.994h-1.165c-2.419 0-4.39 1.962-4.39 4.37v.98c0 1.339-1.164 2.498-2.508 2.498s-2.508-1.16-2.508-2.497v-.981c0-2.408-1.971-4.37-4.39-4.37h-7.705zm69.069 9.543c0 2.497-1.971 4.548-4.3 4.548H10.75c-2.419 0-4.3-2.05-4.3-4.548V56.01c0-2.497 1.881-4.549 4.3-4.549h7.167c.448 0 .806.357.806.803v.98c0 3.3 2.687 6.066 6.092 6.066 3.404 0 6.091-2.676 6.091-6.065v-.981c0-.446.359-.803.806-.803h1.165c.806 0 1.433.624 1.433 1.427v4.103c0 2.408 1.971 4.37 4.39 4.37 2.419 0 4.39-1.962 4.39-4.37v-4.103c0-.803.627-1.427 1.433-1.427H75.07c2.329 0 4.3 2.052 4.3 4.549v1.427zm5.464-25.865c-1.075-1.07-2.418-1.605-3.852-1.605-1.433 0-2.866.535-3.852 1.605l-2.598 2.586c-.716.714-1.97.714-2.687 0l-2.688-2.675c-1.075-1.07-2.418-1.606-3.852-1.606-1.433 0-2.866.536-3.852 1.606l-2.508 2.497c-.717.714-1.971.714-2.688 0l-2.508-2.408c-2.15-2.14-5.644-2.14-7.704 0l-2.598 2.586c-.717.714-1.97.714-2.688 0l-2.597-2.586c-2.15-2.14-5.644-2.14-7.705 0l-2.329 2.319c-.716.713-1.97.713-2.687 0L23.47 31.93c-1.075-1.07-2.419-1.606-3.852-1.606-1.434 0-2.867.535-3.852 1.606l-1.971 1.962c-.717.713-1.971.713-2.688 0l-2.15-1.962c-2.15-2.14-5.643-2.14-7.704 0-.717.713-.717 1.784 0 2.497.717.714 1.792.714 2.509 0 .716-.713 1.97-.713 2.687 0l2.06 2.051c1.075 1.07 2.42 1.606 3.853 1.606 1.433 0 2.866-.535 3.852-1.606l1.97-1.962c.717-.713 1.971-.713 2.688 0l1.97 1.962c1.076 1.07 2.42 1.606 3.853 1.606 1.433 0 2.866-.535 3.852-1.606l2.33-2.319c.716-.713 1.97-.713 2.687 0l2.598 2.587c1.075 1.07 2.418 1.605 3.852 1.605 1.433 0 2.866-.535 3.852-1.605l2.598-2.587c.716-.713 1.97-.713 2.687 0l2.508 2.498c1.075 1.07 2.42 1.605 3.853 1.605 1.433 0 2.866-.535 3.852-1.605l2.508-2.498c.717-.713 1.97-.713 2.687 0l2.688 2.676a5.52 5.52 0 003.852 1.606c1.433 0 2.777-.536 3.852-1.606l2.598-2.586c.717-.714 1.97-.714 2.688 0 .716.713 1.791.713 2.508 0 .717-.714.717-1.963.09-2.676z"/>
			<path d="M17.38 19.443c.537 0 1.074-.267 1.343-.624l1.254-1.516c.627-.803.538-1.873-.269-2.498-.806-.624-1.88-.535-2.508.268l-1.254 1.516c-.627.803-.538 1.873.269 2.497.358.268.716.357 1.164.357zm9.405 2.676c.359.446.896.624 1.344.624.448 0 .806-.178 1.165-.446.716-.624.896-1.783.268-2.497l-.895-1.07c-.627-.714-1.792-.892-2.509-.268-.716.624-.896 1.784-.268 2.497l.895 1.16zm1.971-9.633c.359.536.896.892 1.523.892.269 0 .627-.089.896-.267.896-.535 1.165-1.606.627-2.408l-.896-1.606c-.537-.892-1.612-1.16-2.418-.624-.896.535-1.165 1.605-.628 2.408l.896 1.605zm10.124 7.671c.357.446.895.713 1.432.713.359 0 .717-.089 1.076-.356.806-.625.985-1.695.358-2.498L40.67 16.59c-.627-.803-1.702-.98-2.508-.357-.807.625-.986 1.695-.359 2.498l1.075 1.427zm1.343-8.741c.18.09.448.09.627.09.717 0 1.433-.447 1.702-1.16l.717-1.784c.358-.892-.09-1.962-1.075-2.319-.896-.357-1.971.09-2.33 1.07l-.716 1.784c-.269.981.18 1.962 1.075 2.32zm10.212 12.308c.359 0 .627-.089.986-.267l1.523-.981c.806-.535 1.075-1.606.537-2.498-.537-.802-1.612-1.07-2.508-.535l-1.523.981c-.806.535-1.075 1.606-.538 2.498.359.446.986.802 1.523.802zm.448-11.059c.27.09.448.178.717.178.717 0 1.344-.357 1.612-1.07l.896-1.873c.448-.892 0-1.962-.895-2.319-.896-.446-1.971 0-2.33.892l-.896 1.873c-.447.803 0 1.873.896 2.319zm9.227 5.262c.359.446.896.714 1.434.714.358 0 .716-.09 1.075-.357.806-.625.985-1.695.358-2.498l-1.075-1.427c-.627-.802-1.702-.98-2.508-.356s-.986 1.694-.359 2.497l1.075 1.427zm9.944 4.013c.18.09.358.09.538.09.806 0 1.523-.535 1.702-1.249l.716-2.408c.27-.981-.268-1.962-1.254-2.23-.985-.267-1.97.268-2.24 1.249L68.8 19.8c-.269.892.269 1.873 1.254 2.14z"/>
		  </svg>',
			'chevron-right' => '<svg viewBox="0 0 20 20">
			<path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/>
			</svg>',
			'close' => '<svg viewBox="0 0 20 20">
			<path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
			</svg>',
			'menu' => '<svg viewBox="0 0 20 20">
			<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
			</svg>',
		);
	}
}


?>