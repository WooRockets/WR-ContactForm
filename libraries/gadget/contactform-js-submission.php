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

class WR_CF_Gadget_Contactform_Js_Submission extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-submission';

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
		$mainContent = array();
		$createPrototypeSubmission = array();
		/* Create filter get js main content submission*/
		$mainContent = apply_filters( 'wr_contactform_js_submission_main_content', $mainContent );
		/* Create filter get Prototype Submission*/
		$createPrototypeSubmission[ 'init' ] = 'init:function () {
								$(".jsn-modal-overlay,.jsn-modal-indicator").remove();
				                $("body").append($("<div/>", {
				                    "class":"jsn-modal-overlay",
				                    "style":"z-index: 1000; display: inline;"
				                })).append($("<div/>", {
				                    "class":"jsn-modal-indicator",
				                    "style":"display:block"
				                })).addClass("jsn-loading-page");
					            var self = this;
					            $("#post-body-content").hide();
					            var submissionSettings = $("#submission-settings");
					            $(submissionSettings).parent().appendTo($("#advanced-sortables"));
                                $("#wr_contactform_submission_detail").hide();
                                $("#wpbody-content h2").html("View Submission ["+$("#title").val()+"]");
					            $("#wr-submission-edit").click(function () {
					                $(this).addClass("hide");
					                $("#wr-submission-save").removeClass("hide");
					                $("#wr-submission-cancel").removeClass("hide");
					                $("dl.submission-page-content").addClass("hide");
					                $("div.submission-page-content").removeClass("hide");
					            });
					            $("#submission-settings .wr-tabs").tabs();
					            $("#wr-submission-save").click(function () {
					                $(".submission-content .submission-page .submission-page-content input").each(function () {
					                    var key = $(this).attr("dataValue");
					                    var type = $(this).attr("typeValue");
					                    $(this).attr("oldValue", $(this).val());

					                    if (type != "email") {
					                        $("dd#" + key).html($(this).val().replace(/[\u00A0-\u9999<>\&]/gim, function(i) { return \'&#\'+i.charCodeAt(0)+\';\'; }));
					                    } else {
					                        if ($(this).val()) {
					                            $("dd#" + key + " a").html($(this).val().replace(/[\u00A0-\u9999<>\&]/gim, function(i) { return \'&#\'+i.charCodeAt(0)+\';\'; }));
					                        } else {
					                            $("dd#" + key + " a").html("N/A");
					                        }
					                    }
					                });
					                 $(".submission-content .submission-page .submission-page-content .wr-likert tbody").each(function () {
					                    var idContainer = $(this).find("input.wr-likert-settings").attr("data-value");
					                    $("dd#"+idContainer).empty();
										 $(this).find("tr input[type=radio]:checked").each(function(){
												$("dd#"+idContainer).append("<strong>"+$(this).attr("data-value")+"</strong>"+$(this).val()+"<br/>");
										 });
					                 });
					                $(".submission-content .submission-page .submission-page-content textarea").each(function () {
					                    var key = $(this).attr("dataValue");
					                    $(this).attr("oldValue", $(this).val());
					                    if ($(this).val()) {
					                        var value = $(this).val().split("\n");
					                        $("dd#" + key).html(value.join("<br/>"));
					                    } else {
					                        $("dd#" + key).html("N/A");
					                    }
					                });
					                $(this).addClass("hide");
					                $("#wr-submission-cancel").addClass("hide");
					                $("#wr-submission-edit").removeClass("hide");
					                $("dl.submission-page-content").removeClass("hide");
					                $("div.submission-page-content").addClass("hide");

					            });
					            $(".jsn-page-actions .prev-page").click(function () {
					                self.prevpaginationPage();
					            });
					            $(".jsn-page-actions .next-page").click(function () {
					                self.nextpaginationPage();
					            });
					            $("#jform_form_type option").each(function () {
					                if ($(this).val() == $("#jform_form_type").attr("data-value")) {
					                    $(this).prop("selected", true);
					                } else {
					                    $(this).prop("selected", false);
					                }
					            });
					            $("#jform_form_type").change(function () {
					                if ($(this).val() == 2) {
					                    $(".jsn-page-actions").show();
					                    $(submissionSettings).find("div.submission-page").hide();
					                    $($(submissionSettings).find("div.submission-page")[0]).show();
					                    $(submissionSettings).find("hr").remove();
					                    $(submissionSettings).find(".submission-content .jsn-page-actions button").show();
					                    self.checkPage();
					                } else if ($(this).val() == 1) {
					                    $(".jsn-page-actions").hide();
					                    $(submissionSettings).find("div.submission-page").show();
					                    $(submissionSettings).find("div.submission-page").each(function (i) {
					                        if (i != 0) {
					                            $(this).before("<hr/>");
					                        }
					                    })
					                }
					            }).change();
					            if (!$("#jform_form_type").attr("data-value")) {
					                $(".jsn-page-actions").hide();
					                $(submissionSettings).find("div.submission-page").show();
					            }
					            $($(submissionSettings).find("div.submission-page")[0]).show();
					            $("#wr_contactform_submission_detail .hndle,#wr_contactform_submission_detail .handlediv").click(function () {
					                setTimeout(function () {
					                    self.checkPage();
					                }, 200)
					            });
					            setTimeout(function () {
					                $("#advanced-sortables,.meta-box-sortables.ui-sortable").removeClass("ui-sortable");
					              }, 200);
					            setTimeout(function () {
					                $("#wpbody-content").show();
						            $("#submission-settings").show();
						            $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
						            self.checkPage();
					           }, 500);

					        }';
		$actionCheckPage = array();
		$actionCheckPage[ 'google-maps' ] = 'console.log($(this));$(this).find(".content-google-maps").each(function () {
					                        $(this).find(\'.google_maps\').width($(this).attr("data-width"));
					                        $(this).find(\'.google_maps\').height($(this).attr("data-height"));
					                        var dataValue = $(this).attr("data-value");
					                        var dataMarker = $(this).attr("data-marker");
					                        if (dataValue) {
					                            var gmapOptions = $.parseJSON(dataValue);
					                            if (dataMarker) {
					                                var gmapMarker = $.parseJSON(dataMarker);
					                            }
					                            if (!gmapOptions.center.nb && gmapOptions.center.lb) {
					                                gmapOptions.center.nb = gmapOptions.center.lb;
					                            }
					                            if (!gmapOptions.center.ob && gmapOptions.center.mb) {
					                                gmapOptions.center.ob = gmapOptions.center.mb;
					                            }
					                            $(this).find(\'.google_maps\').gmap({\'zoom\':gmapOptions.zoom, \'mapTypeId\':gmapOptions.mapTypeId, \'center\':gmapOptions.center.nb + \',\' + gmapOptions.center.ob, \'disableDefaultUI\':false, \'callback\':function (map) {
					                                var self = this;
					                                self.set(\'inforWindow\', function (marker, val) {
					                                    var descriptions = val.descriptions;
					                                    var content = \'<div class="thumbnail">\';
					                                    if (val.images) {
					                                        content += \'<img  src="\' + val.images + \'">\';
					                                    }
					                                    content += \'<div class="caption">\';
					                                    if (val.title) {
					                                        content += \'<h4>\' + val.title + \'</h4>\';
					                                    }
					                                    if (descriptions) {
					                                        content += \'<p>\' + descriptions.replace(new RegExp(\'\n\', \'g\'), "<br/>") + \'</p>\';
					                                    }

					                                    if (val.link) {
					                                        content += \'<p><a target="_blank" href="\' + val.link + \'">more info</a></p>\';
					                                    }
					                                    content += \'</div></div>\';
					                                    self.openInfoWindow({ \'content\':content}, marker);
					                                });
					                                self.get(\'map\').setOptions({streetViewControl:false});
					                                if (gmapMarker) {
					                                    $.each(gmapMarker, function (i, val) {
					                                        var position = $.parseJSON(val.position);
					                                        if (position) {
					                                            if (!position.nb && position.lb) {
					                                                position.nb = position.lb;
					                                            }
					                                            if (!position.ob && position.mb) {
					                                                position.ob = position.mb;
					                                            }
					                                            self.addMarker({\'position\':position.nb + "," + position.ob, \'draggable\':false, \'bounds\':false},function (map, marker) {
					                                                if (val.open == "true") {
					                                                    self.get(\'inforWindow\')(marker, val);
					                                                }
					                                                if (val.title) {
					                                                    marker.setTitle(val.title);
					                                                }
					                                            }).xclick(function (event) {
					                                                    self.get(\'inforWindow\')(this, val);
					                                                })
					                                        }

					                                    });
					                                }

					                                setTimeout(function () {
					                                    self.get(\'map\').setCenter(self._latLng(gmapOptions.center.nb + \',\' + gmapOptions.center.ob));
					                                    self.get(\'map\').setZoom(gmapOptions.zoom);
					                                    self.get(\'map\').setMapTypeId(gmapOptions.mapTypeId);
					                                }, 1000);

					                            }});

					                        }
					                    });';
		/* Create filter get action check page submission detail */
		$actionCheckPage = apply_filters( 'wr_contactform_action_check_page_submission', $actionCheckPage );
		$createPrototypeSubmission[ 'checkPage' ] = 'checkPage:function () {

					            $("div.submission-page").each(function (i) {
					                if (!$(this).is(\':hidden\')) {
					                    if ($(this).next().attr("data-value")) {
					                        $(".jsn-page-actions .next-page").removeAttr("disabled");
					                    } else {
					                        $(".jsn-page-actions .next-page").attr("disabled", "disabled");
					                    }
					                    if ($(this).prev().attr("data-value")) {
					                        $(".jsn-page-actions .prev-page").removeAttr("disabled");
					                    } else {
					                        $(".jsn-page-actions .prev-page").attr("disabled", "disabled");
					                    }
					                    ' . implode( '', $actionCheckPage ) . '
					                }
					            });
					        }';
		$createPrototypeSubmission[ 'nextpaginationPage' ] = 'nextpaginationPage:function () {
					            var self = this;
					            $("div.submission-page").each(function () {
					                if (!$(this).is(\':hidden\')) {
					                    $(this).hide();
					                    $(this).next().show();
					                    self.checkPage();
					                    return false;
					                }
					            });
					        }';
		$createPrototypeSubmission[ 'prevpaginationPage' ] = 'prevpaginationPage:function () {
					            var self = this;
					            $("div.submission-page").each(function () {
					                if (!$(this).is(\':hidden\')) {
					                    $(this).hide();
					                    $(this).prev().show();
					                    self.checkPage();
					                    return false;
					                }
					            });
					        }';

		$createPrototypeSubmission = apply_filters( 'wr_contactform_js_form_add_prototype_form', $createPrototypeSubmission );
		$javascript = '(function ($) {
					    var JSNContactformSubmissionView = function (params) {
					        this.params = params;
					        this.nextAndPreviousForm = params.nextAndPreviousForm;
					        $("#poststuff #postbox-container-2 #normal-sortables").remove();
					        $("#menu-posts-wr_cf_post_type").removeClass("wp-not-current-submenu").addClass("wp-has-current-submenu");
					        $("#menu-posts-wr_cf_post_type > a").removeClass("wp-not-current-submenu").addClass("wp-has-current-submenu wp-menu-open");
					        $("#post-body-content .wr-editor-wrapper").remove();
					        $("#submitpost #preview-action").remove();
					        $("#edit-slug-box").remove();
					        $("#screen-meta-links").remove();
					        this.init();
					    }
					    JSNContactformSubmissionView.prototype = { ' . implode( ',', $createPrototypeSubmission ) . '}
					    var params = {};
					    ' . implode( '', $mainContent ) . '
					    new JSNContactformSubmissionView(params);
					})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
