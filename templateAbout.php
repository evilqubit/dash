<?php get_header();?>

<?php /* Template Name: Template About */ ?>

<?php
// Languages
global $MyLangs;
?>

<?php 
if (have_posts()) while (have_posts()) : the_post();
?>

<section id="developer">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-heading"><?php $MyLangs->getPostTitle();?></h2>
        <div class="post_content">
          <?php $MyLangs->getPostContent();?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
endwhile;
?>

<?php get_footer(); ?>