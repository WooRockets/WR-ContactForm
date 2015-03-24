<?php
/**
 * @version    $Id$
 * @package    WR_ContactForm
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * WR ContactForm form edit.
 *
 * @package  WR_ContactForm
 * @since    1.0.0
 */
class WR_Contactform_Helpers_Form_Edit {

	public function __construct() {
		add_action( 'wr_contactform_form_container_tabs', array( &$this, 'add_container_form_design' ), 10, 8 );
		add_action( 'wr_contactform_form_container_tabs', array( &$this, 'add_container_form_action' ), 10, 8 );
		add_action( 'wr_contactform_form_edit_form_bar', array( &$this, 'add_form_bar' ), 10, 8 );
	}

	public function add_form_bar( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {

		?>
		<div class="jsn-form-bar">
		<div class="control-group ">
			<label class="control-label wr-label-des-tipsy" original-title="Select to show form fields in in single page or multiple pages.">Form Type</label>

			<div class="controls">
				<?php
				$fieldFormType = $form[ 'wr-form-field-form_type' ];
				$fieldFormType->get( 'input' );
				?>
			</div>
		</div>
		<div class="pull-right">
			<button id="select_form_style" class="btn" onclick="return false;">
				<i class="icon-pencil"></i>Form Style
			</button>
			<div id="container-select-style" class="jsn-bootstrap">
				<div class="popover bottom">
					<div class="arrow"></div>
					<h3 class="popover-title">Form Style</h3>

					<div class="popover-content">
						<div class="jsn-form-bar">
							<div class="jsn-padding-medium jsn-rounded-medium jsn-box-shadow-small jsn-bgpattern pattern-sidebar">
								<div class="control-group">
									<label class="control-label" original-title="Select to show form field title and element in vertical column or horizontal row.">Label position</label>
		<?php
		$vertical = '';
		$horizontal = '';
		if ( ( ! isset( $formStyle->layout ) ) || ( isset ( $formStyle->layout ) && ( empty( $formStyle->layout ) || $formStyle->layout == 'form-vertical' ) ) ) {
			$vertical = 'checked';
		}
		else if ( ! empty( $formStyle->layout ) && $formStyle->layout == 'form-horizontal' ) {
			$horizontal = 'checked';
		}
		?>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons">
											<label class="btn btn-default">
												<input type="radio" name="form_style[layout]" <?php echo $vertical; ?> value="form-vertical">
												<i class="wr-cf-icon-layout-vertical" title="Vertical"></i>
											</label>
											<label class="btn btn-default">
												<input type="radio" name="form_style[layout]" <?php echo $horizontal; ?> value="form-horizontal">
												<i class="wr-cf-icon-layout-horizontal" title="Horizontal"></i>
											</label>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label label-color-scheme" original-title="Style">Style</label>

									<div class="controls">
										<div id="theme_select">
											<div id="form-select">
												<?php
												$optionTheme = '';
												?>
												<select id="jform_form_theme" style="width: 200px" name="form_style[theme]">
		<?php
		$themes = ! empty( $formStyle->themes ) ? $formStyle->themes : array(
			'light',
			'dark',
		);
		if ( ! empty( $themes ) ) {
			foreach ( $themes as $theme ) {
				$dataValue = '';
				if ( ! empty( $formStyle->themes_style ) ) {
					$themeStyle = $formStyle->themes_style;

					$dataValue = ! empty( $themeStyle->$theme ) ? $themeStyle->$theme : '';
				}
				$checked = ! empty( $formStyle->theme ) && $formStyle->theme == 'wr-style-' . $theme ? 'selected' : '';
				echo '' . '<option ' . $checked . ' value="wr-style-' . $theme . '">' . $theme . '</option>';
				$optionTheme .= "<input type='hidden' class='wr-style-{$theme}' value='{$dataValue}' name='form_style[themes_style][{$theme}]'/><input type='hidden' value='{$theme}' name='form_style[themes][]'/>";
			}
		}
		?>
												</select>
											</div>
											<div id="add-theme-select" class="hide">
												<div class="control-group">
													<input type="text" id="input_new_theme" class="input-medium" name="new_theme">

													<div class="control-group">
														<button title="Save" id="btn_add_theme" onclick="return false;" class="btn btn-icon">
															<i class="icon-ok"></i></button>
														<button title="Cancel" id="btn_cancel_theme" onclick="return false;" class="btn btn-icon">
															<i class="icon-remove"></i></button>
													</div>
												</div>
											</div>
											<div id="option_themes" class="hide">
												<?php echo '' . $optionTheme;?>
											</div>
											<div id="theme_action" class="pull-right">
												<button class="btn btn-icon btn-success pull-right" id="theme_action_add" onclick="return false;">
													<i class="icon-plus"></i></button>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
						<div id="style_accordion_content" class="jsn-tabs form-horizontal">
							<ul>
								<li class="active"><a href="#formStyleContainer">Container</a></li>
								<li><a href="#formStyleTitle">Title</a></li>
								<li><a href="#formStyleField">Field</a></li>
								<li><a href="#formStyleMessageError">Error</a></li>
								<li><a href="#formStyleHelpText">Help Text</a></li>
								<li><a href="#formStyleButtons">Buttons</a></li>
								<li><a href="#formCustomCss">CSS</a></li>
							</ul>
							<div id="formStyleContainer">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Background Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="jsn-element" value="<?php echo '' . $formStyle->background_color;?>" class="jsn-input-fluid" name="form_style[background_color]" id="style_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Background Active Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="ui-state-edit" value="<?php echo '' . $formStyle->background_active_color;?>" class="jsn-input-fluid" name="form_style[background_active_color]" id="style_background_active_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Border Thickness', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="border" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->border_thickness ) ? $formStyle->border_thickness : 0;?>" class="jsn-input-number input-mini" name="form_style[border_thickness]" id="style_border_thickness" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Border Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="jsn-element" value="<?php echo '' . $formStyle->border_color;?>" class="jsn-input-fluid" name="form_style[border_color]" id="style_border_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Border Active Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="ui-state-edit" value="<?php echo '' . $formStyle->border_active_color;?>" class="jsn-input-fluid" name="form_style[border_active_color]" id="style_border_active_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Rounded Corner Radius', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="border-radius,-moz-border-radius,-webkit-border-radius" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->rounded_corner_radius ) ? $formStyle->rounded_corner_radius : 0;?>" class="input-mini jsn-input-number" name="form_style[rounded_corner_radius]" id="style_rounded_corner_radius" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Padding Space', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="padding" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->padding_space ) ? $formStyle->padding_space : 0;?>" class="input-mini jsn-input-number" name="form_style[padding_space]" id="style_padding_space" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Vertical Space', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="margin" data-type="jsn-element" value="<?php echo '' . ! empty( $formStyle->margin_space ) ? $formStyle->margin_space : 0;?>" class="input-mini jsn-input-number" name="form_style[margin_space]" id="style_margin_space" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleTitle">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Text Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="color" data-type="control-label" value="<?php echo '' . $formStyle->text_color;?>" class="jsn-input-fluid" name="form_style[text_color]" id="style_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Font Type', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<select data-value="font-family" data-type="control-label" name="form_style[font_type]" id="style_font_type">
		<?php
		foreach ( $listFontType as $fontType ) {
			$selected = '';
			if ( $fontType == $formStyle->font_type ) {
				$selected = 'selected';
			}
			echo '' . "<option {$selected} value='{$fontType}'>{$fontType}</option>";
		}
		?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Font Size', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<div class="input-append">
											<input type="number" data-value="font-size" data-type="control-label" default-value="14px" value="<?php echo '' . ! empty( $formStyle->font_size ) ? $formStyle->font_size : 0;?>" class="input-mini jsn-input-number" name="form_style[font_size]" id="style_font_size" /><span class="add-on">px</span>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleField">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Background Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="background-color" data-type="field" value="<?php echo '' . ! empty( $formStyle->field_background_color ) ?  $formStyle->field_background_color : ''  ;?>" class="jsn-input-fluid" name="form_style[field_background_color]" id="style_field_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Border Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="border-color" data-type="field" value="<?php echo '' . ! empty( $formStyle->field_border_color ) ?  $formStyle->field_border_color : '';?>" class="jsn-input-fluid" name="form_style[field_border_color]" id="style_field_border_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Shadow Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="box-shadow" data-type="field" value="<?php echo '' . ! empty( $formStyle->field_shadow_color ) ?  $formStyle->field_shadow_color : '' ;?>" class="jsn-input-fluid" name="form_style[field_shadow_color]" id="style_field_shadow_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Text Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" data-value="color" data-type="field" value="<?php echo '' . ! empty( $formStyle->field_text_color ) ? $formStyle->field_text_color : '' ;?>" class="jsn-input-fluid" name="form_style[field_text_color]" id="style_field_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>

							</div>
							<div id="formStyleMessageError">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Background Color', WR_CONTACTFORM_TEXTDOMAIN );?></label>

									<div class="controls">
										<input type="text" value="<?php echo '' . ! empty( $formStyle->message_error_background_color ) ? $formStyle->message_error_background_color : '' ;?>" class="jsn-input-fluid" name="form_style[message_error_background_color]" id="style_message_error_background_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'Text Color', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<input type="text" value="<?php echo '' . ! empty( $formStyle->message_error_text_color ) ? $formStyle->message_error_text_color : '' ;?>" class="jsn-input-fluid" name="form_style[message_error_text_color]" id="style_message_error_text_color" />

										<div class="jsn-select-color">
											<div></div>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleHelpText">
								<div class="control-group">
									<label class="control-label">Help Text Style</label>

									<div class="controls">
		<?php
		$simpleHelpText = '';
		$tooltipHelpText = '';
		if ( ( ! empty( $formStyle->help_text_type ) ) && ( $formStyle->help_text_type == 'simple' ) ) {
			$simpleHelpText = ' checked';
		} else {
			$tooltipHelpText = ' checked';
		}
		?>
										<div class="jsn-columns-container jsn-columns-count-one">
											<div class="jsn-column-item">
												<label class="radio">
													<input type="radio"<?php echo $simpleHelpText; ?> name="form_style[help_text_type]" value="simple" id="style0_help_text_type">
													<span><b>Label</b><p class="wr-help-text">Help text here</p></span>
												</label>
											</div>
											<div class="jsn-column-item">
												<label class="radio">
													<input type="radio"<?php echo $tooltipHelpText; ?> name="form_style[help_text_type]" value="tooltip" id="style1_help_text_type">
													<span><b>Label</b> <i class="icon-question-sign" title="Help text here"></i></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="formStyleButtons">
								<div class="control-group">
									<label class="control-label"><?php echo '' . __( 'WR_CONTACTFORM_BUTTON_POSITION', WR_CONTACTFORM_TEXTDOMAIN )?></label>

									<div class="controls">
										<select class="input-large" name="form_style[button_position]" id="button_position">
											<?php
											$buttonPosition = ! empty( $formStyle->button_position ) ? $formStyle->button_position : 'btn-toolbar';
											echo '' . WR_Contactform_Helpers_Contactform::render_options_button_position( $buttonPosition );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . ! empty( $formItems->form_btn_submit_text ) ? $formItems->form_btn_submit_text : 'Submit'; ?></label>

									<div class="controls">
										<select class="input-large wr-select2" name="form_style[button_submit_color]" id="button_submit_color">
											<?php
											$buttonSubmitColor = ! empty( $formStyle->button_submit_color ) ? $formStyle->button_submit_color : 'btn btn-primary';
											echo '' . WR_Contactform_Helpers_Contactform::render_options_button_style( $buttonSubmitColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . ! empty( $formItems->form_btn_reset_text ) ? $formItems->form_btn_reset_text : 'Reset'; ?></label>

									<div class="controls">
										<select class="input-large wr-select2" name="form_style[button_reset_color]" id="button_reset_color">
											<?php
											$buttonResetColor = ! empty( $formStyle->button_reset_color ) ? $formStyle->button_reset_color : 'btn';
											echo '' . WR_Contactform_Helpers_Contactform::render_options_button_style( $buttonResetColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . ! empty( $formItems->form_btn_prev_text ) ? $formItems->form_btn_prev_text : 'Prev'; ?></label>

									<div class="controls">
										<select class="input-large wr-select2" name="form_style[button_prev_color]" id="button_prev_color">
											<?php
											$buttonPrevColor = ! empty( $formStyle->button_prev_color ) ? $formStyle->button_prev_color : 'btn';
											echo '' . WR_Contactform_Helpers_Contactform::render_options_button_style( $buttonPrevColor );
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo '' . ! empty( $formItems->form_btn_next_text ) ? $formItems->form_btn_next_text : 'Next'; ?></label>

									<div class="controls">

										<select class="input-large wr-select2" name="form_style[button_next_color]" id="button_next_color">
											<?php
											$buttonNextColor = ! empty( $formStyle->button_next_color ) ? $formStyle->button_next_color : 'btn btn-primary';
											echo '' . WR_Contactform_Helpers_Contactform::render_options_button_style( $buttonNextColor );
											?>
										</select>
									</div>
								</div>
							</div>
							<div id="formCustomCss">
								<textarea id="style_custom_css" name="form_style[custom_css]"><?php echo '' . ! empty( $formStyle->custom_css ) ? $formStyle->custom_css : '' ;?></textarea>
							</div>
						</div>
						<div class="clearfix">
							<div class="btn-toolbar pull-left">
								<a id="theme_action_refresh" href="javascript:void(0);" class="btn btn-link">Back to Default</a>
								<a id="theme_action_delete" href="javascript:void(0);" class="btn btn-link">Delete Style</a>
							</div>
							<div class="btn-toolbar pull-right">
								<button id="cancel-style-settings" class="btn" type="button">Cancel</button>
								<button id="save-style-settings" class="btn btn-primary" type="button">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	<?php
	}

	/**
	 * Add container form design content
	 *
	 * @param $form
	 */
	public function add_container_form_design( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {
		$buttonPosition = ! empty( $formStyle->button_position ) ? $formStyle->button_position : 'btn-toolbar';
		$buttonSubmitColor = ! empty( $formStyle->button_submit_color ) ? $formStyle->button_submit_color : 'btn btn-primary';
		$buttonResetColor = ! empty( $formStyle->button_reset_color ) ? $formStyle->button_reset_color : 'btn';
		$buttonPrevColor = ! empty( $formStyle->button_prev_color ) ? $formStyle->button_prev_color : 'btn';
		$buttonNextColor = ! empty( $formStyle->button_next_color ) ? $formStyle->button_next_color : 'btn btn-primary';
		?>
		<div id="form-design">
		<?php do_action( 'wr_contactform_form_edit_form_bar', $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<hr />
		<div class="wr-page">
			<?php echo '' . $listPage; ?>
			<div id="form-design-content" class="clearfix <?php echo '' . ! empty( $formItems->form_theme ) ? $formItems->form_theme : 'wr-style-light'; ?>">
				<div id="form-container" class="jsn-layout">
					<div id="page-loading" class="jsn-bgloading">
						<i class="jsn-icon32 jsn-icon-loading"></i></div>
					<a class="jsn-add-more" id="wr-add-container" href="javascript:void(0);"><i class="icon-plus"></i><?php _e( 'WR_CONTACTFORM_ADD_CONTAINER', WR_CONTACTFORM_TEXTDOMAIN ); ?>
					</a>

					<div class="ui-sortable wr-sortable-disable wr-box-border">
						<div class="form-captcha ui-state-default jsn-iconbar-trigger">
							<div class="recaptcha-content" style="text-align:  center;">

								<div class="img-captcha">
									<span class="label label-important">Captcha is disabled</span><img src="<?php echo '' . get_site_url() . '/wp-content/plugins/wr-contactform/assets/images/recaptcha_pic.png';?>" data-recaptcha="<?php echo '' . get_site_url() . '/wp-content/plugins/wr-contactform/assets/images/recaptcha_pic.png';?>" data-securityimages="<?php echo '' . get_site_url() . '/wp-content/plugins/wr-contactform/assets/images/securitycaptcha_pic.png';?>" />
								</div>
								<input type="hidden" id="jform_form_captcha" name="wr_contactform[form_settings][form_captcha]" value="<?php echo '' . ( ! empty( $formSettings->form_captcha ) ? $formSettings->form_captcha : '' );?>">
							</div>
							<div class="jsn-iconbar">
								<a class="element-edit" title="Edit Button Action" onclick="return false;" href="#"><i class="icon-pencil"></i></a>
							</div>
						</div>
						<div class="ui-sortable wr-sortable-disable">
							<div class="form-actions ui-state-default jsn-iconbar-trigger">
								<div class="<?php echo '' . $buttonPosition;?>">
		<?php
		$stateBtnReset = 'hide';
		if ( ! empty( $formSettings->form_state_btn_reset_text ) && $formSettings->form_state_btn_reset_text == 'Yes' ) {
			$stateBtnReset = '';
		}

									?>
									<button onclick="return false;" class="<?php echo '' . $buttonPrevColor;?> jsn-form-prev hide"><?php echo '' . ( isset ( $formSettings->form_btn_prev_text ) && $formSettings->form_btn_prev_text ) ? $formSettings->form_btn_prev_text : 'Prev'; ?></button>
									<button onclick="return false;" class="<?php echo '' . $buttonNextColor;?> jsn-form-next hide"><?php echo '' . ( isset ( $formSettings->form_btn_next_text ) && $formSettings->form_btn_next_text ) ? $formSettings->form_btn_next_text : 'Next'; ?></button>
									<button class="<?php echo '' . $buttonSubmitColor;?> jsn-form-submit hide" onclick="return false;"><?php echo '' . isset( $formSettings->form_btn_submit_text ) && $formSettings->form_btn_submit_text ? $formSettings->form_btn_submit_text : 'Submit'; ?></button>
									<button class="<?php echo '' . $buttonResetColor;?> jsn-form-reset hide" onclick="return false;"><?php echo '' . isset( $formSettings->form_btn_reset_text ) && $formSettings->form_btn_reset_text ? $formSettings->form_btn_reset_text : 'Reset'; ?></button>
									<input type="hidden" id="jform_form_btn_next_text" name="wr_contactform[form_settings][form_btn_next_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_next_text ) ? $formSettings->form_btn_next_text : 'Next' );?>">
									<input type="hidden" id="jform_form_btn_prev_text" name="wr_contactform[form_settings][form_btn_prev_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_prev_text ) ? $formSettings->form_btn_prev_text : 'Prev' );?>">
									<input type="hidden" id="jform_form_btn_submit_text" name="wr_contactform[form_settings][form_btn_submit_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_submit_text ) ? $formSettings->form_btn_submit_text : 'Submit' );?>">
									<input type="hidden" id="jform_form_btn_reset_text" name="wr_contactform[form_settings][form_btn_reset_text]" value="<?php echo '' . ( ! empty( $formSettings->form_btn_reset_text ) ? $formSettings->form_btn_reset_text : 'Reset' );?>">
									<input type="hidden" id="jform_form_state_btn_reset_text" name="wr_contactform[form_settings][form_state_btn_reset_text]" value="<?php echo '' . ( ! empty( $formSettings->form_state_btn_reset_text ) ? $formSettings->form_state_btn_reset_text : 'No' );?>">
									<input type="hidden" id="recaptcha_publickey_saveform" name="recaptcha_publickey" value="<?php echo WR_CONTACTFORM_CAPTCHA_PUBLICKEY; ?>">
									<input type="hidden" id="recaptcha_privatekey_saveform" name="recaptcha_privatekey" value="<?php echo WR_CONTACTFORM_CAPTCHA_PRIVATEKEY; ?>">
								</div>
								<div class="jsn-iconbar">
									<a class="element-edit" title="Edit Button Action" onclick="return false;" href="#"><i class="icon-pencil"></i></a>
								</div>
							</div>
						</div>
					</div>
					<?php
					$titleForm = isset( $_GET[ 'form' ] ) ? $_GET[ 'form' ] : '';
					$arrayTranslated = array(
						'New Page',
						'Email content being sent to form submitter',
						'WR_CONTACTFORM_MOVE_UP_CONTAINER',
						'Edit email content being sent to specified address(es)',
						'WR_CONTACTFORM_MOVE_DOWN_CONTAINER',
						'WR_CONTACTFORM_ADD_CONTAINER_COLUMN',
						'WR_CONTACTFORM_DELETE_CONTAINER',
						'WR_CONTACTFORM_DELETE_CONTAINER_COLUMN',
						'WR_CONTACTFORM_CONFIRM_DELETE_CONTAINER',
						'WR_CONTACTFORM_CONFIRM_DELETE_CONTAINER_COLUMN',
						'you sure you want to restore all style settings to default state?',
						'Are you sure you want to delete current color scheme?',
						'Color scheme with such name already exists',
						'WR_CONTACTFORM_ALL_FORM_FIELD_ARE_HIDDEN',
						'WR_CONTACTFORM_ALL_FORM_FIELD_ARE_DISPLAYED',
						'Enable Range selection',
						'TITLES',
						'WR_CONTACTFORM_DATE_HOUR_TEXT',
						'WR_CONTACTFORM_DATE_MINUTE_TEXT',
						'WR_CONTACTFORM_DATE_CLOSE_TEXT',
						'WR_CONTACTFORM_DATE_PREV_TEXT',
						'WR_CONTACTFORM_DATE_NEXT_TEXT',
						'WR_CONTACTFORM_DATE_CURRENT_TEXT',
						'WR_CONTACTFORM_DATE_MONTH_JANUARY',
						'WR_CONTACTFORM_DATE_MONTH_FEBRUARY',
						'WR_CONTACTFORM_DATE_MONTH_MARCH',
						'WR_CONTACTFORM_DATE_MONTH_APRIL',
						'WR_CONTACTFORM_DATE_MONTH_MAY',
						'WR_CONTACTFORM_DATE_MONTH_JUNE',
						'WR_CONTACTFORM_DATE_MONTH_JULY',
						'WR_CONTACTFORM_DATE_MONTH_AUGUST',
						'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER',
						'WR_CONTACTFORM_DATE_MONTH_OCTOBER',
						'WR_CONTACTFORM_DATE_MONTH_NOVEMBER',
						'WR_CONTACTFORM_DATE_MONTH_DECEMBER',
						'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT',
						'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT',
						'WR_CONTACTFORM_DATE_DAY_SUNDAY',
						'WR_CONTACTFORM_DATE_DAY_MONDAY',
						'WR_CONTACTFORM_DATE_DAY_TUESDAY',
						'WR_CONTACTFORM_DATE_DAY_WEDNESDAY',
						'WR_CONTACTFORM_DATE_DAY_THURSDAY',
						'WR_CONTACTFORM_DATE_DAY_FRIDAY',
						'WR_CONTACTFORM_DATE_DAY_SATURDAY',
						'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT',
						'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN',
						'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER',
						'WR_CONTACTFORM__MAIL_SETTINGS',
						'Select menu item',
						'Select article',
						'Appearance',
						'Select',
						'Save',
						'Cancel',
						'WR_CONTACTFORM_ADD_FIELD',
						'WR_CONTACTFORM_BUTTON_SAVE',
						'Cancel',
						'Converting form type to Single Page will combine fields from all pages into one single page. Are you sure?',
						'WR_CONTACTFORM_UPGRADE__DITION_TITLE',
						'WR_CONTACTFORM_UPGRADE__DITION',
						'Do you want to save changes before leaving this page?',
						'WR_CONTACTFORM_NO__MAIL',
						'WR_CONTACTFORM_NO__MAIL_DES',
						'Are you sure you want to delete this field?',
						'Deleting a field means that all data collected by the field will be deleted immediately. Because this action cannot be undone, you might want to consider backup your data first.',
						'WR_CONTACTFORM_BTN_BACKUP',
						'If checked no value duplication will be allowed for this field.',
						'WR_CONTACTFORM__MAIL_SUBMITTER_TITLE',
						'WR_CONTACTFORM__MAIL_ADDRESS_TITLE',
						'Plugin syntax details',
						'Please insert following text to your article at the position where you want to show form',
						'Even if you do not set limitation here, there will still be a limitation set by server which is: ',
						'For security reasons following file extensions are always prohibited: ',
						'Even if you do not set limitation here, there will still be a limitation set by server which is: ',
						'STREET_ADDRESS',
						'ADDRESS_LINE_2',
						'CITY',
						'POSTAL_ZIP_CODE',
						'STATE_PROVINCE_REGION',
						'FIRST',
						'MIDDLE',
						'LAST',
						'COUNTRY',
						'Allow user’s choice',
						'Set the first item as placeholder',
						'When checked, the first item will be used as placeholder without contributing value to form data.',
						'Show Date in format',
						'Show Time in format',
						'WR_CONTACTFORM__NABLE_RANGE_SELECTION',
						'Please upgrade to PRO edition to be able to hide the copyright link.',
						'Custom date format',
						'Upgrade to PRO edition',
						'Upgrade to PRO edition for more',
						'<p>The multiple pages feature is available only in PRO edition. Please upgrade to PRO edition to get this and other awesome features. Also you will get professional and fast support.</p>',
						'In Free edition, you can only create <strong>up to 10 fields</strong> in one form. Please upgrade to PRO edition to create unlimited number of fields in one form.',
					);
					$formSubmitter = isset( $items->form_submitter ) ? json_decode( $items->form_submitter ) : '';
					$languages = WR_Contactform_Helpers_Contactform::get_translated( $arrayTranslated );
					$fieldFormStyle = $form[ 'wr-form-field-form_style' ];;
					$fieldFormStyle->get( 'input' );
					?>
					<input type="hidden" value="<?php echo '' . htmlentities( $formPage )  ?>" id="jform_form_content" name="jform[form_content]">
					<input type="hidden" name="jform_form_id" id="jform_form_id" value="<?php echo '' . ( ! empty( $items->form_id ) ? $items->form_id : '' );?>" />
					<input type="hidden" name="jform_form_title" id="jform_form_title" value="<?php echo '' . ( ! empty( $_GET[ 'form' ] ) ? $_GET[ 'form' ] : '' );?>" />
					<input type="hidden" name="urlAdmin" id="urlAdmin" value="<?php echo '' . get_admin_url();?>" />
					<input type="hidden" name="urlBase" id="wr_contactform_urlBase" value="<?php echo '' . get_site_url();?>" />
					<input type="hidden" name="languages" id="wr_contactform_languages" value='<?php echo '' . json_encode( $languages ) . '';?>' />
					<input type="hidden" id="wr_contactform_formStyle" name="wr_contactform_formStyle" value='<?php echo '' . htmlentities( json_encode( $formStyle ) ); ?>'>
					<input type="hidden" id="wr_contactform_dataEmailSubmitter" name="wr_contactform_dataEmailSubmitter" value="<?php echo '' . htmlentities( json_encode( $formSubmitter ) ); ?>">
				</div>
			</div>
		</div>
		<?php WR_Contactform_Helpers_Contactform::get_footer();?>
		</div>
	<?php
	}

	/**
	 * add Container form action
	 *
	 * @param $form
	 */
	public function add_container_form_action( $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage ) {
		?>
		<div id="form-action" class="form-horizontal">
		<?php do_action( 'wr_contactform_form_edit_form_action_position_1',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<div class="row-fluid">
			<fieldset id="postaction">
				<legend>
					<?php echo '' . __( 'Confirmation', WR_CONTACTFORM_TEXTDOMAIN ); ?>
				</legend>
				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __( 'WR_CONTACTFORM_SAVE_SUBMISSIONS_DES', WR_CONTACTFORM_TEXTDOMAIN ); ?>"><?php echo '' . __( 'WR_CONTACTFORM_SAVE_SUBMISSIONS', WR_CONTACTFORM_TEXTDOMAIN ); ?></label>

					<div class="controls">
						<?php
						$fieldActionSaveSubmissions = $form[ 'wr-form-field-action_save_submissions' ];
						$fieldActionSaveSubmissions->get( 'input' );
						?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label wr-label-des-tipsy" original-title="<?php echo '' . __(
						'Select the action to take after user submits the form data.', WR_CONTACTFORM_TEXTDOMAIN
					); ?>"><?php echo '' . __( 'Do Action', WR_CONTACTFORM_TEXTDOMAIN ); ?></label>

					<div class="controls">
						<?php
						$fieldActionPostForm = $form[ 'wr-form-field-form_post_action' ];;
						$fieldActionPostForm->get( 'input' );
						?>
					</div>
				</div>
				<div class="form-action-data">
					<?php
					$fieldActionPostDataForm = $form[ 'form_post_action_data' ];;
					$fieldActionPostDataForm->get( 'input' );
					?>
				</div>
			</fieldset>
		</div>
		<?php do_action( 'wr_contactform_form_edit_form_action_position_2',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
		<div class="row-fluid">
			<fieldset id="email">
				<legend>
					<?php echo '' . __( 'Email Notification', WR_CONTACTFORM_TEXTDOMAIN ); ?>
				</legend>
				<?php
				$fieldContentEmailSendTo = $form[ 'wr-form-field-content_email_send_to' ];
				$fieldContentEmailSendTo->get( 'input' );
				$fieldContentEmailSendToSubmitter = $form[ 'wr-form-field-content_email_send_to_submitter' ];
				$fieldContentEmailSendToSubmitter->get( 'input' );
				$fieldListEmailSendTo = $form[ 'wr-form-field-list_email_send_to' ];;
				$fieldListEmailSendTo->get( 'input' );
				$fieldListEmailSendToSubmitter = $form[ 'wr-form-field-list_email_send_to_submitter' ];
				$fieldListEmailSendToSubmitter->get( 'input' );
				?>
				<div class="wr-cf-panel">
					<div class="wr-cf-panel-heading clearfix">
						<h4 class="wr-cf-panel-title"><?php _e( 'Send to email(s)', WR_CONTACTFORM_TEXTDOMAIN ); ?></h4>
					</div>
					<div class="wr-cf-panel-body hide">
						<div class="control-group">
							<label class="control-label">
								Send to:
							</label>
							<div class="controls">
								<input id="wr-cf-list-email-send-to" name="wr_contactform[list_email_send_to]" pre-value="<?php echo isset ( $_COOKIE[ 'wr-cf-list_email_send_to' ] ) ? $_COOKIE[ 'wr-cf-list_email_send_to' ] : '' ; ?>">
							</div>
						</div>
						<iframe id="wr-cf-send-to-email-iframe" scrolling="yes" frameborder="0" src="<?php echo admin_url( '?wr-cf-gadget=contactform-email-settings&email=1&action=default&control=form&form_id=' . ( isset ( $_GET['post'] ) ? $_GET['post'] : '' ) ); ?>"></iframe>
					</div>
				</div>
				<div class="wr-cf-panel">
					<div class="wr-cf-panel-heading clearfix">
						<h4 class="wr-cf-panel-title"><?php _e( 'Send to responder', WR_CONTACTFORM_TEXTDOMAIN ); ?></h4>
					</div>
					<div class="wr-cf-panel-body hide">
						<div class="control-group">
							<label class="control-label">
								Send to data:
							</label>
							<div class="controls">
								<div class="email-submitters">
									<ul id="emailSubmitters" class="jsn-items-list ui-sortable"></ul>
								</div>
							</div>
						</div>
						<iframe id="wr-cf-send-to-responder-iframe" scrolling="yes" frameborder="0" src="<?php echo admin_url( '?wr-cf-gadget=contactform-email-settings&email=0&action=default&control=form&form_id=' . ( isset ( $_GET['post'] ) ? $_GET['post'] : '' ) ); ?>"></iframe>
					</div>
				</div>
			</fieldset>
		</div>
		<?php do_action( 'wr_contactform_form_edit_form_action_position_3',$form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );?>
			<?php WR_Contactform_Helpers_Contactform::get_footer();?>
		</div>
	<?php
	}
}
