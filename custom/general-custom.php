<?php
add_theme_support('post-thumbnails');

function remove_acf_menu(){
  if( !current_user_can ('manage_options') ){
    remove_menu_page('edit.php?post_type=acf');
  }
}
add_action( 'admin_menu', 'remove_acf_menu', 999 );

function my_sd(){
  bloginfo('stylesheet_directory');
}
function wphidenag() {
  remove_action( 'admin_notices', 'update_nag', 3 );
}
function myRemAdBar(){
  remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
  function my_frontend_adbar() {echo '<style>html, * html body{margin-top:0 !important}</style>';}
  add_filter('wp_head','my_frontend_adbar', 99);
  if ( !is_admin() ){
    wp_deregister_script('admin-bar');
    wp_deregister_style('admin-bar');
  }
}
function set_html_content_type() {
  return 'text/html';
}
function my_excerpt($text, $text_length = 20){
  $text = str_replace(']]>', ']]&gt;', $text);
  $text = strip_tags($text);
 
  $words = explode(' ', $text, $text_length + 1);

  if (count($words)> $text_length){
    array_pop($words);
    array_push($words, '...');
    $text = implode(' ', $words);
  }
  return $text;
}

/* Pagination - Bootstrap compatible */
function my_pagination($offset=''){
	if( is_singular() )
		return;

	global $wp_query;
	$qu = $wp_query->query_vars;

	// Trick for offset and pagination
	if ($offset){
		$showposts = $qu['showposts'];
		$wp_query->found_posts = $wp_query->found_posts - $offset;
		$wp_query->max_num_pages = ceil($wp_query->found_posts / $showposts);
	}

	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="row"><div class="col-sm-12"><ul class="pagination">';

	if ( get_previous_posts_link() )
		printf( '<li>%s</li>', get_previous_posts_link('Back') );

	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( 1 ) ), '1' );

	}

	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	if ( ! in_array( $max, $links ) ) {
		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>', $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	if ( get_next_posts_link() )
		printf( '<li>%s</li>', get_next_posts_link('Next') );

	echo '</ul></div></div>';
}

function getHeaderStuff (){
  ?>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type')?>; charset=<?php bloginfo('charset');?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="robots" content="noindex, nofollow">
  <link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
  <link rel="shortcut icon" type="image/png" href="<?php my_sd();?>/assets/img/favicon.png?v=1.00" />
  <link rel="apple-touch-icon" href="<?php my_sd();?>/assets/img/favicon-touch.png?v=1.00" />
  <?php
}

function cleanMeta ($s){
	return cleanHTML(str_replace(array('\n','\r'),'',$s));
}
function cleanHTML($input){
  $input = htmlspecialchars($input, ENT_QUOTES);
  return $input;
}
function featuredImg($post){
  $template_dir = get_template_directory_uri();
  $postImage = ( isset ($post) ) ? wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full') : '';
  return ($postImage!='') ? $postImage[0] : $template_dir.'/assets/img/default_fb.jpg';
}
function my_cf ($key){
  $custom_field = ( get_field($key) != '' ) ? get_field($key) : '';
  echo $custom_field;
}
function get_my_cf ($key){
  $custom_field = ( get_field($key) != '' ) ? get_field($key) : '';
  return $custom_field;
}
?>