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
$getValue = ! empty( $this->value ) ? $this->value : '';
$output = '<div class="control-group"><div class="controls">';
$output .= '<div id="action_data_contactform_url" class="hide action-options">';
$output .= '<input type="text" name="contactform_action_data[contactform_url]" value="' . ( ! empty( $getValue[ 'contactform_url' ] ) ? $getValue[ 'contactform_url' ] : '' ) . '" />';
$output .= '</div>';
$output .= '<div id="action_data_contactform_show_message" class="hide action-options">';
$output .= '<textarea name="contactform_action_data[contactform_show_message]" id="action_contactform_show_message" class="jsn-input-xlarge-fluid">' . ( ! empty( $getValue[ 'contactform_show_message' ] ) ? $getValue[ 'contactform_show_message' ] : 'Thanks for your submit! ' ) . '</textarea>';
$output .= '</div>';
if ( ! empty( $this->items ) ) {
	foreach ( $this->items as $items ) {
		$output .= '<div id="action_data_' . $items[ 'name' ] . '" class="hide action-options">';
		if ( ! empty( $items[ 'options' ] ) ) {
			$output .= '<select class="wr-contactform-select2" name=\'contactform_action_data[' . $items[ 'name' ] . ']\'>';
			foreach ( $items[ 'options' ] as $value => $text ) {
				$selected = '';
				$optionName = $items[ 'name' ];
				if ( ! empty( $getValue[ $optionName ] ) && $getValue[ $optionName ] == $value ) {
					$selected = 'selected="selected"';
				}
				$output .= '<option ' . $selected . ' value="' . $value . '">' . $text . '</option>';
			}
			$output .= '</select>';
		}
		else {
			$output .= __( 'No', WR_CONTACTFORM_TEXTDOMAIN ) . ' ' . str_replace(
				array( '_', '-' ), ' ', $items[ 'name' ]
			) . ' found';
		}
		$output .= '</div>';
	}
}
$output .= '</div>';
echo '' . $output;

?>
