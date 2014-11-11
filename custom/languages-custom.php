<?php
class MyLangsClass
{
  public $langs = array ( 'langs'=> array('en'=>'English'), 'default_lang'=>'en' );
  public $current_lang = '';
  public $lang_url = '';
  public $lang_url_prefix = '?l=';
  public $s_d = '';

  function __construct(){
    // try to get default language from our Wordpress Custom Settings
    $def_lang = $this->getSetting('lang_default', 1);
    $this->langs['default_lang'] = ( ( isset ($def_lang) && isset( $this->langs['langs'][$def_lang] ) ) ) ? $def_lang : $this->langs['default_lang'];
    $this->s_d = get_bloginfo('stylesheet_directory');
  }
  
  function getDefault(){
    return $this->langs['default_lang'];
  }
  
  function verify($input_lang=''){
    $lang = ( isset ($input_lang) && isset ($this->langs['langs']["$input_lang"]) ) ? $input_lang : $this->langs['default_lang'];
    
    // set current lang
    $this->current_lang = $lang;
    
    $this->lang_url = ( $this->langs['default_lang'] == $lang ) ? '' : $this->lang_url_prefix.$lang;
  }
  
  function getCurrent(){
    return $this->current_lang;
  }
  function getHeadIncludesBefore(){
    echo '<link rel="stylesheet" href="'.$this->s_d.'/assets/css/bootstrap.min.css">';
    //else
    // echo '<link rel="stylesheet" href="'.$this->s_d.'/assets/css/bootstrap-rtl.css">';
  }
  function getHeadIncludesAfter(){
    // if ( $this->current_lang == 'fr' )
      // echo '<link rel="stylesheet" href="'.$this->s_d.'/assets/css/style-fr.css?v=1.04">';
  }
  
  function getSiteMeta(){
    if ( is_single() )
      $this->getSingleMeta();
   else
    $this->getGeneralMeta();
  }
  
  function getPostContentText($content_array){
    return isset($content_array['content']) ? $content_array['content'] : '';
  }
  function getSingleMeta(){
    global $post;
    $postImage = featuredImg( $post );
    $description = $this->getPostContentText ( $this->getPostContent(20, 1) );
    $title = cleanMeta ( $this->getPostTitle (1) );
    ?>
    <title><?php echo $title.' | '.$this->getSetting('site_name', 1)?></title>
    <meta name="keywords" content="<?php $this->getSetting('site_keywords');?>" />
    <meta name="description" content="<?php echo cleanMeta($description);?>" />
    <meta property="og:title" content="<?php echo $title?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo get_permalink($post->ID);?>" />
    <meta property="og:description" content="<?php echo cleanMeta($description);?>" />
    <meta property="og:image" content="<?php echo $postImage;?>" />
    <?php
  }
  function getGeneralMeta(){
    global $post;
    $description = $this->getSetting ('site_description', 1);
    $permalink = (is_home()) ? $this->getHomeUrl() : get_permalink($post->ID);
    $p_title = (is_home()) ? $this->translate('menu_home', 1) : $this->getPostTitle(1);
    $postImage = featuredImg($post);
    ?>
    <title><?php echo $p_title.' | '.$this->getSetting('site_name', 1);?></title>
    <meta name="description" content="<?php echo cleanMeta($description);?>" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo cleanMeta($p_title);?>" />
    <meta property="og:url" content="<?php echo $permalink;?>" />
    <meta property="og:description" content="<?php echo cleanMeta($description);?>" />
    <meta property="og:image" content="<?php echo $postImage;?>" />
    <?php
  }
  
  function getSetting ($setting_key, $return='', $extra=''){
    $prefix = 'psettings_';
    $setting_key = $prefix.$setting_key;
    
    // Test if we find the language setting
    // example: "site_name_ar"
    // if we dont find a value for that, we go for "site_name"
    $old_key = $setting_key;
    $setting_key .= '_'.$this->current_lang;
    $found_value = ( get_option($setting_key) != '' ) ? 1 : 0;
    
    // revert to old key if we dont find a setting value for the current language
    $setting_key = !$found_value ? $old_key : $setting_key;
    
    $output = stripslashes ( get_option ($setting_key) );
    if ( $extra == 'html' )
      $output = wpautop($output);
      
    if ($return!='') return $output;
    else echo $output;
  }
  
