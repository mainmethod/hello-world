<?php
/**
 * landscape functions and definitions
 *
 * @package landscape
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 */
if ( ! isset( $content_width ) )
	$content_width = 1000; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );


if ( ! function_exists( 'landscape_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 */
function landscape_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on landscape, use a find and replace
	 * to change 'landscape' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'landscape', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured-thumbnail', 1440, 500, true );
	add_image_size( 'index-thumbnail', 1000, 200, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'landscape' ),
	) );
	
	add_editor_style();

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside' ) );
}
endif; // landscape_setup
add_action( 'after_setup_theme', 'landscape_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 */
function landscape_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'landscape' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Middle Sidebar', 'landscape' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'landscape' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Homepage Left Sidebar', 'landscape' ),
		'id' => 'homepage-left-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Homepage Middle Sidebar', 'landscape' ),
		'id' => 'homepage-middle-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Homepage Right Sidebar', 'landscape' ),
		'id' => 'homepage-right-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'landscape_widgets_init' );


/**
 * if lt IE 9
 */
function landscape_head(){
?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
}
add_action( 'wp_head', 'landscape_head');

/**
 * Enqueue scripts and styles
 */
function landscape_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'landscape_scripts' );

//google analytics
function add_google_analytics(){
    echo "<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-60086155-1', 'auto');
      ga('send', 'pageview');
    
    </script>\n";
}
add_action('wp_footer', 'add_google_analytics');

//purge varnish cache after comment status is changed in admin
function approve_comment_purge_varnish($new_status, $old_status, $comment) {
    $url = get_permalink($comment->comment_post_ID);
    $ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PURGE");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	curl_close($ch);
}
add_action('transition_comment_status', 'approve_comment_purge_varnish', 10, 3);

/**
 * Adds custom background support
 */

$args = array(
	'default-color' => 'ffffff',
);
add_theme_support( 'custom-background', $args );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );
