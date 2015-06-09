<?php
if ( ! empty( $_POST[ 'wr_contactform_config' ] ) ) {
	foreach ( $_POST[ 'wr_contactform_config' ] as $key => $value ) {
		if ( get_option( $key ) !== false ) {
			// The option already exists, so we just update it.
			update_option( $key, $value );
		}
		else {
			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $key, $value, $deprecated, $autoload );
		}
	}
}
$loadBootstrapCss = get_option( 'wr_contactform_load_bootstrap_css', 1 );
$checkLoadCssBootstrap = '';
if ( $loadBootstrapCss != '0' && $loadBootstrapCss != 0 ) {
	$checkLoadCssBootstrap = 'checked="checked" ';
}
$loadBootstrapJs = get_option( 'wr_contactform_load_bootstrap_js', 1 );

$checkLoadJsBootstrap = '';
if ( $loadBootstrapJs != '0' && $loadBootstrapJs != 0 ) {
	$checkLoadJsBootstrap = 'checked="checked" ';
}

$default_mail_from = get_option( 'wr_contactform_default_mail_from', WR_Contactform_Helpers_Contactform::get_default_mail_from() );

// Captcha setting
$global_captcha_setting = get_option( 'wr_contactform_global_captcha_setting', 2 );
$check_enable_captcha_all = '';
$check_disable_captcha_all = '';
$check_use_individual_setting = '';
switch ( $global_captcha_setting ) {
	case 1:
		$check_enable_captcha_all = ' checked="checked"';
		break;
	case 0:
		$check_disable_captcha_all = ' checked="checked"';
		break;
	default:
		$check_use_individual_setting = ' checked="checked"';
}
?>
<div class="wrap">
	<h2><?php echo '' . __( 'WR ContactForm Settings', WR_CONTACTFORM_TEXTDOMAIN );?></h2>
	<?php if ( ! empty( $_POST ) ) { ?>
	<div class="updated below-h2" id="message"><p>Settings updated.</p></div>
	<?php } ?>
	<form method="POST" id="wr_contactform_settings">
		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row">
					<label><?php echo '' . __( 'Load Bootstrap Assets', WR_CONTACTFORM_TEXTDOMAIN );?></label>
				</th>
				<td>
					<label class="auto-get-data">
						<input type="checkbox" <?php echo '' . $checkLoadJsBootstrap;?> value="1" id="wr_contactform_load_bootstrap_js"> <?php echo '' . __( 'JS', WR_CONTACTFORM_TEXTDOMAIN );?>
						<input type="hidden" value="<?php echo '' . $loadBootstrapJs;?>" name="wr_contactform_config[wr_contactform_load_bootstrap_js]" id="wr_confwr_contactform_load_bootstrap_js" />
					</label>
					<br>
					<label class="auto-get-data">
						<input type="checkbox" <?php echo '' . $checkLoadCssBootstrap;?> value="1" id="wr_contactform_load_bootstrap_css"> <?php echo '' . __( 'CSS', WR_CONTACTFORM_TEXTDOMAIN );?>
						<input type="hidden" value="<?php echo '' . $loadBootstrapCss;?>" name="wr_contactform_config[wr_contactform_load_bootstrap_css]" id="wr_confwr_contactform_load_bootstrap_css" />
					</label>

					<p class="description"><?php echo '' . __( 'You should choose NOT to load Bootstrap JS / CSS if your theme or some other plugin installed on your website already loaded it.', WR_CONTACTFORM_TEXTDOMAIN );?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label><?php _e( 'From Email', WR_CONTACTFORM_TEXTDOMAIN );?></label>
				</th>
				<td>
					<input type="text" value="<?php esc_attr_e( $default_mail_from ); ?>" class="regular-text" id="default_mail_from" name="wr_contactform_config[wr_contactform_default_mail_from]" autocomplete="off" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label><?php echo '' . __( 'Captcha Setting', WR_CONTACTFORM_TEXTDOMAIN );?></label>
				</th>
				<td>
					<fieldset>
						<label>
							<input type="radio" name="wr_contactform_config[wr_contactform_global_captcha_setting]" value="1"<?php echo $check_enable_captcha_all;?> />
							<span><?php _e( 'Enable Captcha for all forms', WR_CONTACTFORM_TEXTDOMAIN );?></span>
						</label>
						<br />
						<label>
							<input type="radio" name="wr_contactform_config[wr_contactform_global_captcha_setting]" value="0"<?php echo $check_disable_captcha_all;?> />
							<span><?php _e( 'Disable Captcha for all forms', WR_CONTACTFORM_TEXTDOMAIN );?></span>
						</label>
						<br />
						<label>
							<input type="radio" name="wr_contactform_config[wr_contactform_global_captcha_setting]" value="2"<?php echo $check_use_individual_setting;?> />
							<span><?php _e( 'Use Form\'s individual setting', WR_CONTACTFORM_TEXTDOMAIN );?></span>
						</label>
					</fieldset>
				</td>
			</tr>
			<?php do_action( 'wr_contactform_action_config' );?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
	</form>

	<div id="wr-promo-ab">
		<h3>Premium<br>
		WooCommerce Themes</h3>
		<ul>
			<li><span><img src="<?php echo WR_CONTACTFORM_URI; ?>assets/images/about-us/excellent-icon.png"></span>Excellent designs</li>
			<li><span><img src="<?php echo WR_CONTACTFORM_URI; ?>assets/images/about-us/unlimited-icon.png"></span>Unlimited customization ability</li>
			<li><span><img src="<?php echo WR_CONTACTFORM_URI; ?>assets/images/about-us/additional-icon.png"></span>Additional eCommerce features</li>
		</ul>
		<p class="btn-premium"><a href="http://www.woorockets.com/themes/?utm_source=ContactForm&utm_medium=Setting&utm_campaign=Cross%20Promo%20Banner" target="_blank"><strong>View the collection now</strong><br>
		<span>And learn how our themes can boost your business!</span></a></p>
	</div>

