<?php
/* Wordpress Backend Customizations */
include (TEMPLATEPATH.'/custom/dashboard-custom.php');

/* Wordpress General functions */
include (TEMPLATEPATH.'/custom/general-custom.php');

/* Languages Functions */
include (TEMPLATEPATH.'/custom/languages-custom.php');

/* Settings Custom */
include (TEMPLATEPATH.'/custom/settings-custom.php');

/* Menus */
register_nav_menus(array(
	'top-menu' => 'Main Menu'
));

add_action('init','myRemAdBar');

/* Scripts */
add_action( 'wp_enqueue_scripts', 'myThemeScripts');
function myThemeScripts (){
  $template_dir = get_template_directory_uri();

  wp_deregister_script ('jquery');
  wp_register_script ('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js', false, '2.0.0', false);
  wp_enqueue_script ('jquery');
  
  wp_enqueue_script ('bootstrap', $template_dir . '/assets/js/bootstrap.min.js', array('jquery'), '', true);
  wp_enqueue_script ('responsiveslides.min', $template_dir . '/assets/js/responsiveslides.min.js', array('jquery'), '', true);
  wp_enqueue_script ('scripts', $template_dir . '/assets/js/scripts.js', array('jquery'), '1.05', true);

  wp_enqueue_style ('bootstrap', $template_dir . '/assets/css/bootstrap.min.css');
  wp_enqueue_style ('raleway', 'http://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800');
  wp_enqueue_style ('main', $template_dir.'/style.css', array(), '1.01');
}

/* Custom post types */
add_action( 'init', 'create_custom_posts' );
function create_custom_posts () {
  register_post_type( 'product',
    array(
      'labels' => array(
        'name' => __( 'Products' ),
        'singular_name' => __( 'Product' )
      ),
    'public' => true,
    'supports' => array ('title', 'editor', 'thumbnail', 'custom-fields', 'taxonomy')
    )
  );
  register_taxonomy(
    'products_categories',
    'product',
    array(
      'labels' => array(
         'name' => 'Products Categories',
         'add_new_item' => 'Add New Product Category',
         'new_item_name' => "New Product Category"
      ),
      'rewrite'=> array ('slug'=>'products.category'),
      'show_ui' => true,
      'show_tagcloud' => false
    )
 	);
  register_post_type( 'service',
    array(
      'labels' => array(
        'name' => __( 'Services' ),
        'singular_name' => __( 'Service' )
      ),
    'public' => true,
    'supports' => array ('title', 'editor', 'thumbnail', 'custom-fields')
    )
  );
  register_post_type( 'slider',
    array(
      'labels' => array(
        'name' => __( 'Sliders' ),
        'singular_name' => __( 'Slider' )
      ),
    'public' => true,
    'supports' => array ('title', 'editor', 'thumbnail', 'custom-fields'),
    'exclude_from_search' => true,
    'publicly_queryable' => false
    )
  );
}
?>