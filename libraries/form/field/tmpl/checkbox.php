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

// Count options
$num_checkbox = count( $this->choices );

// Prepare name attribute
$this->attributes['name'] = ( $num_checkbox == 1 ) ? $this->name : "{$this->name}[]";
?>
<div id="<?php $this->get( 'id' ); ?>" class="it-form-field-checkbox">
<?php
foreach ( $this->choices AS $value => $label ) :
	$i = isset( $i ) ? $i + 1 : 0;
	// Update attributes
	$this->attributes['id']    = $this->get( 'id', null, true ) . $i;
	$this->attributes['value'] = $value;

	if ( ( 1 == $num_checkbox && $this->value == $value ) || ( $num_checkbox > 1 && @in_array( $value, $this->value ) ) ) {
		$this->attributes['checked'] = 'checked';
	} else {
		unset( $this->attributes['checked'] );
	}
	// Prepare additional attributes
	$attrs = array();
	if ( is_array( $label ) ) {
		// Build attributes for input markup tag
		foreach ( $label AS $k => $v ) {
			if ( 'label' != $k ) {
				$attrs[] = esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
			}
		}

		$label = $label['label'];
	}

	$attrs = count( $attrs ) ? ' ' . implode( ' ', $attrs ) : '';
	?>
	<label class="checkbox <?php if ( $this->inline ) echo 'inline'; ?>" for="<?php echo esc_attr( $this->attributes['id'] ); ?>">
		<input <?php $this->html_attributes( 'placeholder' ); echo ' ' . $attrs . ' '; ?> />
		<?php _e( $label, WR_CONTACTFORM_TEXTDOMAIN ); ?>
	</label>
	<?php
endforeach;
?>
</div>
