/**
 * @package    WR_ContactForm
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * @Websites   http://www.woorockets.com
 */
( function( $ ) {

	// Display template selectbox
	$( function() {
		$( '#wr-cf-sample-form-block' ).appendTo( '#wpbody-content>.wrap>h2:first-child' ).removeClass( 'hidden' );
		$( '#wr-cf-sample-form-block' ).append( '<a href="#" class="button button-disabled">Apply</a>' );
		var btnApply = $( '#wr-cf-sample-form-block' ).find( '.button' );
		btnApply.on( 'click', function() {
			return false;
		} );
		$( '#wr-cf-sample-form' ).change( function() {
			if ( $( this ).val() != "" ) {
				btnApply.attr( 'href', 'post-new.php?post_type=wr_cf_post_type&form=' + $( this ).val() );
				btnApply.addClass( 'button-primary' ).removeClass( 'button-disabled' );
				btnApply.off( 'click' );
				btnApply.on( 'click', function() {
					return confirm( 'Are you sure you want to quit this current form to start the selected one?' );
				} );
			} else {
				btnApply.attr( 'href', '#' );
				btnApply.addClass( 'button-disabled' ).removeClass( 'button-primary' );
				btnApply.off( 'click' );
				btnApply.on( 'click', function() {
					return false;
				} );
			}
		} );
	} );

} )( jQuery );