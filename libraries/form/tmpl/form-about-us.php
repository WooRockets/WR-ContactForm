<?php
// Load bootstrap
WR_CF_Init_Assets::load( array( 'wr-bootstrap3-css', 'wr-bootstrap3-js' ) );

// Load inline style
$style = '
	.jsn-bootstrap3 { max-width: 1148px; }
	.jsn-bootstrap3 .wr-tabs li a { font-size: 16px; }
	.jsn-bootstrap3 p { font-size: 14px; text-align: justify; }
	.jsn-bootstrap3 .wr-button { vertical-align: top !important; padding: 3px 12px !important; margin-right: 5px; margin-bottom: 10px !important; }
	.jsn-bootstrap3 .wr-button-bar { margin-bottom: 10px; }
	.jsn-bootstrap3 h3 { font-size: 20px !important; font-weight: bold !important; }
	.jsn-bootstrap3 #hot-features p { padding-left: 20px; }
	.jsn-bootstrap3 .feature-block { background: #fff; border-radius: 8px; padding: 1px 20px 10px 20px; margin-top: 10px; }
	.jsn-bootstrap3 #for-developers > p:first-child, .jsn-bootstrap3 #for-translators > p:first-child { margin-top: 20px; }
	.jsn-bootstrap3 .translators-list a { text-decoration: underline; }
	.wr-banner-wrapper .wr-banner { float: left; line-height: 0; margin: 0px 10px 0px 10px; }
	.wr-banner-l a { text-decoration: none; }
	.wr-banner-l img { margin-right: 10px; }
	.wr-plugin-version { display: inline-block; vertical-align: top; margin: 5px 0px 0px 5px; font-size: 14px; }
';
WR_Megamenu_Init_Assets::inline( 'css', $style );
?>

<div class="wrap">
	<div class="jsn-bootstrap3">
		<h2><strong><?php _e( 'Welcome to WR Contact Form', WR_CONTACTFORM_TEXTDOMAIN ); ?></strong></h2>
		<div class="wr-button-bar">
			<a class="btn btn-info wr-button" href="<?php echo admin_url( 'edit.php?post_type=wr_cf_post_type&page=wr-contactform-settings' ); ?>">Settings</a>
			<a class="btn btn-info wr-button" href="http://bit.ly/wrcf-about-docs" target="_blank">Docs</a>
			<a href="https://twitter.com/WooRockets" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @WooRockets</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<span class="wr-plugin-version">Version <?php $plugin_data = get_plugin_data( WR_CONTACTFORM_PLUGIN_FILE ); echo $plugin_data['Version']; ?>. Follow us to get latest updates!</span>
		</div>
		<p>Thank you for installing! <strong>WR Contact Form</strong> is a WordPress form plugin which helps you create forms quickly and easily – from normal forms to complex forms. Moreover, you can easily manage all the submissions as the administrator. The configured form can be published in any part of a website including: in page, post content and widgets via shortcode.</p>
		<h2>Hot Features</h2>
		<div class="feature-block">
			<h3>Drag and drop</h3>
			<p>You can save a lot of time with intuitive drag and drop operations. This can be used in many processes when working with <strong>WR Contact Form</strong>.</p>
		</div>
		<div class="feature-block">
			<h3>Prevent Spam</h3>
			<p>To protect your website from spam, <strong>the Captcha</strong> function should be used. The system will require users to fill in the <strong>CAPTCHA</strong> to protect forms from spam and abuse.</p>
		</div>
		<div class="feature-block">
			<h3>Multiple forms</h3>
			<p>You can create as many forms as you want. In a single form you can also choose the most suitable fields for your form.</p>
		</div>
		<!-- <div role="tabpanel">
			<ul class="nav nav-tabs wr-tabs" role="tablist">
				<li role="presentation" class="active">
					<a href="#hot-features" aria-controls="hot-features" role="tab" data-toggle="tab">Hot Features</a>
				</li>
				<li role="presentation">
					<a href="#for-developers" aria-controls="for-developers" role="tab" data-toggle="tab">For Developers</a>
				</li>
				<li role="presentation">
					<a href="#for-translators" aria-controls="for-translators" role="tab" data-toggle="tab">For Translators</a>
				</li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="hot-features">
					<div class="feature-block">
						<h3>Drag and drop</h3>
						<p>You can save a lot of time with intuitive drag and drop operations. This can be used in many processes when working with <strong>WR Contact Form</strong>.</p>
					</div>
					<div class="feature-block">
						<h3>Prevent Spam</h3>
						<p>To protect your website from spam, <strong>the Captcha</strong> function should be used. The system will require users to fill in the <strong>CAPTCHA</strong> to protect forms from spam and abuse.</p>
					</div>
					<div class="feature-block">
						<h3>Multiple forms</h3>
						<p>You can create as many forms as you want. In a single form you can also choose the most suitable fields for your form.</p>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="for-developers">
					<p>If you are going to build Add-on for WR Contact Form, this document is made for you. This part includes a knowledge base about WR Contact Form, some basic APIs, and a tutorial to make a simple Add-on with a simple element.</p>
					<a class="btn btn-info wr-button" href="http://www.woorockets.com/docs/wr-contactform-user-manual/" target="_blank">Docs for Developers</a>
					<p>Get our Source Code at Github!</p>
					<a class="btn btn-info wr-button" href="https://github.com/wp-plugins/wr-contactform/" target="_blank">Source Code</a>
					<p>Having any exciting ideas or improvements for WR Contact Form to grow our WordPress Community? Drop an email to our WooRockets Astronaut Tony at <a href="mailto:tony@woorockets.com">tony@woorockets.com</a>!</p>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="for-translators">
					<p>If you are reading this, we need your contribution! We appreciate all kinds of support for Translating WR Contact Form into your language!</p>
				</div>
			</div>
		</div> -->
		<br />
		<br />
		<!-- Banners -->
		<div class="wr-banner-wrapper">
			<h3>See our other free awesomeness</h3>
			<a class="wr-banner" href="http://www.woorockets.com/plugins/wr-megamenu/?utm_source=ContactForm%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
				<img width="278" height="156" src="<?php echo WR_CONTACTFORM_URI . 'assets/images/banners/MegaMenu_S.jpg'; ?>" alt="WR Mega Menu" />
			</a>
			<a class="wr-banner" href="http://www.woorockets.com/plugins/wr-pagebuilder/?utm_source=ContactForm%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
				<img width="278" height="156" src="<?php echo WR_CONTACTFORM_URI . 'assets/images/banners/PageBuilder_S.jpg'; ?>" alt="WR Page Builder" />
			</a>
			<a class="wr-banner" href="http://www.woorockets.com/themes/corsa/?utm_source=ContactForm%20Setting&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins" target="_blank">
				<img width="278" height="156" src="<?php echo WR_CONTACTFORM_URI . 'assets/images/banners/Corsa_S.jpg'; ?>" alt="WR Corsa" />
			</a>
		</div>
	</div>
</div>
