<?php get_header();?>

<?php
if ( have_posts() ) while (have_posts()) : the_post();
// $term_list = wp_get_post_terms(get_the_ID(), 'products_categories', array("fields" => "all"));
?>

<section id="single-page">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-heading"><?php $MyLangs->getPostTitle();?></h2>
        <?php
        /* if ( isset ($term_list) && !empty ($term_list) )
        {
          foreach ($term_list as $post_term){
            $final .= '<a href="'.get_term_link ($post_term->slug, 'products_categories').'">'.$post_term->name.'</a>, ';
          }
          echo '<div class="product-cats">In '.rtrim ($final, ', ').'</div>';
        } */
        ?>
        <div class="row">
          <div class="col-xs-12">
            <div class="post_content"><?php $MyLangs->getPostContent();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
endwhile;
wp_reset_query();
?>

<?php get_footer(); ?>