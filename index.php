<?php get_header();?>
<?php
// Languages
global $MyLangs;
?>

<?php
// $wp_query = new WP_Query('post_type=slider');
?>

<script>
  // $(function() {
    // $(".rslides").responsiveSlides({
      // auto: true,
      // speed: 500,
      // timeout: 4000,
      // pager: true,
      // nav: false,
      // pause: true,
      // namespace: "centered-btns"
    // });
  // });
</script>

<section id="features">
  <div class="container">
    <div class="row">
      <div class="col-xs-4">
        <div class="box">
          <div class="head">Products</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/products';?>"><img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/test.jpg" /></a></div>
          <div class="dsc"><?php $MyLangs->getSetting('products_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/products';?>">Learn More...</a></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="box">
          <div class="head">Services</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/services';?>"><img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/test.jpg" /></a></div>
          <div class="dsc"><?php $MyLangs->getSetting('services_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/services';?>">Learn More...</a></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="box">
          <div class="head">Clients</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/clients';?>"><img class="img-responsive" src="<?php bloginfo('stylesheet_directory');?>/assets/img/test.jpg" /></a></div>
          <div class="dsc"><?php $MyLangs->getSetting('clients_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/clients';?>">Learn More...</a></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();?>