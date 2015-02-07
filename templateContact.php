<?php get_header();?>

<?php /* Template Name: Template Contact */ ?>

<?php
// Languages
global $MyLangs;
?>

<?php
$form_msg = '';
$contact_form_error = false;
$required_fields = array ('name','email', 'message');

if ( !isset($_POST['contact_form_submit']) )
  $contact_form_error = true;
else
{
  foreach ( $required_fields as $req)
  {
    if (empty ($_POST['contact_form_'.$req]) )
    {
      $form_msg = $MyLangs->translate('form_message', 1);
      $contact_form_error = true;
    }
  }
  if ( !$contact_form_error && !is_email( $_POST['contact_form_email'] ) ) {
    $form_msg .= $MyLangs->translate('invalid_email', 1);
    $contact_form_error = true;
  }
}

if ( ! $contact_form_error && isset( $_POST['_wpnonce-contact-form-submitted'] ) && wp_verify_nonce( $_POST['_wpnonce-contact-form-submitted'], 'contact-form-submit' ) )
{
  $mail_to = esc_attr(get_site_option('admin_email'));

  $contact_form_name = sanitize_text_field( $_POST['contact_form_name'] );
  $contact_form_email = sanitize_email( $_POST['contact_form_email'] );
  $contact_form_subject = sanitize_text_field( $_POST['contact_form_subject'] );
  $contact_form_message = sanitize_text_field( $_POST['contact_form_message'] );
  
  $mail_headers = 'From: '.$contact_form_name.' <'.$contact_form_email.'>' . "\r\n";
  
  add_filter( 'wp_mail_content_type', 'set_html_content_type' );
  $test = wp_mail( $mail_to, $contact_form_subject,
  '
  <p>You received the following contact message:</p>
  <p>Name: '.$contact_form_name.'</p>
  <p>Email: '.$contact_form_email.'</p>
  <p>Subject: '.$contact_form_subject.'</p>
  <p>Message: '.$contact_form_message.'</p>',
  $mail_headers);
  
  remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

  $form_msg = $MyLangs->translate('form_success_msg', 1);
}
?>

<?php
if ( have_posts() ) while ( have_posts() ) : the_post();
?>

<div class="first-section" id="contact-page">
  <section>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-heading"><?php $MyLangs->getPostTitle();?></h2>
          
          <div class="row">
            <div class="contact-form col-xs-6">
              <?php
              $msg_color = ($contact_form_error) ? 'danger' : 'success';
              $msg_color = ($form_msg) ? $msg_color : '';
              if ( $form_msg )
              {?>
                <div id="contact-form-message" class="alert alert-<?php echo $msg_color;?>"><?php echo $form_msg;?></div>
                <?php
              }?>
              
              <address>
                5th floor, Nadim Tohme Center<br>
								Jal-el-Dib Highway, Lebanon<br>
                Office: +961 4 520528<br>
                Email: <a href="mailto:info@dachmea.com">info@dachmea.com</a>
              </address>
          
              <form class="form-inline" action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" method="post" id="contact_form_form">
                <div class="form-group">
                  <input id="contact_form_name" class="form-control" type="text" name="contact_form_name" value="<?php echo ( isset($_POST['contact_form_name']) ) ? esc_attr($_POST['contact_form_name']) : '';?>" placeholder="<?php $MyLangs->translate('fullname');?> *" />
                </div>
                <div class="form-group">
                  <input class="form-control" type="email" name="contact_form_email" value="<?php echo ( isset($_POST['contact_form_email']) ) ? esc_attr($_POST['contact_form_email']) : '';?>" placeholder="<?php $MyLangs->translate('email');?> *" id="contact_form_email" />
                </div>
                <div class="form-group">
                  <input id="contact_form_subject" class="form-control" type="text" name="contact_form_subject" value="<?php echo ( isset($_POST['contact_form_subject']) ) ? esc_attr($_POST['contact_form_subject']) : '';?>" placeholder="<?php $MyLangs->translate('subject');?>" />
                </div>
                <p><textarea rows="7" class="form-control" id="contact_form_message" name="contact_form_message" placeholder="<?php $MyLangs->translate('message');?> *"><?php echo ( isset($_POST['contact_form_message']) ) ? esc_textarea($_POST['contact_form_message']) : '';?></textarea></p>
          
                <input type="hidden" name="contact_form_submit" value="contact_form_proccess" />
                <button type="submit" class="btn btn-primary"><?php $MyLangs->translate('send');?></button>
                
                <?php wp_nonce_field( 'contact-form-submit', '_wpnonce-contact-form-submitted' ); ?>
                
              </form>
              
            </div><!-- contact form -->
            <div class="col-xs-6">
              <div id="map"></div>
            </div>
            
          </div>
      </div>
    </div>
  </section>
</div>

<?php 
endwhile;
wp_reset_query();
?>

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

  var myLatlng = new google.maps.LatLng(33.912223, 35.581532);
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

<?php get_footer(); ?>