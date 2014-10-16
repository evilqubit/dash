<!-- Developed by ACME - http://acme-lb.com -->
<?php
global $post;
$page_slug = ( isset($post) ) ? get_post($post)->post_name : '';
$page_id = ( isset($post) ) ? get_post($post)->ID : '';

// Languages
global $MyLangs;
// Verify language and set the current one
$MyLangs->verify ( $_GET['l'] );

// Home Link
$home_link = $MyLangs->getHomeUrl();
?>
<!DOCTYPE HTML>
<html lang="<?php echo $MyLangs->current_lang;?>">
<head>
<?php
// standard stuff
getHeaderStuff();
// site meta
$MyLangs->getSiteMeta();
// do stuff before wp_head()
$MyLangs->getHeadIncludesBefore();
// wp_head
wp_head();
// do stuff after wp_head()
$MyLangs->getHeadIncludesAfter();
?>
</head>

<?php
$body_id = ( is_home() ) ? 'z_home' : '';
?>

<body id="<?php echo $body_id;?>" <?php body_class( 'lang-'.$MyLangs->current_lang );?>>

<div id="wrap">

<div id="top_container">
  <div class="container">
    <div class="row">
      <div class="col-xs-3">
        <a id="logo" href="<?php echo $home_link;?>"><img class="img-responsive" src="<?php echo $MyLangs->s_d.'/assets/img/logo.jpg';?>" /></a>
      </div>
      <div class="col-xs-5 col-xs-offset-4" id="search_col">
        <div id="search">
          <form action="<?php bloginfo('url');?>" method="get">
            <div class="search">
              <input name="s" id="search_input" class="inputbox" maxlength="20" type="text" size="22" value="Search..."  onblur="if (this.value=='') this.value='Search...';" onfocus="if (this.value=='Search...') this.value='';" />
              <input type="submit" id="b" value="Search" /></input> 
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<nav class="navbar navbar-default header" role="navigation">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul class="nav navbar-nav">
        
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
    </div><!-- row -->
  </div><!-- container -->
</nav>

<div id="body_content">