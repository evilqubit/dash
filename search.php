<?php get_header();?>

<?php
// Languages
global $MyLangs;
?>

<?php
$posts_per_page = 6;
$wp_query = new WP_Query ('post_type=product&posts_per_page='.$posts_per_page.'&paged='.$paged.'&s='.$s);
?>

<section id="products-page" class="products-search">
  <div class="container">
    <div class="row">
      <?php get_template_part ('usable_products_sidebar');?>
      <div class="col-xs-8">
        <h3 class="page-heading">Search results for "<?php echo $s;?>"</h3>
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
            ?>
          </div>
          <?php
          my_pagination();
          wp_reset_query();?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>