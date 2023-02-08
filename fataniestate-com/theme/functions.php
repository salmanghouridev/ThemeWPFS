<?php
/**
 * fataniestate.com functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fataniestate.com
 */

if ( ! defined( 'FATANIESTATE_COM_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'FATANIESTATE_COM_VERSION', '0.1.0' );
}

if ( ! function_exists( 'fataniestate_com_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fataniestate_com_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on fataniestate.com, use a find and replace
		 * to change 'fataniestate-com' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fataniestate-com', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'fataniestate-com' ),
				'menu-2' => __( 'Footer Menu', 'fataniestate-com' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'fataniestate_com_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fataniestate_com_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'fataniestate-com' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'fataniestate-com' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'fataniestate_com_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fataniestate_com_scripts() {
	wp_enqueue_style( 'fataniestate-com-style', get_stylesheet_uri(), array(), FATANIESTATE_COM_VERSION );
	wp_enqueue_script( 'fataniestate-com-script', get_template_directory_uri() . '/js/script.min.js', array(), FATANIESTATE_COM_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fataniestate_com_scripts' );

/**
 * Add the block editor class to TinyMCE.
 *
 * This allows TinyMCE to use Tailwind Typography styles.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function fataniestate_com_tinymce_add_class( $settings ) {
	$settings['body_class'] = 'block-editor-block-list__layout';
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'fataniestate_com_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


// Properies Custom Post TYpe

function create_properties_post_type() {
	register_post_type( 'properties',
	  array(
		'labels' => array(
		  'name' => __( 'Properties' ),
		  'singular_name' => __( 'Property' )
		),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies' => array( 'category', 'property_type', 'property_status' )
	  )
	);
  }
  add_action( 'init', 'create_properties_post_type' );
  
  function create_property_taxonomies() {
	$labels = array(
	  'name' => _x( 'Categories', 'taxonomy general name' ),
	  'singular_name' => _x( 'Category', 'taxonomy singular name' ),
	  'search_items' =>  __( 'Search Categories' ),
	  'all_items' => __( 'All Categories' ),
	  'parent_item' => __( 'Parent Category' ),
	  'parent_item_colon' => __( 'Parent Category:' ),
	  'edit_item' => __( 'Edit Category' ), 
	  'update_item' => __( 'Update Category' ),
	  'add_new_item' => __( 'Add New Category' ),
	  'new_item_name' => __( 'New Category Name' ),
	  'menu_name' => __( 'Categories' ),
	); 
	register_taxonomy('category',array('properties'), array(
	  'hierarchical' => true,
	  'labels' => $labels,
	  'show_ui' => true,
	  'show_admin_column' => true,
	  'query_var' => true,
	  'rewrite' => array( 'slug' => 'category' ),
	));
	$labels = array(
	  'name' => _x( 'Types', 'taxonomy general name' ),
	  'singular_name' => _x( 'Type', 'taxonomy singular name' ),
	  'search_items' =>  __( 'Search Types' ),
	  'all_items' => __( 'All Types' ),
	  'parent_item' => __( 'Parent Type' ),
	  'parent_item_colon' => __( 'Parent Type:' ),
	  'edit_item' => __( 'Edit Type' ), 
	  'update_item' => __( 'Update Type' ),
	  'add_new_item' => __( 'Add New Type' ),
	  'new_item_name' => __( 'New Type Name' ),
	  'menu_name' => __( 'Types' ),
	); 
	register_taxonomy('property_type',array('properties'), array(
	  'hierarchical' => true,
	  'labels' => $labels,
	  'show_ui' => true,
	'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'property-type' ),
  ));
  $labels = array(
    'name' => _x( 'Property Statuses', 'taxonomy general name' ),
    'singular_name' => _x( 'Property Status', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Property Statuses' ),
    'all_items' => __( 'All Property Statuses' ),
    'parent_item' => __( 'Parent Property Status' ),
    'parent_item_colon' => __( 'Parent Property Status:' ),
    'edit_item' => __( 'Edit Property Status' ), 
    'update_item' => __( 'Update Property Status' ),
    'add_new_item' => __( 'Add New Property Status' ),
    'new_item_name' => __( 'New Property Status Name' ),
    'menu_name' => __( 'Property Statuses' ),
  ); 
  register_taxonomy('property_status',array('properties'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'property-status' ),
  ));
}
add_action( 'init', 'create_property_taxonomies', 0 );

function property_meta_boxes() {
  add_meta_box( 'property_meta_box',
    'Property Details',
    'display_property_meta_box',
    'properties', 'normal', 'high'
  );
}
add_action( 'add_meta_boxes', 'property_meta_boxes' );

function display_property_meta_box( $property ) {
  $property_city = esc_html( get_post_meta( $property->ID, 'property_city', true ) );
  $property_neighborhood = esc_html( get_post_meta( $property->ID, 'property_neighborhood', true ) );
  $property_country = esc_html( get_post_meta( $property->ID, 'property_country', true ) );
  $property_features = esc_html( get_post_meta( $property->ID, 'property_features', true ) );
  $property_amenities = esc_html( get_post_meta( $property->ID, 'property_amenities', true ) );
  ?>
  <table>
    <tr>
      <td style="width: 100%">City</td>
      <td><input type="text" size="80" name="property_city" value="<?php echo $property_city; ?>" /></td>
    </tr>
    <tr>
      <td style="width: 100%">Neighborhood</td>
      <td><input type="text" size="80" name="property_neighborhood" value="<?php echo $property_neighborhood; ?>" /></td>
    </tr>
   
    <tr>
      <td style="width: 100%">Country</td>
      <td><input type="text" size="80" name="property_country" value="<?php echo $property_country; ?>" /></td>
    </tr>
    <tr>
      <td style="width: 100%">Features</td>
      <td><input type="text" size="80" name="property_features" value="<?php echo $property_features; ?>" /></td>
    </tr>
    <tr>
      <td style="width: 100%">Amenities</td>
      <td><input type="text" size="80" name="property_amenities" value="<?php echo $property_amenities; ?>" /></td>
    </tr>
  </table>
  <?php
}

function add_property( $property_id, $property_data ) {
  add_post_meta( $property_id, 'property_city', $property_data['property_city'], true );
  add_post_meta( $property_id, 'property_neighborhood', $property_data['property_neighborhood'], true );
  add_post_meta( $property_id, 'property_country', $property_data['property_country'], true );
  add_post_meta( $property_id, 'property_features', $property_data['property_features'], true );
  add_post_meta( $property_id, 'property_amenities', $property_data['property_amenities'], true );
}

function update_property( $property_id, $property_data ) {
  update_post_meta( $property_id, 'property_city', $property_data['property_city'] );
  update_post_meta( $property_id, 'property_neighborhood', $property_data['property_neighborhood'] );
  update_post_meta( $property_id, 'property_country', $property_data['property_country'] );
  update_post_meta( $property_id, 'property_features', $property_data['property_features'] );
  update_post_meta( $property_id, 'property_amenities', $property_data['property_amenities'] );
}

function save_property_meta_box( $property_id, $property ) {
  if( isset( $_POST['property_city'] ) && $_POST['property_city'] != '' ) {
    $property_data['property_city'] = $_POST['property_city'];
  }
  if( isset( $_POST['property_neighborhood'] ) && $_POST['property_neighborhood'] != '' ) {
    $property_data['property_neighborhood'] = $_POST['property_neighborhood'];
  }
  if( isset( $_POST['property_country'] ) && $_POST['property_country'] != '' ) {
    $property_data['property_country'] = $_POST['property_country'];
  }
  if( isset( $_POST['property_features'] ) && $_POST['property_features'] != '' ) {
    $property_data['property_features'] = $_POST['property_features'];
  }
  
if( isset( $_POST['property_amenities'] ) && $_POST['property_amenities'] != '' ) {
  $property_data['property_amenities'] = $_POST['property_amenities'];
}

if( $property->post_status == 'publish' ) {
  update_property( $property_id, $property_data );
} else {
  add_property( $property_id, $property_data );
}
}
add_action( 'save_post', 'save_property_meta_box', 10, 2 );

// Display the custom fields on the front-end
function display_property_meta_fields( $content ) {
  global $post;

  if ( get_post_type( $post->ID ) == 'property' ) {
    $property_city = get_post_meta( $post->ID, 'property_city', true );
    $property_neighborhood = get_post_meta( $post->ID, 'property_neighborhood', true );
    $property_country = get_post_meta( $post->ID, 'property_country', true );
    $property_features = get_post_meta( $post->ID, 'property_features', true );
    $property_amenities = get_post_meta( $post->ID, 'property_amenities', true );

    $property_meta_fields = '<div class="property-meta-fields">';
    $property_meta_fields .= '<p><strong>City: </strong>' . $property_city . '</p>';
    $property_meta_fields .= '<p><strong>Neighborhood: </strong>' . $property_neighborhood . '</p>';
    $property_meta_fields .= '<p><strong>Country: </strong>' . $property_country . '</p>';
    $property_meta_fields .= '<p><strong>Features: </strong>' . $property_features . '</p>';
    $property_meta_fields .= '<p><strong>Amenities: </strong>' . $property_amenities . '</p>';
    $property_meta_fields .= '</div>';

    $content .= $property_meta_fields;
  }

  return $content;
}
add_filter( 'the_content', 'display_property_meta_fields' );
