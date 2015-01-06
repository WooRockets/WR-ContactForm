<div class="row-fluid">
	<fieldset id="wr-cf-addon-mailchimp">
		<input type="hidden" id="wr-cf-mailchimp-form-fields-data" name="wr-cf-mailchimp-form-fields-data" value="<?php echo htmlentities( json_encode( $formFields ) ); ?>">
		<legend>MailChimp Settings</legend>
		<div class="control-group">
			<label class="control-label">Use MailChimp</label>
			<div class="controls">
				<div class="pull-left radio-option">
					<input id="wr-cf-mailchimp-use-yes" name="wr-cf-mailchimp[use]" value="yes"<?php if ( $mailchimpSettings->use == 'yes' ) echo ' checked="checked"'; ?> type="radio">
					<label for="wr-cf-mailchimp-use-yes">Yes</label>
				</div>
				<div class="pull-left radio-option">
					<input id="wr-cf-mailchimp-use-no" name="wr-cf-mailchimp[use]" value="no"<?php if ( $mailchimpSettings->use != 'yes' ) echo ' checked="checked"'; ?> type="radio">
					<label for="wr-cf-mailchimp-use-no">No</label>
				</div>
			</div>
		</div>
		<div class="control-group" id="wr-cf-mailchimp-control-group-api-key"<?php if ( $mailchimpSettings->use != 'yes' ) echo ' style="display: none;"'; ?>>
			<label class="control-label">API Key</label>
			<div class="controls">
				<input id="wr-cf-mailchimp-api-key" class="medium-input borderless" value="<?php echo $mailchimpSettings->apikey; ?>" placeholder="Please insert API key" type="text">
				<input id="wr-cf-mailchimp-api-key-lastest" name="wr-cf-mailchimp[apikey]" value="<?php echo $mailchimpSettings->apikey; ?>" type="hidden">
				<input type="button" id="wr-cf-mailchimp-api-key-verify" class="btn btn-primary" value="OK" style="display: none;">
				<input type="button" id="wr-cf-mailchimp-api-key-cancel" class="btn" value="Cancel" style="display: none;">
				<div class="spinner"></div>
				<div class="icon-ok"></div>
				<div class="clear"></div>
				<div class="under-line"><?php if ( $mailchimpSettings->apikey == '' ) echo 'Please insert API key'; else echo $mailchimpSettings->apikey; ?></div>
				<div class="clear"></div>
				<div class="error-alert">API key is incorrect, please check it again.</div>
			</div>
		</div>
		<div class="control-group" id="wr-cf-mailchimp-control-group-lists" style="display: none;">
			<input type="hidden" id="wr-cf-mailchimp-lists" class="medium-input" name="wr-cf-mailchimp[lists]" value="<?php echo htmlentities( json_encode( $mailchimpSettings->lists ) ); ?>">
			<label class="control-label">Lists</label>
			<div class="controls">
			</div>
		</div>
	</fieldset>
</div>