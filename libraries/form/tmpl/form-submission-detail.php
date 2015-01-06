<?php
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'jquery-ui' );
wp_enqueue_script( 'jquery-ui-tabs' );
wp_enqueue_script( 'jquery-ui-dialog' );
wp_enqueue_script( 'jquery-ui-button' );
$assets = array(
	'wr-bootstrap2-css',
	'wr-bootstrap2-jsn-gui-css',
	'wr-bootstrap2-icomoon-css',
	'wr-jquery-ui-css',
	'wr-jquery-tipsy-css',
	'wr-bootstrap2-responsive-css',
	'wr-contactform-css',
	'wr-jquery-json-js',
	'wr-http-googlemaps-api-js',
	'wr-googlemaps-ui-js',
	'wr-googlemaps-services-js',
	'wr-googlemaps-extensions-js',
	'wr-contactform-submission-js',
);
WR_CF_Init_Assets::load( $assets );
$submissionID = ! empty( $_GET[ 'post' ] ) ? (int)$_GET[ 'post' ] : '';
$dataSubmission = get_post( $submissionID );
$formID = ! empty( $dataSubmission->post_content ) ? (int)$dataSubmission->post_content : '';

if ( empty( $formID ) ) {
	header( 'Location: ' . get_admin_url() . 'edit.php?post_type=wr_cfsb_post_type' );
	exit();
}
$formPostMeta = get_post_meta( $formID );
$formContent = WR_Contactform_Helpers_Contactform::get_form_content( $formID );
$submissionData = WR_Contactform_Helpers_Contactform::get_form_data( $formID, $submissionID );
$submission = new stdClass;
if ( ! empty( $submissionData ) ) {
	foreach ( $submissionData as $sData ) {
		if ( empty( $sData->field_id ) ) {
			$submission->{$sData->field_type} = $sData->submission_data_value;
		}
		else {
			$submission->{$sData->field_id} = $sData->submission_data_value;
		}
	}
}
?>
<div class="jsn-master">

	<div id="submission-settings" class="jsn-page-settings jsn-bootstrap">
		<div class="wr-tabs">
			<ul>
				<li>
					<a href="#submission-data"></i><?php echo ''.__( 'Data', WR_CONTACTFORM_TEXTDOMAIN );?></a>
				</li>
				<li>
					<a href="#submission-details"></i><?php echo ''.__( 'Details', WR_CONTACTFORM_TEXTDOMAIN );?></a>
				</li>
			</ul>
			<div id="submission-details" class="submission-details">

					<table class="table table-bordered">
						<tr>
							<th>
								<?php echo '' . __( 'Form', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</th>
							<td class="form-title">
								<?php
									echo ''.$dataSubmission->post_title;
								?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo '' . __( 'WR_CONTACTFORM_SUBMISSION_CREATED_AT', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</th>
							<td>
								<?php
								$dateTime = new DateTime( $dataSubmission->post_date );
								echo '' . $dateTime->format( 'j F Y h:i:s' );
								?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo '' . __( 'WR_CONTACTFORM_SUBMISSION_IP', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</th>
							<td><?php echo '' . $submission->ip; ?></td>
						</tr>
						<tr>
							<th>
								<?php echo '' . __( 'WR_CONTACTFORM_SUBMISSION_BROWSER', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</th>
							<td><?php echo  '' . $submission->browser; ?></td>
						</tr>
						<tr>
							<th>
								<?php echo '' . __( 'WR_CONTACTFORM_SUBMISSION_OS', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</th>
							<td><?php echo  '' . $submission->os; ?></td>
						</tr>
					</table>
			</div>
			<div id="submission-data" class="submission-data">

				<div class="jsn-form-bar">
<?php
$formType = isset( $formPostMeta[ 'form_type' ][ 0 ] ) ? $formPostMeta[ 'form_type' ][ 0 ] : 1;
if ( $formType == 2 ) {
	?>
	<div class="control-group ">
		<label class="control-label"><?php echo '' . __( 'WR_CONTACTFORM_DATA_PRESENTATION', WR_CONTACTFORM_TEXTDOMAIN ); ?>:</label>
		<div class="controls">
			<select class="jsn-input-fluid" data-value="<?php echo '' . $formType; ?>" id="jform_form_type">
				<option value="1"><?php echo '' . __( 'WR_CONTACTFORM_TYPE_SINGLE_PAGE', WR_CONTACTFORM_TEXTDOMAIN ); ?></option>
				<option value="2"><?php echo '' . __( 'WR_CONTACTFORM_TYPE_MULTIPLE_PAGES', WR_CONTACTFORM_TEXTDOMAIN ); ?></option>
			</select>
		</div>
	</div>
	<?php
}
?>
					<div class="control-group pull-right">
						<div class="controls">
							<button class="btn" id="wr-submission-edit" onclick="return false;">
								<i class="icon-pencil"></i><?php echo '' . __( 'Edit', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</button>
							<button class="btn btn-primary hide" id="wr-submission-save" onclick="return false;">
								<i class="icon-pencil"></i><?php echo '' . __( 'WR_CONTACTFORM_DONE', WR_CONTACTFORM_TEXTDOMAIN ); ?>
							</button>
						</div>
					</div>
				</div>
				<div class="submission-content">
					<div class="jsn-page-actions btn-group" style="display: block;">
						<button class="btn btn-icon prev-page hide" onclick="return false;" disabled="disabled">
							<i class="icon-arrow-left"></i></button>
						<button class="btn btn-icon next-page hide" onclick="return false;" disabled="disabled">
							<i class="icon-arrow-right"></i></button>
					</div>
<?php
foreach ( $formContent as $formPages ) {
	$pageContent = json_decode( $formPages->page_content );
	$submissionDetail = '';
	$submissionEdit = '';
	foreach ( $pageContent as $fields ) {
		$key = $fields->id;
		if ( isset( $fields->type ) && $fields->type != 'static-content' && $fields->type != 'google-maps' ) {
			$submissionDetail .= '<dt>' . $fields->options->label . ':</dt><dd id="' . $key . '">';
			$submissionEdit .= '<div class="control-group ">
<label class="control-label">' . $fields->options->label . ':</label>
<div class="controls">';
			$contentField = '';
			$contentFieldEdit = '';
			$contentFieldDetail = '';
			if ( isset( $submission->$key ) ) {
				$contentField = WR_Contactform_Helpers_Contactform::get_data_field( $fields->type, $submission, $key, $this->id, false );
				$contentFieldEdit = $contentField;
				if ( $fields->type == 'email' ) {
					$contentFieldDetail = ! empty( $contentField ) ? '<a href="mailto:' . $contentField . '">' . $contentField . '</a>' : 'N/A';
				}
				else {
					$contentFieldDetail = $contentField;
				}
			}
			if ( isset( $fields->type ) && $fields->type == 'likert' )
				$submissionDetail .= $contentFieldDetail ? str_replace( '\n', '<br/>', trim( $contentFieldDetail ) ) : 'N/A';
			else
				$submissionDetail .= $contentFieldDetail ? str_replace( '\n', '<br/>', htmlentities( html_entity_decode( trim( $contentFieldDetail ) ) ) ) : 'N/A';
			if ( isset( $fields->type ) && ( $fields->type == 'checkboxes' || $fields->type == 'list' || $fields->type == 'paragraph-text' ) ) {
				if ( $fields->type == 'checkboxes' || $fields->type == 'list' ) {
					$contentFieldEdit = str_replace( '<br/>', "\n", $contentFieldEdit );
					$contentFieldEdit = str_replace( "\n\n", "\n", $contentFieldEdit );
					$contentFieldEdit = htmlentities( $contentFieldEdit, ENT_QUOTES | ENT_IGNORE, 'UTF-8' );
				}
				$submissionEdit .= '<textarea name="submission[' . $key . ']" class="jsn-input-xxlarge-fluid" dataValue="' . $fields->id . '" typeValue="' . $fields->type . '" rows="5" >' . $contentFieldEdit . '</textarea>';
			}
			else if ( isset( $fields->type ) && $fields->type == 'likert' ) {
				$likertData = json_decode( $submission->$key );

				$settings = json_decode( stripslashes( $likertData->settings ) );

				$tdRows = '<input type="hidden" class="wr-likert-settings" data-value=\'' . $key . '\' name=\'submission[' . $key . '][likert][settings]\' value=\'' . htmlentities(
					json_encode(
						array(
							'rows' => $settings->rows,
							'columns' => $settings->columns,
						)
					), ENT_QUOTES, 'UTF-8'
				) . '\' />';
				$tdColumns = '';
				if ( ! empty( $settings->rows ) ) {
					foreach ( $settings->rows as $row ) {
						$tdRows .= '<tr>';
						$tdRows .= '<td>' . $row->text . '</td>';
						foreach ( $settings->columns as $column ) {
							$checked = '';
							if ( ! empty( $likertData->values ) ) {
								foreach ( $likertData->values as $k => $val ) {
									if ( $k == md5( $row->text ) && $val == $column->text ) {
										$checked = 'checked="checked" ';
									}
								}
							}
							$tdRows .= '<td class="text-center"><input ' . $checked . ' type="radio" data-value=\'' . htmlentities( $row->text, ENT_QUOTES, 'UTF-8' ) . '\' name="submission[' . $key . '][likert][values][' . md5( $row->text ) . ']"  value=\'' . htmlentities( $column->text, ENT_QUOTES, 'UTF-8' ) . '\' /></td>';
						}
						$tdRows .= '</tr>';
					}
				}
				if ( ! empty( $settings->columns ) ) {
					foreach ( $settings->columns as $column ) {
						$tdColumns .= '<th class="text-center">' . $column->text . '</th>';
					}
				}
				$submissionEdit .= '<table class="wr-likert table table-bordered table-striped"><thead><tr><th></th>' . $tdColumns . '</tr></thead><tbody>' . $tdRows . '</tbody></table>';
			}
			else if ( isset( $fields->type ) && $fields->type == 'file-upload' ) {
				$submissionEdit .= $contentFieldEdit;
			}
			else {
				$submissionEdit .= '<input type="text" name="submission[' . $key . ']" dataValue="' . $fields->id . '" typeValue="' . $fields->type . '" class="jsn-input-xxlarge-fluid" value="' . htmlentities( html_entity_decode( $contentFieldEdit ) ) . '" />';
			}
			$submissionEdit .= '</div></div>';
			$submissionDetail .= '</dd>';
		}
		else if ( isset( $fields->type ) && $fields->type == 'static-content' || $fields->type == 'google-maps' ) {
			if ( $fields->type == 'static-content' ) {
				$submissionDetail .= '<dt>' . $fields->options->label . ':</dt><dd id="' . $key . '">';
				$submissionDetail .= '<dd class="clearfix">' . $fields->options->value . '</dd>';
			}
			else if ( $fields->type == 'google-maps' ) {
				$height = isset( $fields->options->height ) ? $fields->options->height : '';
				$width = isset( $fields->options->width ) ? $fields->options->width : '';
				$formatWidth = isset( $fields->options->formatWidth ) ? $fields->options->formatWidth : '';
				$googleMaps = isset( $fields->options->googleMaps ) ? $fields->options->googleMaps : '';
				$googleMapsMarKer = isset( $fields->options->googleMapsMarKer ) ? $fields->options->googleMapsMarKer : '';
				$submissionDetail .= '<dd><div class="content-google-maps" data-width="' . $width . ' ' . $formatWidth . '" data-height="' . $height . '" data-value="' . htmlentities( $googleMaps, ENT_QUOTES, 'UTF-8' ) . '" data-marker="' . htmlentities( $googleMapsMarKer, ENT_QUOTES, 'UTF-8' ) . '"><div class="google_maps map rounded"></div></div></dd>';
			}
		}
	}
	?>
						<div class="submission-page" data-title="<?php echo '' . $formPages->page_title; ?>" data-value="<?php echo '' . $formPages->page_id; ?>">
							<div class="submission-page-header">
								<h3><?php echo '' . $formPages->page_title; ?></h3>
							</div>

							<dl class="submission-page-content " id="dl_<?php echo '' . $formPages->page_id; ?>">
								<?php echo '' . $submissionDetail; ?>
							</dl>
							<div class="submission-page-content hide" id="div_<?php echo '' . $formPages->page_id; ?>">
								<?php echo '' . $submissionEdit; ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>

			</div>
		</div>
	</div>
</div>