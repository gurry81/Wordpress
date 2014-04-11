<?php

// Set Content Width
if ( ! isset( $content_width ) )
	$content_width = 960;

/*==================================== THEME SETUP ====================================*/

// Load default style.css and Javascripts
add_action('wp_enqueue_scripts', 'themezee_enqueue_scripts');

if ( ! function_exists( 'themezee_enqueue_scripts' ) ):
function themezee_enqueue_scripts() { 
	
	// Register and Enqueue Stylesheet
	wp_register_style('themezee_zeeMinty_stylesheet', get_stylesheet_uri());
	wp_enqueue_style('themezee_zeeMinty_stylesheet');

	// Register and enqueue navigation.js
	wp_enqueue_script('themezee_jquery_navigation', get_template_directory_uri() .'/js/navigation.js', array('jquery'));
	
	// Register and Enqueue Fonts
	wp_register_style('themezee_default_font', 'http://fonts.googleapis.com/css?family=PT+Sans');
	wp_enqueue_style('themezee_default_font');
	
	wp_register_style('themezee_default_title_font', 'http://fonts.googleapis.com/css?family=Arimo');
	wp_enqueue_style('themezee_default_title_font');
	
}
endif;


// Load comment-reply.js if comment form is loaded and threaded comments activated
add_action( 'comment_form_before', 'themezee_enqueue_comment_reply' );
	
