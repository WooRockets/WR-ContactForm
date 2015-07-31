<?php
require_once( WR_CONTACTFORM_PATH . '/helpers/form-edit.php' );
$getContainerFormEdit = new WR_Contactform_Helpers_Form_Edit();
$items = new stdClass;
$formContent = array();
if ( ! empty( $_GET[ 'post' ] ) && is_numeric( $_GET[ 'post' ] ) ) {


	$get_post = $_GET[ 'post' ];

	$meta = get_post_meta( (int)$get_post );
	if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
		$items->form_id = (int)$meta[ 'form_id' ][ 0 ];
	}
	else {
		$items->form_id = (int)$get_post;
	}
}
else {
	$meta = get_post_meta( 0 );
	$items->form_id = 0;
}
unset( $_SESSION[ 'form-design-' . $items->form_id ] );
unset( $_SESSION[ 'form-design-' ] );
$formContent = WR_Contactform_Helpers_Contactform::get_form_content( $items->form_id );
$formPage = isset( $formContent[ 0 ]->page_content ) ? $formContent[ 0 ]->page_content : '';
$listPage = WR_Contactform_Helpers_Contactform::get_list_page( $formContent, $items->form_id );
$form = array();

foreach ( $this->fields AS $section => $fields ) {
	if ( ! empty( $fields[ 'fields' ] ) ) {
		foreach ( $fields[ 'fields' ] as $key => $field ) {
			$form[ $key ] = $field;
		}
	}
}

