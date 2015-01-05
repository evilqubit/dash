<?php get_header();?>

<?php /* Template Name: Template Solutions */ ?>

<?php
// Languages
global $MyLangs;
?>

<?php
$wp_query = new WP_Query ('post_type=solution&showposts=6');
?>

<section id="solution-page">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="page-heading">Solutions</h3>
        <div id="solutions">
          <div class="row">
            <?php
            if ( have_posts() ) while (have_posts()) : the_post();
            ?>
							<div class="col-xs-4 solution_entry">
							<div class="box solutions-box">
								<div class="head"><?php $MyLangs->getPostTitle();?></div>
								<div class="img"><a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php echo featuredImg(get_the_ID());?>" /></a></div>
								<div class="dsc"><?php the_excerpt();?></div>
								<div class="readmore"><a href="<?php the_permalink();?>">Learn More...</a></div>
							</div>
						</div>
            <?php
            endwhile;
            ?>
          </div>
          <?php
          wp_reset_query();?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>