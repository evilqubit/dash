<?php
function register_my_site_settings(){
  $page = add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'customsettings', 'custom_settings', '', '2.66' );
  add_action( 'load-'.$page, 'register_my_site_add_scripts' );
}
function register_my_site_add_scripts(){
  $template_dir = get_template_directory_uri();
  wp_enqueue_script( 'jquery-ui-core' );
  wp_enqueue_script( 'jquery-ui-tabs' );
  wp_enqueue_script( 'jquery-ui-demo', $template_dir.'/assets/jquery-ui/jquery-ui-demo.js', array( 'jquery-ui-core' ), '1.01' );
  wp_enqueue_style ( 'jquery-ui-css', $template_dir.'/assets/jquery-ui/jquery-ui-fresh.css' );
}


function custom_settings(){
  if (!current_user_can('manage_options')) {
    WP_die( __('You do not have sufficient permissions to access this page.') );
  }
  
  wp_enqueue_media();
  
  $hidden_field_name = 'submit_hidden';

  $fields = array (
    'Home'=>array(
      'fields'=>array(
        'solutions_page_excerpt_en'=>array(
          'default'=>'Lorem ipsum dolor sit amet',
          'type'=>'input',
          'title'=>'Solutions Homepage Box Description'
        ),
        'services_page_excerpt_en'=>array(
          'default'=>'Lorem ipsum dolor sit amet',
          'type'=>'input',
          'title'=>'Services Homepage Box Description'
        ),
        'about_page_excerpt_en'=>array(
          'default'=>'Lorem ipsum dolor sit amet',
          'type'=>'input',
          'title'=>'About Homepage Box Description'
        ),
				'solutions_page_image'=>array(
          'default'=>'',
          'type'=>'uploader',
          'title'=>'Solutions Homepage Box Image'
        ),
        'services_page_image'=>array(
          'default'=>'',
          'type'=>'uploader',
          'title'=>'Services Homepage Box Image'
        ),
        'about_page_image'=>array(
          'default'=>'',
          'type'=>'uploader',
          'title'=>'About Homepage Box Image'
        )
      )// fields
    )// setting
    ,
    'Languages'=>array(
      'fields'=>array(
        'lang_default'=>array(
          'default'=>'en',
          'type'=>'select',
          'choices'=>array('en'=>'English'),
          'title'=>'Site Default Language'
        )
      )// fields
    )// setting
    ,
    'Site'=>array(
      'fields'=>array(
        'site_keywords_en'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Site Keywords (English)'
        ),
        'site_name_en'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Site Name (English)'
        ),
        'site_description_en'=>array(
          'default'=>'',
          'type'=>'textarea',
          'title'=>'Site Description (English)'
        )
      )// fields
    )// setting
    ,
    'Social'=>array(
      'fields'=>array(
        'facebook_link'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Facebook Link'
        ),
        'twitter_link'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Twitter Link'
        ),
        'linkedin_link'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'LinkedIn Link'
        )
      )// fields
    )// setting
    ,
    'Contact'=>array(
      'fields'=>array(
        'contact_email'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Contact Email'
        ),
        'contact_phone'=>array(
          'default'=>'',
          'type'=>'input',
          'title'=>'Contact Phone Number'
        ),
        'contact_address'=>array(
          'default'=>'',
          'html'=>1,
          'type'=>'textarea',
          'title'=>'Contact Adresss'
        )
      )// fields
    )// setting

  );
  
  $check_for_key = array();
  $key_prefix = 'psettings_';
  
  foreach ($fields as $f){
    foreach ($f['fields'] as $fk=>$fv){
      $fk = $key_prefix.$fk;
      
      if ( !isset ($check_for_key[$fk]) ){
        $check_for_key[$fk] = 1;
        ${$fk} = ( get_option($fk) ) ? get_option($fk) : $fv['default'];
      }
    }
  }

  if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    $check_for_key = array();
    foreach ($fields as $f){
      foreach ($f['fields'] as $fk=>$fv){
        $fk = $key_prefix.$fk;

        if ( !isset ($check_for_key[$fk]) ){
          $check_for_key[$fk] = 1;
          ${$fk} = ( isset($_POST[$fk]) && $_POST[$fk] != '' ) ? $_POST[$fk] : '';
          ${$fk} = ( isset ($fv['force_default']) && ${$fk} == '' ) ? $fv['default'] : ${$fk};
          // check if html allowed
          if ( !isset($fv['html']) ){
            ${$fk} = esc_html (${$fk});
            update_option($fk, ${$fk});
          }
          else{
            update_option($fk, stripslashes(wp_filter_post_kses(addslashes(${$fk}))));
          }
        }
      }
    }
    ?>		
    <div class="updated"><p><strong>Settings saved</strong></p></div>
    <?php
  }
  ?>
  
  <form method="post" action="">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y" />
    <h3>Edit Custom Settings</h3>
    <h5>Don't forget to save all changes when you're done!</h5>
    <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save All Changes') ?>" />
    <div id="psettingsTabs">
      <ul>
        <?php
        foreach ($fields as $field_k=>$field_v)
        {?>
          <li><a href="#tabs-<?php echo str_replace(' ','-',$field_k);?>"><?php echo $field_k;?></a></li><?php
        }?>
      </ul>
      <?php
      $check_for_key = array();
      foreach ($fields as $field_k=>$field_v)
      {?>
        <div id="tabs-<?php echo str_replace(' ','-',$field_k);?>">
          <div class="custom-table">
            <?php
            foreach ($field_v['fields'] as $fk=>$fv){
              if ( !isset ($check_for_key[$fk]) )
              {
                $fk = $key_prefix.$fk;
                $check_for_key[$fk] = 1;
                
                $force_default = ( isset ($fv['force_default']) ) ? '* ' : '';
                  
                echo '<div class="field-title">'.$force_default.$fv['title'].'</div>';?>
                <?php
                switch ($fv['type']):
                  default:
                  case 'input':?>
                    <input type="text" name="<?php echo esc_attr($fk);?>" value="<?php echo stripslashes(esc_attr(${$fk}));?>"/>
                    <?php
                  break;
                  case 'select':?>
                    <select name="<?php echo esc_attr($fk);?>"><?php
                      if ( isset ($fv['choices']) ){
                        $selected_value = ${$fk};
                        $found = 0;
                        foreach ($fv['choices'] as $c_k=>$c_v){
                          $selected = ( $selected_value == $c_k ) ? 'selected' : '';
                          if ( $selected == 'selected')
                            $found = 1;
                          
                          if ( !$found ){
                            $selected = ( isset($fv['default']) && $fv['default'] == $c_k ) ? 'selected' : '';
                          }
                          ?>
                          <option <?php echo $selected;?> value="<?php echo esc_attr($c_k);?>"><?php echo stripslashes(esc_attr($c_v));?></option><?php
                        }
                      }?>
                    </select><?php
                  break;
                  case 'textarea':
                    $editor_settings =  array (
                   'textarea_rows' => 5
                   , 'media_buttons' => FALSE
                   , 'teeny' => TRUE
                   , 'tinymce' => FALSE
                   , 'quicktags' => array ( 'buttons' => 'link' )
                   );
                   wp_editor( stripslashes(esc_textarea(${$fk})), esc_attr($fk), $editor_settings );
                  break;
                   case 'uploader':
                   ?>
                   <div class="uploader">
                      <label id="my-label-<?php echo esc_attr($fk);?>"><?php echo ( stripslashes(esc_attr(${$fk})) ) ? '' : 'Please upload a file for this field';?></label>
                      <?php if ( stripslashes(esc_attr(${$fk})) != '' ){?>
                        <img class='custom-table-image image-exists' id="my-image-<?php echo esc_attr($fk);?>" src="<?php echo stripslashes(esc_attr(${$fk}));?>" /><?php
                      }
                      else{?>
                         <img class='custom-table-image' id="my-image-<?php echo esc_attr($fk);?>" src="" /><?php
                      }?>
                       
                      <input type="hidden" name="<?php echo esc_attr($fk);?>" id="my-field-<?php echo esc_attr($fk);?>" value="<?php echo stripslashes(esc_attr(${$fk}));?>" />
                      <input data-key="<?php echo esc_attr($fk);?>" class="button custom-table-upload-button" name="custom-table-upload-button" value="Upload" />
                    </div>
                    <script>
                  jQuery(document).ready(function(){
                    jQuery('.custom-table-upload-button').click(function(){
                      var myKey = jQuery(this).attr('data-key');
                      wp.media.editor.send.attachment = function(props, attachment){
                        jQuery('#my-field-' + myKey).val(attachment.url);
                        jQuery('#my-label-' + myKey).html(attachment.url);
                        jQuery('#my-image-' + myKey).attr('src',attachment.url).addClass('image-exists');
                      }
                      wp.media.editor.open(this);
                      return false;
                    });
                  });
                 </script>
                    <?php
                   break;
                 endswitch;
                }
              }
              ?>
          </div>
        </div><?php
      }
      ?>
    </div><!-- psettings tabs -->
    
  </form>
<?php
}

add_action( 'admin_menu', 'register_my_site_settings' );
?>