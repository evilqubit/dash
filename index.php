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
      <div class="col-xs-6">
        <div class="box">
          <div class="head">Solutions</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/solutions';?>"><img class="img-responsive" src="<?php $MyLangs->getSetting('solutions_page_image');?>" /></a></div>
          <div class="dsc"><?php $MyLangs->getSetting('solutions_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/solutions';?>">Learn More...</a></div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="box">
          <div class="head">Services</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/services';?>"><img class="img-responsive" src="<?php $MyLangs->getSetting('services_page_image');?>" /></a></div>
          <div class="dsc"><?php $MyLangs->getSetting('services_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/services';?>">Learn More...</a></div>
        </div>
      </div>
    </div>
		<div class="row">
      <div class="col-xs-12">
        <div class="box box-about clearfix">
          <div class="head">About Us</div>
          <div class="img"><a href="<?php echo get_bloginfo('url').'/services';?>"><img class="img-responsive" src="<?php $MyLangs->getSetting('about_page_image');?>" /></a></div>
				<div class="dsc"><?php $MyLangs->getSetting('about_page_excerpt');?></div>
          <div class="readmore"><a href="<?php echo get_bloginfo('url').'/about';?>">Learn More...</a></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer();?>