$limitSize = (int)( ini_get( 'post_max_size' ) );
if ( $limitSize > (int)( ini_get( 'upload_max_filesize' ) ) ) {
	$limitSize = (int)( ini_get( 'upload_max_filesize' ) );
}
//get form style
$formStyle = new stdClass;
if ( ! empty( $meta[ 'form_style' ][ 0 ] ) ) {
	$formStyle = json_decode( $meta[ 'form_style' ][ 0 ] );
}
else {
	$formStyle->themes_style = new stdClass;

	$formStyle->themes_style->light = '{"background_color":"#ffffff","background_active_color":"#fcf8e3","border_thickness":"0","border_color":"#ffffff","border_active_color":"#fbeed5","rounded_corner_radius":"0","padding_space":"10","margin_space":"0","text_color":"#333333","font_type":"Verdana, Geneva, sans-serif","font_size":"14","field_background_color":"#ffffff","field_border_color":"#cccccc","field_shadow_color":"#ffffff","field_text_color":"#666666","message_error_background_color":"#b94a48","message_error_text_color":"#ffffff","help_text_type":"tooltip","button_position":"btn-toolbar","button_submit_color":"btn btn-primary","button_reset_color":"btn","button_prev_color":"btn","button_next_color":"btn","custom_css":""}';

	$formStyle->themes_style->dark = '{"background_color":"#ffffff","background_active_color":"#444444","border_thickness":"0","border_color":"#ffffff","border_active_color":"#666666","rounded_corner_radius":"0","padding_space":"10","margin_space":"0","text_color":"#c6c6c6","font_type":"Verdana, Geneva, sans-serif","font_size":"14","field_background_color":"#000000","field_border_color":"#111111","field_shadow_color":"#000000","field_text_color":"#333333","message_error_background_color":"#b94a48","message_error_text_color":"#ffffff","help_text_type":"tooltip","button_position":"btn-toolbar","button_submit_color":"btn btn-primary","button_reset_color":"btn","button_prev_color":"btn","button_next_color":"btn","custom_css":""}';

	$formStyle->themes = array( 'light', 'dark' );
}
$globalFormStyle = get_option( 'wr_contactform_style' );
if ( ! empty( $globalFormStyle ) ) {
	$globalFormStyle = json_decode( $globalFormStyle );

	if ( ! empty( $globalFormStyle->themes_style ) ) {
		foreach ( $globalFormStyle->themes_style as $key => $value ) {
			$formStyle->themes_style->{$key} = $value;
		}
	}
	if ( ! empty( $globalFormStyle->themes ) ) {
		foreach ( $globalFormStyle->themes as $key => $value ) {
			$formStyle->themes[ ] = $value;
		}
	}
}
if ( ! empty( $formStyle->theme ) && ! empty( $formStyle->themes_style ) && $formStyle->theme != 'wr-style-light' && $formStyle->theme != 'wr-style-dark' ) {

	$theme = str_replace( 'wr-style-', '', $formStyle->theme );

	if ( ! empty( $formStyle->themes_style->{$theme} ) ) {
		$styles = json_decode( $formStyle->themes_style->{$theme} );
	}

	$formStyle->background_color = ! empty( $styles->background_color ) ? $styles->background_color : '';

	$formStyle->background_active_color = ! empty( $styles->background_active_color ) ? $styles->background_active_color : '';

	$formStyle->border_active_color = ! empty( $styles->border_active_color ) ? $styles->border_active_color : '';

	$formStyle->border_thickness = ! empty( $styles->border_thickness ) ? $styles->border_thickness : '';

	$formStyle->border_color = ! empty( $styles->border_color ) ? $styles->border_color : '';

	$formStyle->rounded_corner_radius = ! empty( $styles->rounded_corner_radius ) ? $styles->rounded_corner_radius : '';

	$formStyle->padding_space = ! empty( $styles->padding_space ) ? $styles->padding_space : '';

	$formStyle->margin_space = ! empty( $styles->margin_space ) ? $styles->margin_space : '';

	$formStyle->text_color = ! empty( $styles->text_color ) ? $styles->text_color : '';

	$formStyle->font_type = ! empty( $styles->font_type ) ? $styles->font_type : '';

	$formStyle->font_size = ! empty( $styles->font_size ) ? $styles->font_size : '';
}
else {
	$formStyle->background_color = ! empty( $formStyle->background_color ) ? $formStyle->background_color : '';

	$formStyle->background_active_color = ! empty( $formStyle->background_active_color ) ? $formStyle->background_active_color : '';

	$formStyle->border_active_color = ! empty( $formStyle->border_active_color ) ? $formStyle->border_active_color : '';

	$formStyle->border_thickness = ! empty( $formStyle->border_thickness ) ? $formStyle->border_thickness : '';

	$formStyle->border_color = ! empty( $formStyle->border_color ) ? $formStyle->border_color : '';

	$formStyle->rounded_corner_radius = ! empty( $formStyle->rounded_corner_radius ) ? $formStyle->rounded_corner_radius : '';

	$formStyle->padding_space = ! empty( $formStyle->padding_space ) ? $formStyle->padding_space : '';

	$formStyle->margin_space = ! empty( $formStyle->margin_space ) ? $formStyle->margin_space : '';

	$formStyle->text_color = ! empty( $formStyle->text_color ) ? $formStyle->text_color : '';

	$formStyle->font_type = ! empty( $formStyle->font_type ) ? $formStyle->font_type : '';

	$formStyle->font_size = ! empty( $formStyle->font_size ) ? $formStyle->font_size : '';

	if ( empty( $formStyle->background_active_color ) && empty( $formStyle->border_active_color ) && empty( $formStyle->border_thickness ) && empty( $formStyle->border_color ) && empty( $formStyle->rounded_corner_radius ) && empty( $formStyle->background_color ) && empty( $formStyle->font_size ) && empty( $formStyle->text_color ) && empty( $formStyle->margin_space ) && empty( $formStyle->padding_space ) ) {
		$formStyle->theme = '';
		$formStyle->themes_style = new stdClass;

		$formStyle->themes_style->light = '{"background_color":"#ffffff","background_active_color":"#fcf8e3","border_thickness":"0","border_color":"#ffffff","border_active_color":"#fbeed5","rounded_corner_radius":"0","padding_space":"10","margin_space":"0","text_color":"#333333","font_type":"Verdana, Geneva, sans-serif","font_size":"14","field_background_color":"#ffffff","field_border_color":"#cccccc","field_shadow_color":"#ffffff","field_text_color":"#666666","message_error_background_color":"#b94a48","message_error_text_color":"#ffffff","help_text_type":"tooltip","button_position":"btn-toolbar","button_submit_color":"btn btn-primary","button_reset_color":"btn","button_prev_color":"btn","button_next_color":"btn","custom_css":""}';

		$formStyle->themes_style->dark = '{"background_color":"#ffffff","background_active_color":"#444444","border_thickness":"0","border_color":"#ffffff","border_active_color":"#666666","rounded_corner_radius":"0","padding_space":"10","margin_space":"0","text_color":"#c6c6c6","font_type":"Verdana, Geneva, sans-serif","font_size":"14","field_background_color":"#000000","field_border_color":"#111111","field_shadow_color":"#000000","field_text_color":"#333333","message_error_background_color":"#b94a48","message_error_text_color":"#ffffff","help_text_type":"tooltip","button_position":"btn-toolbar","button_submit_color":"btn btn-primary","button_reset_color":"btn","button_prev_color":"btn","button_next_color":"btn","custom_css":""}';

		$formStyle->themes = array( 'light', 'dark' );
	}
}
$listFontType = array(
	'Verdana, Geneva, sans-serif',
	'Times New Roman, Times, serif',
	'Courier New, Courier, monospace',
	'Tahoma, Geneva, sans-serif',
	'Arial, Helvetica, sans-serif',
	'Trebuchet MS, Arial, Helvetica, sans-serif',
	'Arial Black, Gadget, sans-serif',
	'Lucida Sans Unicode,Lucida Grande, sans-serif',
	'Palatino Linotype, Book Antiqua, Palatino, serif',
	'Comic Sans MS, cursive',
);
$formSettings = ! empty( $meta[ 'form_settings' ][ 0 ] ) ? json_decode( $meta[ 'form_settings' ][ 0 ] ) : '';

