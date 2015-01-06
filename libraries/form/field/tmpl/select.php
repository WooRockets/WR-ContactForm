<?php
/**
 * @version    $Id$
 * @package    WR_Plugin_Framework
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

// Prepare attributes
$this->attributes[ 'name' ] = $this->multiple ? "{$this->name}[]" : $this->name;

if ( $this->multiple ) {
	$this->attributes[ 'multiple' ] = 'multiple';
}
elseif ( isset( $this->attributes[ 'multiple' ] ) ) {
	unset( $this->attributes[ 'multiple' ] );
}
$selectHtml = '';
//var_dump( $this->choices );

$selectHtml .= '<div class="jsn-form-field-select">';
$selectHtml .= '<select ' . $this->html_attributes( 'placeholder', true ) . '>';
if ( $this->placeholder ) {
	$selectHtml .= '<option value="">' . __( $this->placeholder, WR_CONTACTFORM_TEXTDOMAIN ) . '</option>';
}
foreach ( $this->choices AS $value => $label ) {
	if ( is_array( $label ) && $label[ 'type' ] == 'optiongroup' ) {
		$selectHtml .= '<optgroup label="' . __( $label[ 'text' ], WR_CONTACTFORM_TEXTDOMAIN ) . '">';
		$selectHtml .= __( $label[ 'text' ], WR_CONTACTFORM_TEXTDOMAIN );
		if ( is_array( $label[ 'options' ] ) ) {
			foreach ( $label[ 'options' ] as $optionKey => $optionVal ) {
				if ( is_array( $optionVal ) ) {
					// Build attributes for option markup tag
					foreach ( $optionVal AS $k => $v ) {
						if ( 'label' != $k ) {
							$attrs[ ] = esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
						}
					}
					$label = $label[ 'label' ];
				}
				$selected = '';
				if ( $this->value == $optionKey ) {
					$selected = 'selected="selected"';
				}
				$selectHtml .= '<option value="' . $optionKey . '"  ' . $attrs . ' ' . $selected . '>';
				$selectHtml .= __( $optionVal, WR_CONTACTFORM_TEXTDOMAIN );
				$selectHtml .= '</option>';
			}
		}
		$selectHtml .= '</optgroup>';
	}
	else {
		if ( is_array( $label ) ) {
			// Build attributes for option markup tag
			foreach ( $label AS $k => $v ) {
				if ( 'label' != $k ) {
					$attrs[ ] = esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
				}
			}
			$label = $label[ 'label' ];
		}
		// Prepare additional attributes
		$attrs = array();
		$attrs = count( $attrs ) ? implode( ' ', $attrs ) : '';
		$selected = '';
		if ( $this->value == $value ) {
			$selected = 'selected="selected"';
		}
		$selectHtml .= '<option value="' . $value . '"  ' . $attrs . ' ' . $selected . '>';
		$selectHtml .= __( $label, WR_CONTACTFORM_TEXTDOMAIN );
		$selectHtml .= '</option>';
	}

	// Trigger click event if option is selected
	if ( false !== strpos( $attrs, ' onclick="' ) && $this->value == $value ) {
		$script = '
$(window).load(function() {
$("#' . $this->get( 'id', null, true ) . ' > option[selected]").trigger("click");
});';
		WR_CF_Init_Assets::inline( 'js', $script, true );
	}
}
$selectHtml .= '</select></div>';
echo '' . $selectHtml;
?>