function themezee_enqueue_comment_reply() {
	if( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}


// Setup Function: Registers support for various WordPress features
add_action( 'after_setup_theme', 'themezee_setup' );

if ( ! function_exists( 'themezee_setup' ) ):
function themezee_setup() { 
	
	// init Localization
	load_theme_textdomain('zeeMinty_language', get_template_directory() . '/languages' );
	
	// Add Theme Support
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_editor_style();

	// Add Custom Background
	add_theme_support('custom-background', array(
		'default-color' => 'eeeeee',
		'default-image' => get_template_directory_uri() . '/images/background.png'));

	// Add Custom Header
	add_theme_support('custom-header', array(
		'default-image' => get_template_directory_uri() . '/images/default-header.jpg',
		'header-text' => false,
		'width'	=> 1920,
		'height' => 270,
		'flex-height' => true));
		
	// Register Navigation Menus
	register_nav_menu( 'main_navi', __('Main Navigation', 'zeeMinty_language') );
}
endif;


// Add custom Image Sizes
add_action( 'after_setup_theme', 'themezee_add_image_sizes' );

if ( ! function_exists( 'themezee_add_image_sizes' ) ):
function themezee_add_image_sizes() { 
	
	// Add Custom Header Image Size
	add_image_size( 'custom_header_image', 1920, 270, true);
	
	// Add Featured Image Size
	add_image_size( 'featured_image', 225, 225, true);
	
	// Add Frontpage Image Size
	add_image_size( 'frontpage_image', 1920, 550, true);
	
	// Add Widget Post Thumbnail Size
	add_image_size( 'widget_post_thumb', 75, 75, true);

}
endif;


// Register Sidebars
add_action( 'widgets_init', 'themezee_register_sidebars' );

if ( ! function_exists( 'themezee_register_sidebars' ) ):
function themezee_register_sidebars() {
	
	// Register Sidebars
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'zeeMinty_language' ),
		'id' => 'sidebar-main',
		'description' => __( 'Appears on posts and also pages (in case Sidebar Pages has no widgets) except frontpage/fullwidth template.', 'zeeMinty_language' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar( array(
		'name' => __( 'Sidebar Pages', 'zeeMinty_language' ),
		'id' => 'sidebar-pages',
		'description' => __( 'Appears on static pages only. Leave this widget area empty to use Main Sidebar on pages.', 'zeeMinty_language' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	
	// Register Frontpage Template Widgets
	register_sidebar( array(
		'name' => __( 'Frontpage Widgets', 'zeeMinty_language' ),
		'id' => 'frontpage-widgets-one',
		'description' => __( 'Three column horizontal widget area displayed on frontpage template.', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register Frontpage Template Widgets for latest blog post
	register_sidebar( array(
		'name' => __( 'Widgets for Blog', 'zeeMinty_language' ),
		'id' => 'widgets-for-blog',
		'description' => __( 'Widgets for blog', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-blog widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register Frontpage Footer Template Widgets for tweets
	register_sidebar( array(
		'name' => __( 'Widgets for tweets', 'zeeMinty_language' ),
		'id' => 'widgets-for-tweets',
		'description' => __( 'ATTENTION: Only the 6 (six) first widgets will appear on home, the rest of them in Comments page.', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));


// Register workspace for landing pages
	register_sidebar( array(
		'name' => __( 'Landing page A', 'zeeMinty_language' ),
		'id' => 'landing-page-b',
		'description' => __( 'Put here the widgets in order to create the landing page "A" contents, do no forget to assign the respective location for every widget', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register workspace for landing pages
	register_sidebar( array(
		'name' => __( 'Landing page B', 'zeeMinty_language' ),
		'id' => 'landing-page-c',
		'description' => __( 'Put here the widgets in order to create the landing page "B" contents, do no forget to assign the respective location for every widget', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register workspace for landing pages
	register_sidebar( array(
		'name' => __( 'Landing page C', 'zeeMinty_language' ),
		'id' => 'landing-page-a',
		'description' => __( 'Put here the widgets in order to create the landing page "C" contents, do no forget to assign the respective location for every widget', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register workspace for landing pages
	register_sidebar( array(
		'name' => __( 'Landing page D', 'zeeMinty_language' ),
		'id' => 'landing-page-d',
		'description' => __( 'Put here the widgets in order to create the landing page "D" contents, do no forget to assign the respective location for every widget', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));

// Register workspace for landing pages
	register_sidebar( array(
		'name' => __( 'Landing page E', 'zeeMinty_language' ),
		'id' => 'landing-page-e',
		'description' => __( 'Put here the widgets in order to create the landing page "E" contents, do no forget to assign the respective location for every widget', 'zeeMinty_language' ),
		'before_widget' => '<div class="widget-col-third"><div id="%1$s" class="widget-for-tweet widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
}
endif;





/*==================================== INCLUDE FILES ====================================*/

// Includes all files needed for theme options, custom JS/CSS and Widgets
add_action( 'after_setup_theme', 'themezee_include_files' );

if ( ! function_exists( 'themezee_include_files' ) ):
function themezee_include_files() { 

	// include Theme Option Files
	require( get_template_directory() . '/includes/options/options-setup.php' );
	require( get_template_directory() . '/includes/options/options-framework.php' );

	// include Customization Files
	require( get_template_directory() . '/includes/customization/custom-colors.php' );
	require( get_template_directory() . '/includes/customization/custom-layout.php' );
	require( get_template_directory() . '/includes/customization/custom-jscript.php' );
	
	// include Hooks, Template Tags and extra Features of the theme
	require( get_template_directory() . '/includes/template-tags.php' );
	require( get_template_directory() . '/includes/theme-hooks.php' );
	
}
endif;



/*=======  twitter widget ======*/

class widget_simple extends WP_Widget {

    // Create Widget
    function widget_simple() {
        parent::WP_Widget(false, $name = 'Twitter Users', array('description' => 'Comments on how wonderful is SocialBro'));
    }

    // Widget Content
    function widget($args, $instance) { 
        extract( $args );
        $simple_image_url = strip_tags($instance['simple_image_url']);
        $simple_image_link = strip_tags($instance['simple_image_link']);
        $simple_title = strip_tags($instance['simple_title']);
        $simple_title_link = strip_tags($instance['simple_title_link']);
        $simple_text = strip_tags($instance['simple_text']);

        ?>

            <div id="latest-box">

                <span class="img-box">
                    <a style="cursor:default;" target="_blank" href="<?php echo $simple_image_link; ?>"><img src="<?php echo $simple_image_url; ?>"></a>
                </span> <!-- img-box -->
		
               <div class="contentuss">
		<div class="bubble">
                <span class="latest-text">
                    <?php echo $simple_text; ?>
                </span> <!-- text -->
		</div>
		 <span class="latest-title">
                    <a target="_blank" href="<?php echo $simple_title_link; ?>"><?php echo $simple_title; ?></a>
                </span> <!-- title -->
		</div>
            </div> <!-- box -->

        <?php
     }

    // Update and save the widget
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    // If widget content needs a form
    function form($instance) {
        //widgetform in backend
        $simple_image_url = strip_tags($instance['simple_image_url']);
        $simple_image_link = strip_tags($instance['simple_image_link']);
        $simple_title = strip_tags($instance['simple_title']);
        $simple_title_link = strip_tags($instance['simple_title_link']);
        $simple_text = strip_tags($instance['simple_text']);
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('simple_image_url'); ?>">Avatar URL: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('simple_image_url'); ?>" name="<?php echo $this->get_field_name('simple_image_url'); ?>" type="text" value="<?php echo attribute_escape($simple_image_url); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('simple_image_link'); ?>">Avatar Link (optional): </label>
                <input class="widefat" id="<?php echo $this->get_field_id('simple_image_link'); ?>" name="<?php echo $this->get_field_name('simple_image_link'); ?>" type="text" value="<?php echo attribute_escape($simple_image_link); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('simple_title'); ?>">User handle: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('simple_title'); ?>" name="<?php echo $this->get_field_name('simple_title'); ?>" type="text" value="<?php echo attribute_escape($simple_title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('simple_title_link'); ?>">Tweet status Link: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('simple_title_link'); ?>" name="<?php echo $this->get_field_name('simple_title_link'); ?>" type="text" value="<?php echo attribute_escape($simple_title_link); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('simple_text'); ?>">Text of the tweet: </label>
                <textarea class="widefat" id="<?php echo $this->get_field_id('simple_text'); ?>" name="<?php echo $this->get_field_name('simple_text'); ?>"><?php echo attribute_escape($simple_text); ?></textarea>
            </p>

        <?php       
    }

}

register_widget('widget_simple');



/*=== ADD FAVICON ====*/


function childtheme_favicon() { ?>
	<link rel="shortcut icon" href="/wp-content/uploads/2014/02/favicon.png" >
<?php }
add_action('wp_head', 'childtheme_favicon');

/*===	LIMIT EXCERPT ===*/

function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*==================================== ADD ORDER COLUMN TO POST TYPE ====================================*/




/*==================================== THEME FUNCTIONS ====================================*/


//shorcodes for tyny wysiwyg editor category

add_filter( 'category_description', 'do_shortcode' );



// Creates a better title element text for output in the head section
add_filter( 'wp_title', 'themezee_wp_title', 10, 2 );

function themezee_wp_title( $title, $sep = '' ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'zeeMinty_language' ), max( $paged, $page ) );

	return $title;
}


// Add Default Menu Fallback Function
function themezee_default_menu() {
	echo '<ul id="mainnav-menu" class="menu">'. wp_list_pages('title_li=&echo=0') .'</ul>';
}

// Display Credit Link Function
function themezee_credit_link() { ?>
	<a href="http://themezee.com/themes/zeeminty/"><?php _e('zeeMinty Theme', 'zeeMinty_language'); ?></a>
<?php
}

//Show Posts's ID
add_filter('manage_posts_columns', 'posts_columns_id', 5);
    add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
    add_filter('manage_pages_columns', 'posts_columns_id', 5);
    add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
function posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function posts_custom_id_columns($column_name, $id){
        if($column_name === 'wps_post_id'){
                echo $id;
    }
}

// Add custom image size to Media Upload
add_filter( 'image_size_names_choose', 'themezee_add_image_size_names' );  
function themezee_add_image_size_names($sizes) {
	$custom_sizes = array(  
		'frontpage_image' => __('Frontpage Image', 'zeeMinty_language')  
	);  
	return array_merge( $sizes, $custom_sizes );  
}


// Change maximum image size for Frontpage Image
add_filter( 'editor_max_image_size', 'themezee_change_max_image_size', 10, 2 );  
function themezee_change_max_image_size($max, $size) {
	if ($size == 'frontpage_image')
		return array(1920, 550);
}


// Change Excerpt Length
add_filter('excerpt_length', 'themezee_excerpt_length');
function themezee_excerpt_length($length) {
    return 55;
}


// Change Excerpt More
add_filter('excerpt_more', 'themezee_excerpt_more');
function themezee_excerpt_more($more) {
    return ' [...]';
}

// Change excerpt filter
add_filter('get_the_excerpt','show_excerpt');
function show_excerpt($text){
		
	$text= trim($text) ? $text : get_the_content();
	$text = str_replace("[...]", "", $text); // to change
	$excerpt = strip_tags($text);
	$excerpt = substr($excerpt,0,(strlen(strip_tags($excerpt)) < 280? strlen($excerpt) : 280));
	$text_words = explode(" ",$text);
	$excerpt_words = explode(" ",$excerpt);
		
	$last = count($excerpt_words) - 1; 

	if(strlen($excerpt_words[$last]) < strlen($text_words[$last])){

		array_pop($excerpt_words); 

	}
		
	$excerpt = implode(" ", $excerpt_words);

	return "<p>" . catch_first_image_post($text) . $excerpt . apply_filters("excerpt_more") . "</p>";

}

function catch_first_image_post($text){
	
	$has_img = preg_match('/<img.+src=[\'"].+[\'"].*\/>/i', $text, $matches);
	
	if($has_img){
  		$first_img = $matches[0];
	} else {
		preg_match('/<img.+src=[\'"].+[\'"].*\/>/i', get_the_content(), $matches);
  		$first_img = $matches[0];
	}
		
	return $first_img;
}

/** USE IF U WANT TO ALLOW HTML TAGS**/
function debug_close_tags(){

	$tags = array("</strong>","</b>");

	return implode("",$tags);
}


// Custom Template for comments and pingbacks.
if ( ! function_exists( 'themezee_list_comments' ) ):
function themezee_list_comments($comment, $args, $depth) {
	
	$GLOBALS['comment'] = $comment;
	
	if( $comment->comment_type == 'pingback' or $comment->comment_type == 'trackback' ) : ?>
	
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<p><?php _e( 'Pingback:', 'zeeMinty_language' ); ?> <?php comment_author_link(); ?> 
			<?php edit_comment_link( __( '(Edit)', 'zeeMinty_language' ), '<span class="edit-link">', '</span>' ); ?>
			</p>
	
	<?php else : ?>
	
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 56 ); ?>
					<?php printf(__('<cite class="fn">%s</cite>', 'zeeMinty_language'), get_comment_author_link()) ?>
				</div>
				
		<?php if ($comment->comment_approved == '0') : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'zeeMinty_language' ); ?></p>
		<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf(__('%1$s at %2$s', 'zeeMinty_language'), get_comment_date(),  get_comment_time()) ?></a>
					<?php edit_comment_link(__('(Edit)', 'zeeMinty_language'),'  ','') ?>
				</div>
				
				<div class="comment-content"><?php comment_text(); ?></div>
				
				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			
			</div>
<?php
	endif;
	
}
endif;

?>
