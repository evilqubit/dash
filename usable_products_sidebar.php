<?php
$customPostTaxonomies = get_object_taxonomies('product');
$my_terms = array();
if(count($customPostTaxonomies) > 0)
{
  foreach($customPostTaxonomies as $tax){
    $my_terms = get_terms( $tax, '' );
  }
}?>

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

<div class="col-xs-4">
  <ul class="list-group">
    <li class="list-group-item">
      <span class="badge"></span>
      <a href="<?php echo get_bloginfo('url').'/products';?>">> All Products</a>
    </li>
    <?php
    foreach ($my_terms as $cat)
    {
      $selected = ( $term_slug == $cat->slug ) ? 'active' : '';
      ?>
      <li class="list-group-item <?php echo $selected;?>">
        <span class="badge"><?php echo $cat->count;?></span>
        <a href="<?php echo get_term_link ($cat->slug, 'products_categories');?>"><?php echo $cat->name;?></a>
      </li>
     <?php
    }
    ?>
  </ul>
</div>