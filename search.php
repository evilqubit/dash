<?php get_header();?>

<?php
// Languages
global $MyLangs;
global $wpdb;
?>

<?php
$querystr="
	SELECT $wpdb->posts.*, $wpdb->postmeta.*
	FROM $wpdb->posts
	LEFT JOIN $wpdb->postmeta ON $wpdb->posts.id = $wpdb->postmeta.post_id
	WHERE
	( $wpdb->posts.post_type = 'solution' AND
	( $wpdb->postmeta.meta_key = 'content_en' OR $wpdb->postmeta.meta_key = 'title_en' ) AND $wpdb->postmeta.meta_value LIKE '%$s%' )
	OR (
	( $wpdb->postmeta.meta_key = 'content_en' OR $wpdb->postmeta.meta_key = 'title_en' ) AND $wpdb->posts.post_type ='page' AND $wpdb->postmeta.meta_value LIKE '%$s%' )
";

$pageposts = $wpdb->get_results($querystr, OBJECT_K);
?>

<section id="solution-page">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h3 class="page-heading">Search results for "<?php echo $s;?>"</h3>
        <div id="search-entries">
          <div class="row">
						<ul style="margin-left: 15px">
            <?php
						foreach ($pageposts as $post): setup_postdata($post);
            ?>
							<li>- <a href="<?php the_permalink();?>"><?php $MyLangs->getPostTitle();?></a></li>
            <?php
            endforeach;
            ?>
						</ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>