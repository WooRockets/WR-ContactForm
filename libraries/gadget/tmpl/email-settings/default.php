<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thailv
 * Date: 12/13/13
 * Time: 2:38 PM
 * To change this template use File | Settings | File Templates.
 */
$action = ! empty( $_GET[ 'email' ] ) ? $_GET[ 'email' ] : 0;
$arrayTranslated = array(
	'You must add some form field in your form in order to select it here',
	'No form field found',
	'You must add some email-type field in your form in order to select it here',
	'...',
	'No email field found',
	'Select Field',
	'Select Fields',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_FROM_0',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_REPLY_TO_0',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_SUBJECT_0',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_FROM_1',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_REPLY_TO_1',
	'WR_CONTACTFORM_PLACEHOLDER_EMAIL_SUBJECT_1',
);
$languages = WR_Contactform_Helpers_Contactform::get_translated( $arrayTranslated );
?>
<div class="jsn-master">
	<div class="jsn-bootstrap">
		<div id="form-loading" class="jsn-bgloading"><i class="jsn-icon32 jsn-icon-loading"></i></div>
		<form action="" class="form-horizontal hide" method="post" name="adminForm" id="wr_email_settings">
			<fieldset>
<?php
if ( $action == 0 ) {

	echo '<legend>Edit email content being sent to responder</legend>';
}
else {
	echo '<legend>Edit email content being sent to specified address(es)</legend>';
}
?>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_EMAIL_SPECIFY_THE_NAME_' . $action, WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'From', WR_CONTACTFORM_TEXTDOMAIN ); ?></label>

					<div id="from" class="controls">
						<input type="text" name="template_from" id="jform_template_from" class="input-xxlarge" value="" />
<?php
if ( $action == 1 ) {
	?>
	<button class="btn" id="btn-select-field-from" onclick="return false;" title="<?php echo '' . __( 'Insert form field', WR_CONTACTFORM_TEXTDOMAIN ); ?>">...</button>
	<?php
}
?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_EMAIL_SPECIFY_THE_EMAIL_' . $action, WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'Reply To', WR_CONTACTFORM_TEXTDOMAIN ); ?> </label>

					<div id="reply-to" class="controls">
						<input type="text" name="template_reply_to" id="jform_template_reply_to" class="input-xxlarge" value="" />
<?php
if ( $action == 1 ) {
	?>
	<button class="btn" id="btn-select-field-to" onclick="return false;" title="<?php echo '' . __( 'Insert form field', WR_CONTACTFORM_TEXTDOMAIN ); ?>">...</button>
	<?php
}
?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_EMAIL_SPECIFY_THE_SUBJECT_' . $action, WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'Subject', WR_CONTACTFORM_TEXTDOMAIN ); ?> </label>

					<div id="subject" class="controls">
						<input type="text" name="template_subject" id="jform_template_subject" class="input-xxlarge" value="" />
						<button class="btn" id="btn-select-field-subject" onclick="return false;" title="<?php echo '' . __( 'Insert form field', WR_CONTACTFORM_TEXTDOMAIN ); ?>">...</button>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_EMAIL_SPECIFY_THE_CONTENT_' . $action, WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'Message', WR_CONTACTFORM_TEXTDOMAIN ); ?> </label>

					<div id="template-msg" class="controls clearfix">
						<div class="template-msg-content">
							<textarea class="input-xxlarge" id="jform_template_message" name="template_message"></textarea>
						</div>
						<button class="btn " id="btn-select-field-message" onclick="return false;" title="<?php echo '' . __( 'Insert form field', WR_CONTACTFORM_TEXTDOMAIN ); ?>">...</button>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_EMAIL_SPECIFY_THE_ATTACH_' . $action, WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'Attach File', WR_CONTACTFORM_TEXTDOMAIN ); ?> </label>

					<div id="attach-file" class="controls">
						<ul class="jsn-items-list ui-sortable">
							<li class="ui-state-default ui-state-disabled" title="You must add some file-type field in your form in order to select it here">No file field found</li>
						</ul>
					</div>
				</div>
			</fieldset>
			<input type="hidden" name="languages" id="wr_contactform_languages" value='<?php echo '' . json_encode( $languages ) . '';?>' />
			<input type="hidden" name="jform[form_id]" value="<?php echo '' . isset( $_GET[ 'form_id' ] ) ? $_GET[ 'form_id' ] : ''; ?>" />
			<input type="hidden" id="template_notify_to" name="jform[template_notify_to]" value="<?php echo '' . isset( $_GET[ 'email' ] ) ? $_GET[ 'email' ] : 0; ?>" />
		</form>
	</div>
</div>
<?php
do_action( 'admin_footer' );
do_action( 'admin_print_footer_scripts' );
?>