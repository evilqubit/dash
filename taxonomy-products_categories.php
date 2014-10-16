<?php get_header();?>

<?php
// Languages
global $MyLangs;
?>

<?php
$term_slug = '';
$current_term = '';
if ( get_query_var ('term' ) )
{
  $term_slug = get_query_var( 'term' );
  $taxonomyName = get_query_var( 'taxonomy' );
  $current_term = get_term_by( 'slug', $term_slug, $taxonomyName );
}
?>

<?php
$args = array(
  'post_type' => 'product',
  'tax_query' => array(
    array(
      'taxonomy' => 'products_categories',
      'field'    => 'slug',
      'terms'    => sanitize_title($term_slug),
    ),
  ),
);
$wp_query = new WP_Query( $args );
?>

<section id="products-page">
  <div class="container">
    <div class="row">
      <?php get_template_part ('usable_products_sidebar');?>
      <div class="col-xs-8">
        <h3 class="page-heading">Products | <?php echo $current_term->name;?></h3>
        <div id="products">
          <div class="row">
            <?php
            if ( have_posts() ) while (have_posts()) : the_post();
            ?>
              <div class="col-xs-4">
                <div class="image">
                  <a href="<?php the_permalink();?>">
                    <img class="img-responsive" src="<?php echo featuredImg(get_the_ID());?>" />
                  </a>
                </div>
                <h4 class="title">
                  <a href="<?php the_permalink();?>"><?php $MyLangs->getPostTitle();?></a>
                </h4>
              </div>
            <?php
            endwhile;
            wp_reset_query();
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>