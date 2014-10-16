<?php get_header(); ?>
<?php
// Languages
global $MyLangs;
?>
<?php if (have_posts()) while (have_posts()) : the_post();?>

<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 centered">
        <h2><?php $MyLangs->getPostTitle();?></h2>
      </div>
      <div class="col-xs-8 col-xs-offset-2">
        <?php
        $content = $MyLangs->getPostContent();
        echo $content['content'];
        ?>
      </div>
    </div>
  </div>
<section>

<?php endwhile;?>

<?php get_footer(); ?>