<?php get_header();?>
<?php
// Languages
global $MyLangs;
?>

<?php
$wp_query = new WP_Query('post_type=slider');
?>
<section class="homepage_slider">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul class="rslides">
          <?php
          if (have_posts()) while (have_posts()) : the_post();
          $post_img = featuredImg (get_the_ID());
          ?>
          <li>
            <a href="#">
              <img src="<?php echo $post_img;?>" />
            </a>
            <figcaption>
              <div>
                <h2><a href="#"><?php $MyLangs->getPostTitle();?></a></h2>
              </div>
            </figcaption>
           </li>
           <?php
           endwhile; wp_reset_query();
           ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<script>
  $(function() {
    $(".rslides").responsiveSlides({
      auto: true,
      speed: 500,
      timeout: 4000,
      pager: true,
      nav: false,
      pause: true,
      namespace: "centered-btns"
    });
  });
</script>

<section id="features">
  <div class="container">
    <div class="row">
      <div class="col-xs-4">
        <div class="box products-box">
          <div class="head">Products</div>
          <div class="dsc"><?php $MyLangs->getSetting('products_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/products';?>">Learn More...</a></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="box services-box">
          <div class="head">Services</div>
          <div class="dsc"><?php $MyLangs->getSetting('services_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/services';?>">Learn More...</a></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="box clients-box">
          <div class="head">Clients</div>
          <div class="dsc"><?php $MyLangs->getSetting('clients_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/clients';?>">Learn More...</a></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();?>