<?php
// Load file style
wp_enqueue_style( 'wr-megamenu_about_us', WR_CONTACTFORM_URI . 'assets/css/about-us.css' );

// Get array list of dismissed pointers for current user and convert it to array
$dismissed_pointers_thank = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

if( !in_array( 'wr_pb_settings_pointer_contactform_thank_installing', $dismissed_pointers_thank ) ){

	// Load inline style
	$style = '
		html.wp-toolbar{padding-top: 102px; }
		#wpadminbar{top:70px; }
		#wr-header{position: fixed; top: 0; width: 100%; left: 0; background: #0074a2; height: 70px; z-index: 1; }
		#wr-header .wr-logoheader{float: left; height: 100%; border-right: 1px solid #0080b1; background: #005d82; margin: 0 15px 0 0; }
		#wr-header .wr-logoheader img{margin: 13px 10px 0; }
		#wr-header p{font-size: 14px; color: #FFF; padding: 0 50px 0 0; display: table-cell; height: 70px; vertical-align: middle; }
		#wr-header p a{color: #6BD8FF; text-decoration: none; }
		#wr-header p a:hover{text-decoration: underline; color: #C1EFFF; }
		#wr-header #close-header{float: right; margin: -47px 20px 0 0; font-size: 28px; color: rgba(0,0,0,0.3); cursor: pointer; }
		#wr-header #close-header:hover{color: rgba(0,0,0,1); }
		@media screen and (max-width:600px){
			#wr-header {height: 172px; }
		}
	';
	WR_CF_Init_Assets::inline( 'css', $style );

	?>

	<div id="wr-header">
		<a class="wr-logoheader" target="_blank" href="http://www.woorockets.com/?utm_source=ContactForm%20About&utm_medium=top%20logo&utm_campaign=Cross%20Promo%20Plugins"><img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/logo-header.png'; ?>" alt="woorockets.com" /></a>
		<p><?php printf(__('Thank you for installing WR Contact Form from WooRockets Team! We are making new hi-quality themes and plugins for you ;) Follow us on <a href="%s" target="_blank" >Twitter</a> or <a href="%s" target="_blank" >Subscribe</a> to our email list and be the first to get updated.', WR_CONTACTFORM_TEXTDOMAIN ) , 'http://bit.ly/wr-freebie-twitter', 'http://www.woorockets.com/?utm_source=ContactForm%20Setting&utm_medium=banner-link&utm_campaign=Cross%20Promo%20Plugins#subscribe'); ?></p>
		<span id="close-header" class="dashicons dashicons-no"></span>
	</div>

	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$("#wr-header #close-header").click(function(){

				$.post( ajaxurl, {
					pointer: "wr_pb_settings_pointer_contactform_thank_installing", // pointer ID
					action: "dismiss-wp-pointer"
				});

				$("#wr-header").hide();
				$("html.wp-toolbar").css({'padding-top' : '32px'});
				$("#wpadminbar").css({'top' : 0});
				
			})
		});
	</script>

<?php 
	}
?>

