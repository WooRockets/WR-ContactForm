<?php
/**
 * @version    $Id$
 * @package    WR_Library
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */
?>
<div class="wr-form-field-color-picker input-group" id="<?php $this->get( 'id' ); ?>">
	<input type="text" <?php $this->html_attributes( array( 'id', 'type' ) ); ?> />
	<span class="input-group-btn">
		<a href="javascript:void(0);" class="btn btn-default btn-sm" title="<?php _e( 'Pick Color', $this->text_domain ); ?>">...</a>
	</span>
<?php
// Load Javascript assets and initialization if not already loaded
if ( ! defined( 'WR_COLOR_PICKER_INITIALIZED' ) ) :

define( 'WR_COLOR_PICKER_INITIALIZED', true );

WR_CF_Init_Assets::load( array( 'wr-colpick-js', 'wr-colpick-css' ) );

$script = '
		$(".wr-form-field-color-picker > input").each(function(i, e) {
			// Handle manual color input
			$(e).keypress(function() {
				if ($(e).val().substr(0, 1) != "#") {
					return;
				}

				if ($(e).val().length == 7) {
					$(e).next().find("a.btn").css({
						"background-color": $(e).val(),
						"color": $(e).val()
					}).colpickSetColor($(e).val().substr(1));
				}
			});
		});

		$(".wr-form-field-color-picker > .input-group-btn > a.btn").each(function(i, e) {
			// Set button color
			$(e).css({
				"background-image": "none",
				"text-shadow": "none",
				"background-color": $(e).parent().prev().val(),
				"color": $(e).parent().prev().val()
			}).colpick({
				submit: false,
				color: $(e).parent().prev().val().substr(1),
				colorScheme: "dark",
				onShow: function(color_picker) {
					$(color_picker).fadeIn(500);

					return false;
				},
				onHide: function(color_picker) {
					$(color_picker).fadeOut(500);

					return false;
				},
				onChange: function(hsb, hex, rgb) {
					$(e).parent().prev().val("#" + hex).trigger("change");
					$(e).css({
						"background-color": "#" + hex,
						"color": "#" + hex
					});
				}
			});
		});';

WR_CF_Init_Assets::inline( 'js', $script, true );

endif;
?>
</div>
