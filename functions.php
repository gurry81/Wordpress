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



/*=======  twitter widgets ======*/

/* 	
	private images = array(
		"http://www.hdwallpapersbest.com/wp-content/uploads/2013/04/Top-Hd-Wallpapers-2.jpg",
		"http://www.hdpaperwall.com/wp-content/uploads/2013/11/3d_wallpapers_17.jpg",
		"http://wonderfulengineering.com/wp-content/uploads/2014/01/Technology-Wallpaper-6.jpg"
		);*/

class randomImage_wt_sb extends WP_Widget {

    // Create Widget
    function __construct() {
        parent::__construct(false,
			"Random Image Widget",
			array("description" => "A widget that generate a random image when load the page"));
    }

    // Widget Content
    function widget($args, $instance) { 
    	 
    	$image = $instance["image"][rand(0,count($instance["image"]) - 1)];
    	
    	echo $args["before_widget"];
    	echo $args["before_title"];
    	echo $instance["title"]; 
    	echo $args["after_title"];
    	if(isset($instance["image"])){
    	?>

    		<img src="<?php echo $image; ?>" width="<?php echo $instance['width']; ?>"/>

    	<?php
		}else{
		?>
			<h3>No hay imagenes agregadas</h3>
		<?php
		}
    	echo $args["after_widget"];

    	
     }

    // Update and save the widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

       if($this->checkField($new_instance["image"])){
			if(isset($instance["image"])){
				array_push($instance["image"], strip_tags($new_instance["image"]));
			}else{
				$instance["image"] = array(strip_tags($new_instance["image"]));
			}
		}

		$trash = json_decode($new_instance("trash"))->toDelete;

		foreach ($trash as $id) {
			unset($instance["image"][$id]);
		}

		if(!isset($instance["sizes"])){
			$instance["sizes"] = array(
					"small" => 160,
					"medium" => 260,
					"big" => 360
				);
		}

		$instance["title"] = $new_instance["title"];
		$instance["width"] = $instance['sizes'][isset($new_instance['sizeSelected'])?$new_instance['sizeSelected']:"big"];


		return $instance;		
    }

    private function checkField($field){
    	return (trim(strip_tags($field)))? true : false;
    }

    // If widget content needs a form
    function form($instance) {
        //widgetform in backend
        $this->script();  
        $this->css();
        ?>
        <div class="randomImage_panel">
        	<p>
        		<label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br>
				<input class="titleRI" type="text" id="<?php echo $this->get_field_id('title'); ?>" 
			    	name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
        	</p>

        	<p>
        		<label for="<?php echo $this->get_field_id('size'); ?>">Image Size </label><br><br>
        		<label>Small</label>
        		<input type="radio" id="<?php echo $this->get_field_id('small')?>"
        			name="<?php echo $this->get_field_name('sizeSelected')?>" value="small"
        			<?php echo ($instance["sizeSelected"] == "small"? selected:"");?>/>

        		<label>Medium</label>
        		<input type="radio" id="<?php echo $this->get_field_id('medium')?>"
        			name="<?php echo $this->get_field_name('sizeSelected')?>" value="medium"
        			<?php echo ($instance["sizeSelected"] == "medium"? selected:""); ?>/>

        		<label>Big</label>
        		<input type="radio" id="<?php echo $this->get_field_id('big')?>"
        			name="<?php echo $this->get_field_name('sizeSelected')?>" value="big"
        			<?php echo ($instance["sizeSelected"] == "big"? selected:"");?>/>
        	</p>

        	<p>
        		<label for="<?php echo $this->get_field_id('image'); ?>">Add New Image</label><br>
				<input type="text" placeholder="url" id="<?php echo $this->get_field_id('image'); ?>" 
			    	name="<?php echo $this->get_field_name('image'); ?>"/>
        	</p>

        	<input type="hidden" id="trash_ir" 
			    	name="<?php echo $this->get_field_name('trash'); ?>"/>

        	<div class="ir_galery">
        		<?php 
        			foreach ($instance["image"]  as $key => $value) {
        				echo "<span class='miniImage'>
        						<img src='" .  $value . "'/>
        						<span id='" . $key . "' class='deletePanel' onclick='deleteImageIR(event)'>Delete</span>
        					</span>";
        			}
        		?>
        	</div>


        </div>
        <?php  

    }

    private function css(){
    	?>

    	<style type="text/css">

    		.randomImage_panel input[type=text]{
    			width: 100%;
    		}

    		.miniImage{
    			display: inline-block;
    			width: 120px;
    			height: 80px;
    			margin: 0 5px;
    			position: relative;
    			vertical-align: top;
    			text-align: center;
    			transition: all 0.8s ease;
    		}

    		.deletePanel{
    			display: none;
    			cursor: pointer;
    			background: rgba(0,0,0,0.7);
    			color: white;
    			font-weight: bold;
    			position: absolute;
    			top: 0;
    			left: 0;
    		}

    		.miniImage:hover .deletePanel{
    			display: block;
    			opacity: 0.7;
    		}

    		.miniImage:hover img{
    			opacity: 0.2;
    		}

    		.miniImage img{
    			width: 100%;
    			height: 100%;
    		}

    		.ir_galery{
    			padding: 10px 0; 
    		}
    	</style>
    	<?php
    }

    private function script(){
    	?>
    	<script type="text/javascript">
    	var imagesOptions = {
    		"toDelete": [],
    		"toEdit": []
    	};

    		function deleteImageIR(ev){
    			var imageId = ev.target.id;

    			imagesOptions.toDelete.push(imageId);

    			document.getElementById(imageId).offsetParent.style.width = "0";
    			document.getElementById(imageId).offsetParent.style.height = "0";
    			alert(imagesOptions.toDelete);

	 			document.getElementById("trash_ir").nodeValue = JSON.stringify(imagesOptions);


		}
    	</script>
    	<?php
    }

}

register_widget('randomImage_wt_sb');



/*=== ADD FAVICON ====*/


function childtheme_favicon() { ?>
	<link rel="shortcut icon" href="/wp-content/uploads/2014/02/favicon.png" >
<?php }
add_action('wp_head', 'childtheme_favicon');

/*===	LIMIT EXCERPT ===*/

function custom_excerpt_length( $length ) {
	return 10;
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
    return 50;
}


// Change Excerpt More
add_filter('excerpt_more', 'themezee_excerpt_more');
function themezee_excerpt_more($more) {
    return '';
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