</div>
<?php
$script = '(function ($) {
	$(".jsn-modal-overlay,.jsn-modal-indicator").remove();
    $("body").append($("<div/>", {
        "class":"jsn-modal-overlay",
        "style":"z-index: 1000; display: inline;"
    })).append($("<div/>", {
        "class":"jsn-modal-indicator",
        "style":"display:block"
    })).addClass("jsn-loading-page");
    $("#wr_contactform_settings label.auto-get-data input:checkbox").change(function(){
		if($(this).is(":checked")){
			$(this).parent().find("input:hidden").val(1);
		}else{
			$(this).parent().find("input:hidden").val(0);
		}
    });
     setTimeout(function () {
        $("#wpbody-content").show();
        $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
   }, 500);
  })(jQuery);';
WR_CF_Init_Assets::inline( 'js', $script );

$style = '
	.wr-banner-wrapper .wr-banner { float: left; line-height: 0; margin: 0px 10px 0px 10px; }

	/*** Premium ***/
	#wr-promo-ab {
		background: url(' . WR_CONTACTFORM_URI . 'assets/images/about-us/bg-wr-promo.jpg) center top no-repeat;
		background-size: auto 100%;
		text-align: center;
		width: 1030px;
		margin-top: 20px;
	}
	#wr-promo-ab h3 {
		margin: 70px 0 30px;
		font-size: 32px;
		line-height: 1.1;
	}
	#wr-promo-ab ul {
	    margin: 0 10px 25px 10px;
  		width: auto;
	}
	#wr-promo-ab li {
	    display: inline-block;
  		float: initial;
	}
	#wr-promo-ab li span {
	    background: #6c7886;
	    float: left;
	    border-radius: 50%;
	    -o-border-radius: 50%;
	    -ms-border-radius: 50%;
	    -moz-border-radius: 50%;
	    -webkit-border-radius: 50%;
	    margin: 0 5px 0 0;
	}
	#wr-promo-ab .btn-premium a {
		padding: 10px 25px;
		margin: 0;
	}
	

	@media only screen and (max-width: 1232px), (max-device-width: 1232px) {
		#wr-promo-ab {
			width:100%
		}
	}

	@media only screen and (max-width: 768px), (max-device-width: 768px) {
	  #wr-promo-ab ul {
	    width: 270px;
	    margin-right: auto;
	    margin-left: auto;
	  }
	  #wr-promo-ab ul li {
	    display: block;
	    text-align: left;
	    margin-left: 0;
	    margin-bottom: 20px;
	  }
	}
';
WR_CF_Init_Assets::inline( 'css', $style );
