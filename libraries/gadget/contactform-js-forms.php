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

class WR_CF_Gadget_Contactform_Js_Forms extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-forms';

	/**
	 * Constructor.
	 *
	 * @return  void
	 */
	public function __construct() {

	}

	/**
	 *  set default action
	 */
	public function default_action() {
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		auth_redirect();
		header( 'Content-Type: application/javascript' );
		$jsHook = array();
		$jsHook[ 'button-addnew-action' ] = '$("#wpbody-content .jsn-form-title-heading h2").after(
			            $("<div/>", {"class":"contactform-add-new"}).append(
			                $("<a/>", {"text":"Add New", "href":"javascript:void(0);"})

			            ).append(
			                $("<ul/>", {"class":"contactform-sample-form"}).append(
			                    $("<li/>").append(
			                        $("<a/>", {"class":"", "href":"post-new.php?post_type=wr_cf_post_type", "text":"Blank Form"})
			                    )
			                )
			            )
			        );';
		$jsHook = apply_filters( 'wr_contactform_js_forms_hook', $jsHook );
		$javascript = '(function ($) {
			    $(function () {
					$(".jsn-modal-overlay,.jsn-modal-indicator").remove();
	                $("body").append($("<div/>", {
	                    "class":"jsn-modal-overlay",
	                    "style":"z-index: 1000; display: inline;"
	                })).append($("<div/>", {
	                    "class":"jsn-modal-indicator",
	                    "style":"display:block"
	                })).addClass("jsn-loading-page");
			        $("#wpbody-content h2 .add-new-h2").hide();
			        $("#search-submit").val(\'Search Forms\');
			        $("#wpbody-content h2 .add-new-h2").parent().after(
			            $("<div/>", {"class":"jsn-form-title-heading"})
			        );
			        $("#wpbody-content h2 .add-new-h2").parent().appendTo($("div.jsn-form-title-heading"));
			        ' . implode( '', $jsHook ) . '
			        $("#wpbody-content .contactform-add-new > a").click(function () {
			            if ($(".contactform-add-new").hasClass("active")) {
			                $(".contactform-add-new").removeClass("active");
			            } else {
			                $(".contactform-add-new").addClass("active");
			            }
			            return false;
			        });
			        $(document).click(function () {
			            $(".contactform-add-new").removeClass("active");
			        });
			        setTimeout(function () {
		                $("#wpbody-content").show();
			            $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
		           }, 500);
			    });
			})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
