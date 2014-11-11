<?php get_header();?>

<?php /* Template Name: Template Careers */ ?>

<?php
// Languages
global $MyLangs;
?>

<?php
$vacancies = array();
$wp_query = new WP_Query ('post_type=career');
while ( have_posts() ) : the_post();
	$vID = get_the_ID();
	$vacancies["$vID"] = $MyLangs->getPostTitle(1);
endwhile;
wp_reset_query();
?>

<?php
$form_msg = '';
$form_error = false;
$required_fields = array ('fullname','email','message', 'job');

if ( !isset($_POST['form_submit']) )
  $form_error = true;
else
{
  foreach ( $required_fields as $req)
  {
    if (empty ($_POST['form_'.$req]) )
    {
      $form_msg = $MyLangs->translate('form_message', 1);
      $form_error = true;
    }
  }
  if ( !$form_error && !is_email( $_POST['form_email'] ) ) {
    $form_msg .= $MyLangs->translate('invalid_email', 1);
    $form_error = true;
  }
  if ( !$form_error ){
		$up_resume = $_FILES['form_resume'];
		
		if ( ! function_exists( 'wp_handle_upload' ) ) 
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			
		$upload_overrides = array( 'test_form' => false );
		$form_resume = wp_handle_upload( $up_resume, $upload_overrides );
		if ( $form_resume['url'] != '' ) {
			$form_resume = $form_resume['url'];
		}
		else {
			$form_msg = 'Please upload your resume.';
			$form_error = true;
		}
  }
	if ( !$form_error ){
		$form_job_id = $_POST['form_job'];
		if ( !isset ($vacancies[$form_job_id]) ){
			$form_msg = 'Please select a valid job vacancy.';
			$form_error = true;
		}
  }
}

if ( ! $form_error && isset( $_POST['_wpnonce-contact-form-submitted'] ) && wp_verify_nonce( $_POST['_wpnonce-contact-form-submitted'], 'contact-form-submit' ) )
{
  $mail_to = esc_attr(get_site_option('admin_email'));

  $form_fullname = sanitize_text_field( $_POST['form_fullname'] );
  $form_email = sanitize_email( $_POST['form_email'] );
  $form_message = sanitize_text_field( $_POST['form_message'] );
	$form_job = $vacancies[$form_job_id];
  
  $mail_headers = 'From: '.$form_fullname.' <'.$form_email.'>' . "\r\n";
  
  add_filter( 'wp_mail_content_type', 'set_html_content_type' );
  $test = wp_mail( $mail_to, 'Job Applicant',
  '
  <p>You received a new Job Application:</p>
  <p>Fullname: '.$form_fullname.'</p>
  <p>Email: '.$form_email.'</p>
	<p>Applying for: '.$form_job.'</p>
  <p>Message: '.$form_message.'</p>
	<p>View Resume: '.$form_resume.'</p>',
  $mail_headers);
  
  remove_filter ( 'wp_mail_content_type', 'set_html_content_type' );

  $form_msg = $MyLangs->translate('form_success_msg', 1);
}
?>

<div class="first-section" id="careers-page">
  <section>
    <div class="container">
      <div class="row">
				<?php
				if ( have_posts() ) while ( have_posts() ) : the_post();
					$pageTitle = $MyLangs->getPostTitle(1);
				endwhile;
				wp_reset_query();
				?>
				<div class="contact-form col-xs-6">
					<h2 class="page-heading"><?php echo $pageTitle;?></h2>
					<?php
					$msg_color = ($form_error) ? 'danger' : 'success';
					$msg_color = ($form_msg) ? $msg_color : '';
					if ( $form_msg )
					{?>
						<div id="contact-form-message" class="alert alert-<?php echo $msg_color;?>"><?php echo $form_msg;?></div>
						<?php
					}?>
					
					<?php
				
					if ( count ($vacancies) > 0 ){
						?>
						<h4>Available Vacancies: </h4>
						<?php
					foreach ($vacancies as $vacancyTitle){
						?>
						<p>- <?php echo $vacancyTitle;?></p>
						<?php
					}
					}
					else{?>
						<h4>No currently available vacancies.</h4>
						<?php
					}
					?>
					
				</div><!-- contact form -->
            
				<?php if ( !empty ($vacancies) ){?>
				<div class="col-xs-6">
					<h3 class="nmt">Apply now</h3>
					<form enctype="multipart/form-data" class="form-inline" action="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" method="post" id="form_form">
						<div class="form-group">
							<input id="form_fullname" class="form-control" type="text" name="form_fullname" value="<?php echo ( isset($_POST['form_fullname']) && $form_error ) ? esc_attr($_POST['form_fullname']) : '';?>" placeholder="<?php $MyLangs->translate('fullname');?> *" />
						</div>
						<div class="form-group">
							<input class="form-control" type="email" name="form_email" value="<?php echo ( isset($_POST['form_email']) && $form_error ) ? esc_attr($_POST['form_email']) : '';?>" placeholder="<?php $MyLangs->translate('email');?> *" id="form_email" />
						</div>
					<div class="form-group-full">
							<select class="form-control" name="form_job">
							<option value="0">==Select Vacancy==</option>
							<?php
							foreach ($vacancies as $vID=>$vTitle){
								?>
								<option value="<?php echo $vID;?>"><?php echo $vTitle;?></option>
							<?php
							}
							?>
						</select>
						</div>
						<div class="form-group form-group-full">
						<span>Upload Resume:</span><input class="form-control" type="file" name="form_resume" />
						</div>
						<p><textarea rows="5" class="form-control" id="form_message" name="form_message" placeholder="<?php $MyLangs->translate('message');?> *"><?php echo ( isset($_POST['form_message']) && $form_error ) ? esc_textarea($_POST['form_message']) : '';?></textarea></p>
			
						<input type="hidden" name="form_submit" value="form_proccess" />
						<button type="submit" class="btn btn-primary"><?php $MyLangs->translate('apply');?></button>
						
						<?php wp_nonce_field( 'contact-form-submit', '_wpnonce-contact-form-submitted' ); ?>
						
					</form>
				</div><?php
				}?>
      </div>
    </div>
  </section>
</div>


<?php get_footer(); ?>