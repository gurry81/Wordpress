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
	wp_enqueue_script('ir_widget', get_template_directory_uri() .'/irwidget.js', array('jquery'));
	
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

//include image random widget class
add_action( 'after_setup_theme', 'include_irwidget' );

function include_irwidget(){
	require(get_template_directory() . '/includes/image-random-widget/irwidget.php');
}


/*=======  randomImage widget ======*/



class RandomImage_wt_sb extends WP_Widget {

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

    	if(isset($instance["title"]) && $instance["title"] != null){
    		echo $args["before_title"];
    		echo $instance["title"]; 
    		echo $args["after_title"];
    	}

    	if(isset($image)){
    		
    	?>

		<a target="_blank" href="<?php echo $image['linkage']; ?>">
    		<img src="<?php echo $image['url']; ?>" width="<?php echo $instance['width']; ?>" />
		</a>

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
				array_push($instance["image"], array("url" => strip_tags($new_instance["image"]),"linkage" =>strip_tags($new_instance["linkage"])));
			}else{
				$instance["image"] = array(array("url" =>strip_tags($new_instance["image"]) , "linkage" =>strip_tags($new_instance["linkage"])));
			}
		}

		$options = json_decode($new_instance["trash"]);
		$edit = $options->toEdit;
		$trash = $options->toDelete;

		// aplica los cambios a las imagenes
		foreach ($edit as $value) {
			$instance["image"][$value->id]["url"] = $value->url;
			$instance["image"][$value->id]["linkage"] = $value->linkage;
		}
		
		$new_images = array();
		// borra las imagenes seleccionadas guardandolas en un nuevo array para resetear indices
		foreach ($instance["image"] as $id => $value) {

			if(!in_array($id,$trash)){
				array_push($new_images, $value);				
			}
		}

		$instance["image"] = $new_images; 

		if(!isset($instance["sizes"])){
			$instance["sizes"] = array(
					"small" => "35%",
					"medium" => "70%",
					"big" => "100%"
				);
		}

		$instance["title"] = ($this->checkField($new_instance["title"])?$new_instance["title"]:null);
		$instance["sizeSelected"] = $new_instance["sizeSelected"];
		$instance["width"] = $instance['sizes'][isset($new_instance['sizeSelected'])?$new_instance['sizeSelected']:"big"];


		return $instance;		
    }

    private function checkField($field){
    	return (trim(strip_tags($field)))? true : false;
    }

    // If widget content needs a form
    function form($instance) {
        //widgetform in backend
        //$this->script_ir();  
        $this->css_ir();
        //$instance["newbie"] = isset($instance["newbie"])? false : true;
        //isset($instance["newbie"])?$this->defaultImages($instance):null;
        ?>
        <div class="randomImage_panel" onload="instance_ir_widget(".<?php echo $this->number;?>.")">
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
        			<?php echo ($instance["sizeSelected"] == "small"? checked:"");?>/>

        		<label>Medium</label>
        		<input type="radio" id="<?php echo $this->get_field_id('medium')?>"
        			name="<?php echo $this->get_field_name('sizeSelected')?>" value="medium"
        			<?php echo ($instance["sizeSelected"] == "medium"? checked:""); ?>/>

        		<label>Big</label>
        		<input type="radio" id="<?php echo $this->get_field_id('big')?>"
        			name="<?php echo $this->get_field_name('sizeSelected')?>" value="big"
        			<?php echo (!isset($instance["sizeSelected"]) || $instance["sizeSelected"] == "big"? checked:"");?>/>
        	</p>

        	<p>
        		<label for="<?php echo $this->get_field_id('image'); ?>">Add New Image</label><br>
				<input type="text" placeholder="url" id="<?php echo $this->get_field_id('image'); ?>" 
			    	name="<?php echo $this->get_field_name('image'); ?>"/><br><br>

			    <label for="<?php echo $this->get_field_id('linkage'); ?>">Link to Image</label><br>
				<input type="text" id="<?php echo $this->get_field_id('linkage'); ?>" 
			    	name="<?php echo $this->get_field_name('linkage'); ?>"/>
        	</p>

        	<input type="hidden" id="<?php echo $this->get_field_id('trash'); ?>" 
			    	name="<?php echo $this->get_field_name('trash'); ?>"/>
			<p> 
				<input class="save_changes" type="button" value="Save Changes" <?php echo (isset($instance["image"])?null:disabled);?> onclick="ir_widget.saveEdit(event,jQuery)"/>	
			</p>

        	<div class="ir_galery">
        		<?php 
        			foreach ($instance["image"]  as $key => $value) {
        				echo "<div class='miniImage'>
        						<img src='" .  $value['url'] . "'/>
        						<div id='" . $key . "' class='optionPanel'>
									<span class='deleteOp option' onclick='ir_widget.deleteImageIR(event,jQuery)'>Delete</span>
									<span class='editOp option' onclick='ir_widget.showImageData(event,jQuery,".json_encode($value).")'>Edit</span>
        						</div>
        					</div>";
        			}
        		?>
        	</div>
        </div>
        <?php 

    } 

    private function defaultImages(&$instance){
    	$instance["image"] = array(
    		array("url" => "http://www.marketingdirecto.com/wp-content/uploads/2013/10/social-bro.jpg", "linkage" => "http://es.socialbro.com/"),
    		array("url" => "http://www.marketingdirecto.com/wp-content/uploads/2013/10/social-bro.jpg", "linkage" => "http://es.socialbro.com/"),
    		array("url" => "http://www.marketingdirecto.com/wp-content/uploads/2013/10/social-bro.jpg", "linkage" => "http://es.socialbro.com/"),

    	);

    	$this->update_callback();
    }

    private function css_ir(){
    	?>

    	<style type="text/css">

    		.randomImage_panel input[type=text]{
    			width: 100%;
    		}

    		.randomImage_panel .miniImage{
    			display: inline-block;
    			width: 120px;
    			height: 80px;
    			margin: 5px;
    			position: relative;
    			vertical-align: top;
    			transition: all 0.8s ease;
    		}

    		.randomImage_panel .optionPanel{
    			text-align: center;
    			line-height: 30px;
    			display: none;
    			background: rgba(0,0,0,0.5);
    			height: 100%;
    			width: 100%;
    			position: absolute;;
    			top: 0;
    			left: 0;
    		}

    		.randomImage_panel .miniImage:hover .optionPanel{
    			display: block;
    		}


    		.randomImage_panel .miniImage img{
    			width: 100%;
    			height: 100%;
    		}

    		.randomImage_panel .ir_galery{
    			padding: 10px 0; 
    		}

    		.randomImage_panel .option{
    			color: white;
    			font-weight: bold;
    			display: block;
    			margin: 5px 0;
    			cursor: pointer;
    		}

    		.randomImage_panel input[type='text']{
    			transition: all 0.7s ease;
    		}

    		.randomImage_panel .save_changes{
				background: rgb(46, 162, 204);
				border: 1px solid rgb(0, 116, 162);
				box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.5) inset, 0px 1px 0px rgba(0, 0, 0, 0.15);
				color: rgb(255, 255, 255);
				font-size: 13px;
				height: 28px;
				margin: 0px;
				padding: 0px 10px 1px;
				cursor: pointer;
				border-radius: 3px;
				white-space: nowrap;
    		}

    		.randomImage_panel .save_changes:hover{
    			background: rgb(46, 145, 204);
    		}

    	</style>
    	<?php
    }

    private function script_ir(){
    	?>
    	<script type="text/javascript">
    	var IR_widget = function (){
    		this.changes_ir =  {
    			toDelete: [],
    			toEdit: []
    		};

    		this.ir_Editing =  null;
    		this.ir_id_widget = null;
    	}

    		IR_widget.prototype.deleteImageIR = function (ev,$){
    			 var imageId = "#" + ev.target.offsetParent.id;

    			this.changes_ir.toDelete.push(Number(ev.target.offsetParent.id));
    			$(imageId).parent().css({
    				"width": "0",
    				"height": "0"
    			});

    			saveChanges($,ev.target);
				
    		}

    		IR_widget.prototype.showImageData = function(ev,$,data){
    			this.ir_Editing = "#" + ev.target.offsetParent.id;

    			$(getId("image",ev.target)).val(data.url).css("borderColor","orange");
    			$(getId("linkage",ev.target)).val(data.linkage).css("borderColor","orange");

    			$(getId("savewidget",ev.target)).prop("disabled","true");

    		}

    		IR_widget.prototype.saveEdit = function(ev,$){
    			
    			var changes = {
    				id: this.ir_Editing.replace("#",""),
    				url: $(getId("image",this.ir_Editing)).val(),
    				linkage: $(getId("linkage",this.ir_Editing)).val()				
    			}

    			this.changes_ir.toEdit.push(changes);

    			saveChanges($,ev.target);

    			$(getId("image",this.ir_Editing)).val("").css("borderColor","rgb(221,221,221)");
    			$(getId("linkage",this.ir_Editing)).val("").css("borderColor","rgb(221,221,221)");
    			$(getId("savewidget",ev.target)).removeProp("disabled");

    		}

    		IR_widget.prototype.saveChanges = function($,element){
    			$(getId("trash",element)).val(JSON.stringify(this.changes_ir));
    		}

    		IR_widget.prototype.getId = function (id, element){

    			if(!this.ir_id_widget){
    			 var id_widget = jQuery(element).parentsUntil(".widget",".widget-inside").parent().attr("id");
    			 this.ir_id_widget = "#widget-" + (id_widget.substr(id_widget.indexOf("_")+1)) + "-";
    			}

	    		 return this.ir_id_widget + id;	 
    		}

    		// instance a object for each widget

    		var ir_instances = ir_instances || null;
    		var ir_widget = ir_widget || null;

    		function instance_ir_widget(number){

	    		if(ir_instances){
					ir_instances[number] = new IR_widget();
					return;
				}

				ir_instances = Array();
				ir_instances[number] = new IR_widget();
    		}

    		function set_current_widget(number){
				ir_widget = ir_instances[number];
			}


    	</script>
    	
    	<?php    		
    		
    		
    }

}

register_widget('RandomImage_wt_sb'); 
//add_action( 'after_setup_theme', 'load_irWidget_js' );

function load_irWidget_js(){
	//wp_enqueue_script('ir_widget', get_template_directory() .'/irwidget.js', array('jquery'));
	include_once get_template_directory() . "/irwidget.js";
}

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