$actionForm = array(
	'redirect_to_url' => '',
	'menu_item' => '',
	'menu_item_title' => '',
	'article' => '',
	'article_title' => '',
	'message' => '',
	'action' => '1',
);
$actionForm = WR_Contactform_Helpers_Contactform::action_from( $meta[ 'form_post_action' ], $meta[ 'form_post_action_data' ] );
$listTabs = array();
$listTabs[ 'form-design' ] = '<li class="active"><a href="#form-design"><i class="icon-list-alt"></i>' . __( 'Form Design', WR_CONTACTFORM_TEXTDOMAIN ) . '</a></li>';
$listTabs[ 'form-action' ] = '<li> <a href="#form-action"><i class="icon-magic"></i> ' . __( 'Form Action', WR_CONTACTFORM_TEXTDOMAIN ) . ' </a> </li>';
$getListTabs = apply_filters( 'wr_contactform_form_edit_list_tabs', $listTabs );
if ( ! empty( $getListTabs ) ) {
	$listTabs = $getListTabs;
}

$formItems   = isset( $formItems ) ? $formItems : null;
?>
<div class="jsn-master" id="wr_contactform_master">
	<div class="jsn-bootstrap">
		<input type="hidden" name="fix_yoast_wordpress_seo" id="content" value="">
		<div id="style_inline">
			<style class="formstyle">
				<?php
				echo '' . WR_Contactform_Helpers_Contactform::generate_style_pages( $formStyle, '.jsn-master #form-design-content .jsn-element-container .jsn-element', '.jsn-master #form-design-content .jsn-element-container .jsn-element.ui-state-edit', '.jsn-master #form-design-content .jsn-element-container .jsn-element .control-label', '', '', '.jsn-master #form-design-content .jsn-element-container .jsn-element .controls input,.jsn-master #form-design-content .jsn-element-container .jsn-element .controls select,.jsn-master #form-design-content .jsn-element-container .jsn-element .controls textarea' );
				?>
			</style>
			<style class="formstylecustom">
				<?php
				echo '' . ! empty( $formStyle->custom_css ) ? $formStyle->custom_css : '';
				?>
			</style>
		</div>
		<div class="jsn-tabs">
			<ul><?php echo '' . implode( '', $listTabs );?></ul>
			<?php
			do_action( 'wr_contactform_form_container_tabs', $form, $formStyle, $formSettings, $listPage, $listFontType, $items, $formItems, $formPage );
			?>
		</div>
		<?php do_action( 'wr_cf_load_sample_form_selectbox' ); ?>
	</div>
</div>