<div class="wr-wrap">
	<div id="wr-about">
		<div class="logo-about"><img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/logo.png'; ?>" /></div>
		<div class="content-about">
			<h1><?php _e( 'About WR Contact Form', WR_CONTACTFORM_TEXTDOMAIN ); ?></h1>
			<div class="description">
				<p><?php _e( 'You would never find any other easier WordPress Contact Form builder than <strong>WR ContactForm</strong>. This free user-oriented form creator with drag-and-drop interface makes the job easier than ever. You will no longer have to worry about writing code or learning any new skill', WR_CONTACTFORM_TEXTDOMAIN ); ?>!</p>
			</div>
			<div class="info">
				<strong class="version"><?php _e( 'Current version', WR_CONTACTFORM_TEXTDOMAIN ); ?>: <?php $plugin_data = get_plugin_data( WR_CONTACTFORM_PLUGIN_FILE ); echo $plugin_data['Version']; ?> (<a target="_blank" href="http://bit.ly/wrcf-about-changelog"><?php _e( 'Change log', WR_CONTACTFORM_TEXTDOMAIN ); ?></a>)</strong>
				<p><?php _e( 'Follow us to get latest updates', WR_CONTACTFORM_TEXTDOMAIN ); ?>!</p>
				<a href="https://twitter.com/WooRockets" class="twitter-follow-button" data-show-count="false" data-size="large"><?php _e( 'Follow', WR_CONTACTFORM_TEXTDOMAIN ); ?> @WooRockets</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
		</div>
	</div>

	<div id="email-features">
		<div class="left-feature">
			<div class="box-email">
				<form action="http://www.woorockets.com/wp-content/plugins/newsletter/do/subscribe.php" method="POST">
					<input type="hidden" value="from-cf" name="nr">
					<input class="txt" type="email" name="ne" required placeholder="Enter your email..." />
					<input class="btn" type="submit" value=" " />
				</form>
				<h3><?php _e( 'Join our mailing list', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
				<p><?php _e( 'Receive the latest updates about WR Contact Form as well as all the best news from WooRockets', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
			</div>
			<div class="box-document">
				<a class="link" href="http://www.woorockets.com/docs/wr-contactform-user-manual/?utm_source=ContactForm%20About&utm_medium=link&utm_campaign=Cross%20Promo%20Plugins" target="_blank"></a>
				<img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/support.png'; ?>" />
				<h3><?php _e( 'Documentation', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
				<p><?php _e( 'Detailed construction of how to use WR Contact Form', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
			</div>
		</div>
		<div class="right-feature">
			<div role="tabpanel">
				<ul class="nav nav-tabs wr-pb-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#hot-features" aria-controls="hot-features" role="tab" data-toggle="tab"><?php _e( 'Hot Features', WR_PBL ); ?></a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="hot-features">
						<div class="feature-block">
							<h3><?php _e( 'Drag and drop', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
							<p><?php _e( 'You can save a lot of time with intuitive drag and drop operations. This can be used in many processes when working with WR Contact Form.', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
						</div>
						<div class="feature-block">
							<h3><?php _e( 'Prevent Spam', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
							<p><?php _e( 'To protect your website from spam, the Captcha function should be used. The system will require users to fill in the CAPTCHA to protect forms from spam and abuse.', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
						</div>
						<div class="feature-block">
							<h3><?php _e( 'Multiple forms', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
							<p><?php _e( 'You can create as many forms as you want. In a single form you can also choose the most suitable fields for your form.', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="get-involved">
		<h2><?php _e( 'GET INVOLVED', WR_CONTACTFORM_TEXTDOMAIN ); ?></h2>
		<div class="list-involved">
			<div class="item-involved">
				<div class="item-involved-inner">
					<div class="icon-involved"><span class="dashicons dashicons-star-filled"></span><strong><?php _e( 'Rate WR Contact Form', WR_CONTACTFORM_TEXTDOMAIN ); ?></strong></div>
					<p><?php _e( 'Share your thoughts of WR Contact Form with other WordPress folks. Next versions of WR Contact Form will be improved basing on your opinions.', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
				</div>
			</div>
			<div class="item-involved">
				<div class="item-involved-inner">
					<div class="icon-involved"><span class="dashicons dashicons-desktop"></span><strong><?php _e( 'Submit your Website', WR_CONTACTFORM_TEXTDOMAIN ); ?></strong></div>
					<p><?php _e( "Share your website using WR Contact Form with us. We can include it in our showcase collection and have it exposed to thousands of WooRockets's website visitors.", WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
				</div>
			</div>
		</div>
		<div class="list-involved">
			<div class="item-involved">
				<div class="item-involved-inner">
					<a target="_blank" class="button-primary" href="http://bit.ly/wrcf-about-rate"><?php _e( 'Review', WR_CONTACTFORM_TEXTDOMAIN ); ?></a>
				</div>
			</div>
			<div class="item-involved">
				<div class="item-involved-inner">
					<a target="_blank" class="button-primary" href="http://www.woorockets.com/contact/?utm_source=ContactForm%20About&utm_medium=button&utm_campaign=Cross%20Promo%20Plugins"><?php _e( 'Submit your website', WR_CONTACTFORM_TEXTDOMAIN ); ?></a>
				</div>
			</div>
		</div>
	</div>

	<div id="our-blog">
		<div class="left-ourblog">
			<a class="link" target = "_black" href="http://www.woorockets.com/blog/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"></a>
			<h3><?php _e( 'Learn more from <strong>OUR BLOG</strong>', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
			<span></span>
			<p><?php _e( 'Follow our blog for latest news, tutorials & interviews about WooComerce & WordPress', WR_CONTACTFORM_TEXTDOMAIN ); ?></p>
		</div>
		<div class="right-ourblog">
			<h3><?php _e( 'SEE OUR OTHER AWESOMENESS', WR_CONTACTFORM_TEXTDOMAIN ); ?></h3>
			<span>***</span>
			<div class="list-product">
				<div class="item-product">
					<div class="img-product"><a target="_blank" href="http://www.woorockets.com/freebie/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"><img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/freebies.png'; ?>"  /></a></div>
					<h4><a target="_blank" href="http://www.woorockets.com/freebie/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"><?php _e( 'Freebies download', WR_CONTACTFORM_TEXTDOMAIN ); ?></a></h4>
				</div>
				<div class="item-product">
					<div class="img-product"><a target="_blank" href="http://www.woorockets.com/plugins/wr-pagebuilder/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"><img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/page-builder.png'; ?>"  /></a></div>
					<h4><a target="_blank" href="http://www.woorockets.com/plugins/wr-pagebuilder/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins">WR PageBuilder</a></h4>
				</div>
				<div class="item-product">
					<div class="img-product"><a target="_blank" href="http://www.woorockets.com/themes/corsa/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"><img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/corsa.png'; ?>"  /></a></div>
					<h4><a target="_blank" href="http://www.woorockets.com/themes/corsa/?utm_source=ContactForm%20About&utm_medium=banner&utm_campaign=Cross%20Promo%20Plugins"><?php _e( 'Corsa theme', WR_CONTACTFORM_TEXTDOMAIN ); ?></a></h4>
				</div>
			</div>
		</div>
	</div>

	<div id="wr-logo">
		<a target="_blank" href="http://www.woorockets.com/?utm_source=ContactForm%20About&utm_medium=bot%20logo&utm_campaign=Cross%20Promo%20Plugins" class="link"></a>
		<img src="<?php echo WR_CONTACTFORM_URI . 'assets/images/about-us/logo-footer.png'; ?>" />
		<h3>www.woorockets.com</h3>
	</div>

</div>

<script type="text/javascript">
	(function($) {
		$(document).ready(function() {
			$('#email-features .left-feature .box-email form .txt').focus(function () {
				$('#email-features .left-feature .box-email form').addClass('focus');
			})
			$('#email-features .left-feature .box-email form .txt').blur(function () {
				$('#email-features .left-feature .box-email form').removeClass('focus');
			})
		});
	})(jQuery);
</script>