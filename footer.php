</div> <!-- #body_content -->

<div class="push"></div>
</div>

<?php
// Languages
global $MyLangs;
?>

<!--<section class="footer">  
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
        
          <li class="<?php echo (is_home()) ? 'active' : '';?>">
            <a href="<?php echo $home_link;?>"><?php $MyLangs->translate('menu_home');?></a>
          </li>
          
          <?php
          // exclude pages
          $local = 1;
          $exclude_pages = ($local) ? '' : '';

          // exclude live page. 128
          $all_pages = get_pages('sort_column=menu_order&parent=0&exclude='.$exclude_pages);

          foreach ($all_pages as $page)
          {
            $permalink = get_permalink($page->ID);
            $selected = ($page_slug == $page->post_name) ? 'active' : '';
            ?>
            <li class="<?php echo $selected;?>">
              <a href="<?php echo $permalink;?>"><?php $MyLangs->getPageTitle($page);?></a>
            </li>
            <?php
          }?>
        </ul>
      </div>
    </div>
  </div> 
</section>
-->
<section class="npd sub-footer">  
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="copyrights">Copyrights &copy; <?php echo date('Y', time());?></div>
      </div>
    </div>
  </div> 
</section>

<?php wp_footer();?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init() {
  var pinColor = "005395";
  var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
      new google.maps.Size(21, 34),
      new google.maps.Point(0,0),
      new google.maps.Point(10, 34));
  var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
      new google.maps.Size(40, 37),
      new google.maps.Point(0, 0),
      new google.maps.Point(12, 35));

  var myLatlng = new google.maps.LatLng(46.24546, 6.095548);
  var mapOptions = {
     zoom: 14,
     scrollwheel: false,
     center: myLatlng};
  var mapElement = document.getElementById('map');
  var map = new google.maps.Map(mapElement, mapOptions);

    marker = new google.maps.Marker({
    position: myLatlng,
    map: map,
    title: 'Dach',
    icon: pinImage,
    shadow: pinShadow
    });
	
}
</script>

</body>
</html>