  function getCatName ($cat_id, $echo=''){
    $output = get_option ('cat_'.$cat_id);
    $output = ( isset($output['cat_'.$this->current_lang.'_name']) ) ? $output['cat_'.$this->current_lang.'_name'] : get_the_category_by_ID($cat_id);
     
    if ( isset($echo) && $echo != '' )
      echo $output;
    else
      return $output;
  }
  
  // custom
  function doMyCats ($categories){
    if ($categories){?>
      <div class="cats">
        <?php
        foreach ($categories as $cat){
          echo '<a class="label label-primary" href="'.esc_url($cat['link']).'">'.$this->getCatName($cat['id']).'</a>';
        }
        ?>
      </div><?php
    }
  }
  
  // Get categories of a post
  function getPostCats ( $post_id ){
    $post_categories = wp_get_post_categories( $post_id );
    $cats = array();
    foreach($post_categories as $c_id){
      $cat = get_category( $c_id );
      $category_link = get_category_link( $c_id ).$this->getLangUrl();      
      $cats[] = array( 'id'=>$c_id, 'name' => $cat->name, 'slug' => $cat->slug, 'link' => $category_link );
    }
    return $cats;
  } 
  
  function translate ($key, $return=''){
    $translations = array (
    
    'menu_home'=>array('en'=>'Home'),
    '404_head'=>array('en'=>'404 - Page not found'),
    '404_back'=>array('en'=>'Back to Home'),
    '404_msg'=>array('en'=>'The Page you are looking for doesn\'t exist'),
    'contact_us'=>array('en'=>'Contact Us'),
    'fullname'=>array('en'=>'Fullname'),
    'email'=>array('en'=>'Email'),
    'subject'=>array('en'=>'Subject'),
    'message'=>array('en'=>'Message'),
    'form_message'=>array('en'=>'Fields marked with * are required.'),
    'invalid_email'=>array('en'=>'Invalid Email.'),
    'form_success_msg'=>array('en'=>'Thank you for applying, we will be in touch.'),
    'send'=>array('en'=>'Send'),
    'apply'=>array('en'=>'Apply')
    ); // end translations array
    
    if ( $return != '')
      return (isset($translations[$key][$this->current_lang])) ? $translations[$key][$this->current_lang] : '';
    else
      echo (isset($translations[$key][$this->current_lang])) ? $translations[$key][$this->current_lang] : '';
  }
  
  function getPostTitle ($return=''){    
    $output = get_field('title_'.$this->current_lang);
    
    if ( $output == '' )
      $output = get_the_title();
    
    if ( isset($return) && $return != '' )
      return $output;
    else
      echo $output;
  }
  
  function getPostContent ($excerpt_length=0, $return=''){
    $final_output = '';
    
    $output = get_field('content_'.$this->current_lang);
    $extra_text = '';
    
    $permalink = get_the_permalink();
    $url = $permalink.$this->lang_url_prefix.$this->current_lang;
    
    if ( $output == '' ){
      foreach ($this->langs['langs'] as $general_lang_key=>$lang_name){
        if ( $this->current_lang != $general_lang_key )
        {
          if ( $output == '' ){
            $output = get_field('content_'.$general_lang_key);
          }
        }
      }
    }
    
    // We check if we gave the function an excerpt parameter
    // we get the excerpt
    // we add extra text after it (text that might include HTML that excerpts remove by default)
    $final_output = ( $excerpt_length > 0 ) ? my_excerpt ($output, $excerpt_length).$extra_text : $output;
    
    if ( isset($return) && $return != '' )
      return $final_output;
    else
      echo $final_output;
  }
  
  function getPageTitle ($page_object){
    $p_title = get_field ('title_'.$this->current_lang, $page_object->ID);
    echo ( isset ($p_title) ) ? $p_title : $page_object->post_title;
  }
  
  function getLangUrl ($echo=''){
    if ( $echo != '' )
      echo $this->lang_url;
    else
      return $this->lang_url;
  }
  
  function getHomeUrl ($echo='', $middle_link=''){
    $output = get_bloginfo('url').$middle_link.$this->getLangUrl();
    if ( $echo != '' )
      echo $output;
    else
      return $output;
  }
  
  function doLangActive ($input_lang){
    echo ( $input_lang == $this->current_lang ) ? 'active' : '';
  }
  
  function replaceArabicNum ($input){
    $english = array('0','1','2','3','4','5','6','7','8','9');
    $arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
    return str_replace($english, $arabic, $input);
  }
  
}
$MyLangs = new MyLangsClass();
?>