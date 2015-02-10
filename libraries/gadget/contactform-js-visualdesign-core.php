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

class WR_CF_Gadget_Contactform_Js_Visualdesign_Core extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-visualdesign-core';

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
		$addParamsVisualDesign = array( 'newElement' => 'this.newElement = $(\'<a href="javascript:void(0);" class="jsn-add-more"><i class="icon-plus"></i>\' + lang[\'WR_CONTACTFORM_ADD_FIELD\'] + \'</a>\');' );
		/* Create Filter add params visual design */
		$addParamsVisualDesign = apply_filters( 'wr_contactform_visualdesign_add_params', $addParamsVisualDesign );
		$addBoxContent = array();
		$addBoxContent[ 'toolboxContent' ] = 'JSNVisualDesign.wrapper = $(\'<div class="jsn-element ui-state-default jsn-iconbar-trigger"><div class="jsn-element-content"></div><div class="jsn-element-overlay"></div><div class="jsn-iconbar"><a href="#" onclick="return false;" title="Edit element" class="element-edit"><i class="icon-pencil"></i></a><a href="#" onclick="return false;" title="Duplicate element" class="element-duplicate"><i class="icon-copy"></i></a><a href="#" title="Delete element" onclick="return false;" class="element-delete"><i class="icon-trash"></i></a></div></div>\');
				        JSNVisualDesign.toolbox = $(\'<div class="box jsn-bootstrap"></div>\');
				        JSNVisualDesign.toolboxContent = $(\'<div class="jsn-bootstrap wr-select-field-modal" />\');
				        JSNVisualDesign.toolboxContent.css(\'display\', \'block\');
				        JSNVisualDesign.toolboxContent.append($(\'<div/>\', { "class":"popover-content"  }).append( $("<form/>") ));
				        JSNVisualDesign.toolbox.append(JSNVisualDesign.toolboxContent);
				        JSNVisualDesign.toolbox.attr(\'id\', \'visualdesign-toolbox\');
				        JSNVisualDesign.optionsBox = $(\'<div class="box jsn-bootstrap" id="visualdesign-options"></div>\');
				        JSNVisualDesign.optionsBoxContent = $(\'<div class="popover bottom"></div>\');
				        JSNVisualDesign.optionsBoxContent.css(\'display\', \'block\');
				        JSNVisualDesign.optionsBoxContent.append($(\'<div class="arrow" />\'));
				        JSNVisualDesign.optionsBoxContent.append($(\'<h3 class="popover-title">Properties</h3>\'));
				        JSNVisualDesign.optionsBoxContent.append($(\'<div class="popover-content"><form><div class="tabs"><ul><li class="active"><a data-toggle="tab" href="#visualdesign-options-general">General</a></li><li><a data-toggle="tab" href="#visualdesign-options-values">Values</a></li><a class="btn quick-edit-style">Edit Style</a></ul><div id="visualdesign-options-general" class="tab-pane active"></div><div id="visualdesign-options-values" class="tab-pane"></div></div></form></div>\'));
				        JSNVisualDesign.optionsBox.append(JSNVisualDesign.optionsBoxContent);';
		/* Create filter render html add box content*/
		$addBoxContent = apply_filters( 'wr_contactform_visualdesign_add_box_content', $addBoxContent );

		/* Create Filter get action change option content */
		$actionChangeOptionsBoxContent = array();
		$actionChangeOptionsBoxContent[ 'check-email' ] = 'if (options.type == "email") {  checkChangeEmail = true; }';
		$actionChangeOptionsBoxContent[ 'check-date' ] = ' if (options.type == "date") { JSNVisualDesign.dateTime(); }';
		$actionChangeOptionsBoxContent = apply_filters( 'wr_contactform_visualdesign_action_change_option_box_content', $actionChangeOptionsBoxContent );

		/* Create Filter get action change option box content */
		$beforeActionChangeOptionBoxContent = array();
		$beforeActionChangeOptionBoxContent = apply_filters( 'wr_contactform_visualdesign_before_action_change_option_box_content', $beforeActionChangeOptionBoxContent );
		/* Create Filter get after action change option box content */
		$afterActionChangeOptionBoxContent = array();
		$afterActionChangeOptionBoxContent = apply_filters( 'wr_contactform_visualdesign_before_action_change_option_box_content', $afterActionChangeOptionBoxContent );
		/* Crate Filter get event box content submit*/
		$eventBoxContentSubmit = array();
		/* Set event default */
		$eventBoxContentSubmit[ 'default' ] = '$(this).trigger(\'change\'); e.preventDefault();';
		$eventBoxContentSubmit = apply_filters( 'wr_contactform_visualdesign_event_box_content_submit', $eventBoxContentSubmit );
		/* Create Filter get algorithm check mousedown box content */
		$ifCheckTargetMouseDownBoxContent = array();
		$ifCheckTargetMouseDownBoxContent[ 'default' ] = 'event.target != JSNVisualDesign.optionsBox.get(0) && !$.contains(JSNVisualDesign.optionsBox.get(0), event.target) && $(event.target).parent().attr("class") != "jsn-element ui-state-edit" && $(event.target).parent().attr("class") != "ui-state-edit" && !$(event.target).parents("#ui-datepicker-div").size() && $(event.target).attr("id") != "ui-datepicker-div" && $(event.target).attr("class") != "ui-widget-overlay" && !$(event.target).parents(".ui-dialog").size() && !$(event.target).parents(".wysiwyg-dialog-modal-div").size() && !$(event.target).parents(".control-list-action").size() && !$(event.target).parents(".ui-autocomplete").size() && !$(event.target).parents(".pac-container").size() && !$(event.target).parents(".dialog-google-maps").size() && $(event.target).attr("class") != "wr-lock-screen"';
		$ifCheckTargetMouseDownBoxContent = apply_filters( 'wr_contactform_visualdesign_if_check_target_mousedown_box_content', $ifCheckTargetMouseDownBoxContent );
		/* Create Filter get logic check mousedown box content */
		$logicIfCheckTargetMouseDownBoxContent = array();
		$logicIfCheckTargetMouseDownBoxContent[ 'default' ] = 'if ($(JSNVisualDesign.optionsBox.get(0)).find("#option-googleMaps-hidden").val() && $("#form-design .ui-state-edit").size()) {
				                        setTimeout(function () {
				                            JSNVisualDesign.contentGoogleMaps(true);
				                            $("#form-design .ui-state-edit").removeClass("ui-state-edit");
				                            JSNVisualDesign.closeOptionsBox();
				                        }, 200);
				                    } else {
				                        $("#form-design .ui-state-edit").removeClass("ui-state-edit");
				                        JSNVisualDesign.closeOptionsBox();
				                    }';
		$logicIfCheckTargetMouseDownBoxContent = apply_filters( 'wr_contactform_visualdesign_logic_if_check_target_mousedown_box_content', $logicIfCheckTargetMouseDownBoxContent );

		/* Create Filter get event mousedown box content*/
		$eventMouseDownBoxContent = array();
		$eventMouseDownBoxContent[ 'default' ] = ' if (($(event.target).hasClass("ui-widget-overlay")) || ($(event.target).hasClass("wysiwyg-dialog-modal-div"))) return false;
								if (event.target != JSNVisualDesign.toolbox.get(0) && !$.contains(JSNVisualDesign.toolbox.get(0), event.target)) {
				                    //JSNVisualDesign.closeToolbox();
				                }
				                if (' . implode( '', $ifCheckTargetMouseDownBoxContent ) . ') {
				                    ' . implode( '', $logicIfCheckTargetMouseDownBoxContent ) . '
				                }';
		$eventMouseDownBoxContent = apply_filters( 'wr_contactform_visualdesign_event_mousedown_box_content', $eventMouseDownBoxContent );
		/* Create Filter get algorithm check button add field */
		$ifCheckRenderButtonAddField = array( 'default' => 'identify != "form-actions" && identify != "form-captcha"' );
		$ifCheckRenderButtonAddField = apply_filters( 'wr_contactform_visualdesign_if_check_render_button_add_field', $ifCheckRenderButtonAddField );
		/* Create Filter get event click button add field */
		$eventClickButtonAddField = array();
		$eventClickButtonAddField[ 'dropdown' ] = 'if (this.name == "dropdown") {  $("#option-firstItemAsPlaceholder-checkbox").prop("checked", true); }';
		$eventClickButtonAddField[ 'date' ] = ' if (this.name == "date") { $("#option-dateFormat-checkbox").prop("checked", true); JSNVisualDesign.eventChangeDate();  }';
		$eventClickButtonAddField[ 'address' ] = 'if (this.name == "address") {   $("#wr-field-address .jsn-item input[type=checkbox]").each(function () {  $(this).prop("checked", true); });  JSNVisualDesign.eventChangeAddress(); }';
		$eventClickButtonAddField[ 'name' ] = 'if (this.name == "name") {  $("#wr-field-name .jsn-items-list input[type=checkbox]").each(function () {  $(this).prop("checked", true);  }); JSNVisualDesign.eventChangeName();  }';
		/* Get filter event click button add field*/
		$eventClickButtonAddField = apply_filters( 'wr_contactform_visualdesign_event_click_button_add_field', $eventClickButtonAddField );

		$createFunctionVisualDesign = array();
		$createFunctionVisualDesign[ 'filterResults' ] = 'JSNVisualDesign.filterResults = function (value, resultsFilter) {
				        $(resultsFilter).find("li").hide();
				        if (value != "") {
				            $(resultsFilter).find("li").each(function () {
				                var textField = $(this).attr("data-value").toLowerCase();
				                if (textField.search(value.toLowerCase()) == -1) {
				                    $(this).hide();
				                } else {
				                    $(this).fadeIn(800);
				                }
				            });
				        } else {
				            $(resultsFilter).find("li").each(function () {
				                $(this).fadeIn(800);
				            });
				        }
				    };';
		$filterAddButtonField = array();
		$filterAddButtonField[ 'all' ] = ' if(buttons.standard.length>0 || buttons.extra.length>0){
					            $(listFilter).append(
				                $("<option/>", {
				                    "value":"all",
				                    "text":"All Fields"
				                })
				            );
				            }';
		$filterAddButtonField[ 'standard' ] = ' if(buttons.standard.length>0){
					            $(listFilter).append(
					                $("<option/>", {
					                    "value":"standard",
					                    "text":"Standard Fields"
					                })
					            )
				            }';
		$filterAddButtonField[ 'extra' ] = 'if(buttons.extra.length>0){
					              $(listFilter).append($("<option/>", {
					                "value":"extra",
					                "text":"PRO Fields"
					                 })
					              )
				            }';
		$getFilterAddButtonField = apply_filters( 'wr_contactform_add_select_button_field', $filterAddButtonField );
		if ( ! empty( $getFilterAddButtonField ) ) {
			$filterAddButtonField = $getFilterAddButtonField;
		}
		$filterButtonField = array();
		$filterButtonField[ 'standard' ] = 'case \'standard\':
				                      $(resultsFilter).empty();
                                      var buttons = JSNVisualDesign.drawToolboxButtons();
				                      if(buttons.standard.length>0){
											 $.each(buttons.standard, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}
				                        break;';
		$filterButtonField[ 'all' ] = 'case \'all\':
				                        $(resultsFilter).empty();
									   var buttons = JSNVisualDesign.drawToolboxButtons();
				                       if(buttons.standard.length>0){
											 $.each(buttons.standard, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}

				                        if(buttons.extra.length>0){
											 $.each(buttons.extra, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}

				                        break;';
		$filterButtonField[ 'extra' ] = ' case \'extra\':
				                        $(resultsFilter).empty();
				                        var buttons = JSNVisualDesign.drawToolboxButtons();
										if(buttons.extra.length>0){
											 $.each(buttons.extra, function (i, val) {
				                                 $(resultsFilter).append(val)
				                            });
										}
				                        break;';
		$getFilterButtonField = apply_filters( 'wr_contactform_button_field', $filterButtonField );
		if ( ! empty( $getFilterButtonField ) ) {
			$filterButtonField = $getFilterButtonField;
		}
		$createFunctionVisualDesign[ 'openToolbox' ] = 'JSNVisualDesign.openToolbox = function (sender, target) {
				        if (JSNVisualDesign.toolbox.find(\'button.btn\').size() == 0) {
				        var buttons = JSNVisualDesign.drawToolboxButtons();
				            var resultsFilter = $("<ul/>", {
				                "class":"jsn-items-list"
				            });
				            var oldIconFilter = "";
				            var listFilter = $("<select/>", {
				                "class":"wr-filter-button input-large"
				            })
				           ' . implode( ' ', $filterAddButtonField ) . '

				            $(listFilter).change(function () {
				                JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").val("");
				                JSNVisualDesign.toolbox.find(".jsn-reset-search").hide();
				                switch ($(this).val()) { ' . implode( ' ', $filterButtonField ) . '}
				            });
				            $.fn.delayKeyup = function (callback, ms) {
				                var timer = 0;
				                var el = $(this);
				                $(this).keyup(function () {
				                    clearTimeout(timer);
				                    timer = setTimeout(function () {
				                        callback(el)
				                    }, ms);
				                });
				                return $(this);
				            };
				            JSNVisualDesign.toolbox.find("form").find(".jsn-elementselector").remove();
				            JSNVisualDesign.toolbox.find("form").append(
				                $("<div/>", {
				                    "class":"jsn-elementselector"
				                }).append(
				                    $("<div/>", {
				                        "class":"jsn-fieldset-filter"
				                    }).append(
				                        $("<fieldset/>").append(
				                            $("<div/>", {
				                                "class":"pull-left"
				                            }).append(listFilter)
				                        ).append(
				                            $("<div/>", {
				                                "class":"pull-right"
				                            }).append(
				                                $("<input/>", {
				                                    "class":"input search-query",
				                                    "type":"text",
				                                    "id":"jsn-quicksearch-field",
				                                    "placeholder":"Search…"
				                                }).delayKeyup(function (el) {
				                                        if ($(el).val() != oldIconFilter) {
				                                            oldIconFilter = $(el).val();
				                                            JSNVisualDesign.filterResults($(el).val(), resultsFilter);
				                                        }
				                                        if ($(el).val() == "") {
				                                            JSNVisualDesign.toolbox.find(".jsn-reset-search").hide();
				                                        } else {
				                                            JSNVisualDesign.toolbox.find(".jsn-reset-search").show();
				                                        }
				                                    }, 500)
				                            ).append(
				                                $("<a/>", {"href":"javascript:void(0);", "title":"Clear Search", "class":"jsn-reset-search"}).append($("<i/>", {"class":"icon-remove"})).click(function () {
				                                    JSNVisualDesign.toolbox.find("#jsn-quicksearch-field").val("");
				                                    oldIconFilter = "";
				                                    JSNVisualDesign.filterResults("", resultsFilter);
				                                    $(this).hide();
				                                })
				                            )
				                        )
				                    )
				                ).append(resultsFilter).append(resultsFilter)
				            );
				            JSNVisualDesign.toolbox.find("select.wr-filter-button").trigger("change");
				            JSNVisualDesign.toolbox.find("select.wr-filter-button").select2({
			                    minimumResultsForSearch:99
			                });
				            JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").attr("placeholder", "Search…");
				            $(\'input, textarea\').placeholder();

				        } else {
				            JSNVisualDesign.toolbox.find("input#jsn-quicksearch-field").val("");
				            JSNVisualDesign.toolbox.find("select.wr-filter-button").trigger("change");
				        }

				        JSNVisualDesign.closeOptionsBox();
				        JSNVisualDesign.toolbox.hide().appendTo($(\'body\'));
						var toolboxModalHeight = 562;
						var toolboxModalWidth = 1008;
						tb_show("Select Field", "#TB_inline?width=" + toolboxModalWidth + "&height=" + toolboxModalHeight + "&inlineId=visualdesign-toolbox");
						$("#TB_ajaxContent .jsn-elementselector .jsn-items-list").height(toolboxModalHeight - 90);
						$(window).on("resize", function() {
							//toolboxModalWidth = $(window).width() * 0.6;
							//toolboxModalHeight = $(window).height() * 0.6;
							$("#TB_window").width(toolboxModalWidth + 30);
							$("#TB_ajaxContent").width(toolboxModalWidth).height(toolboxModalHeight - 5);
							$("#TB_ajaxContent .jsn-elementselector .jsn-items-list").height(toolboxModalHeight - 90);
						});
				        JSNVisualDesign.toolboxTarget = target;
				    };';
		$createFunctionVisualDesign[ 'savePage' ] = '  JSNVisualDesign.savePage = function (action) {
				        var container = $("#wr_contactform_master #form-container");
				        var listOptionPage = [];
				        var listContainer = [];
				        var instance = container.data(\'visualdesign-instance\');
				        var content = "";
				        var serialize = instance.serialize(true);
				        if (serialize != "" && serialize != "[]") {
				            content = $.toJSON(serialize);
				        }
				        $(" ul.jsn-page-list li.page-items").each(function () {
				            listOptionPage.push([$(this).find("input").attr(\'data-id\'), $(this).find("input").attr(\'value\')]);
				        });
				        $("#form-container .jsn-row-container").each(function () {
				            var listColumn = [];
				            $(this).find(".jsn-column-content").each(function () {
				                var dataContainer = {};
				                var columnName = $(this).attr("data-column-name");
				                var columnClass = $(this).attr("data-column-class");
				                dataContainer.columnName = columnName;
				                dataContainer.columnClass = columnClass;
				                listColumn.push(dataContainer);
				            });
				            listContainer.push(listColumn);
				        });
				        $.ajax({
				            type:"POST",
				            dataType:\'json\',
				            url:"admin-ajax.php?action=wr_contactform_save_page",
				            data:{
				                form_id:$("#jform_form_id").val(),
				                form_content:content,
				                form_page_name:$("#form-design-header").attr(\'data-value\'),
				                form_list_page:listOptionPage,
				                form_list_container:$.toJSON(listContainer)
				            },
				            success:function () {
				                JSNVisualDesign.emailNotification();

				                if (action == \'delete\') {
				                    $("#form-design-header .jsn-iconbar").css("display", "");
				                    $(".jsn-page-actions").css("display", "");
				                }
				            }
				        });
				    };';
		$createFunctionVisualDesign[ 'emailNotification' ] = 'JSNVisualDesign.emailNotification = function () {
				        var container = $("#wr_contactform_master #form-container");
				        var instance = container.data(\'visualdesign-instance\');
				        var formContent = instance.serialize(true);
				        var content = "";
				        if (formContent != "" && formContent != "[]") {
				            content = $.toJSON(formContent);
				        }
				        var check = 0;
				        var listOptionPage = [];
				        $(" ul.jsn-page-list li.page-items").each(function () {
				            listOptionPage.push([$(this).find("input").attr(\'data-id\'), $(this).find("input").attr(\'value\')]);
				        });
				        $.ajax({
				            type:"POST",
				            dataType:\'json\',
				            url:"admin-ajax.php?action=wr_contactform_load_session_field",
				            data:{
				                form_id:$("#jform_form_id").val(),
				                form_page_name:$("#form-design-header").attr(\'data-value\'),
				                form_content:content,
				                form_list_page:listOptionPage
				            },
				            success:function (response) {
				                $("#email .email-submitters .jsn-items-list").html("");
				                if (response) {
				                    if ($("#wr-form-field-list_email_send_to_submitter").val()) {
				                        dataEmailSubmitter = $.evalJSON($("#wr-form-field-list_email_send_to_submitter").val());
				                    }
				                    $.each(response, function (i, item) {
				                        if (item.type == \'email\') {
				                            check++;
				                            if ($.inArray(item.identify, dataEmailSubmitter) != -1) {
				                                $("#email .email-submitters .jsn-items-list").append(
				                                    $("<li/>", {
				                                        "class":"jsn-item ui-state-default"
				                                    }).append(
				                                        $("<label/>", {
				                                            "class":"checkbox",
				                                            text:item.options.label
				                                        }).append(
				                                            $("<input/>", {
				                                                "type":"checkbox",
				                                                "name":"wr_contactform[list_email_send_to_submitter][]",
				                                                "checked":"checked",
				                                                "class":"wr-check-submitter",
				                                                "value":item.identify
				                                            }))))
				                            } else {
				                                $("#email .email-submitters .jsn-items-list").append(
				                                    $("<li/>", {
				                                        "class":"jsn-item ui-state-default"
				                                    }).append(
				                                        $("<label/>", {
				                                            "class":"checkbox",
				                                            text:item.options.label
				                                        }).append(
				                                            $("<input/>", {
				                                                "type":"checkbox",
				                                                "name":"wr_contactform[list_email_send_to_submitter][]",
				                                                "class":"wr-check-submitter",
				                                                "value":item.identify
				                                            }))))
				                            }
				                        }
				                    });
				                }
				                if (check == 0 || !check) {
				                    $("#email .email-submitters .jsn-items-list").append(
				                        $("<div/>", {
				                            "class":"ui-state-default ui-state-disabled",
				                            "text":lang["No email field found"],
				                            "title":lang["You must add some email-type field in your form in order to select it here"]
				                        }))
				                }
				                $("#email .email-submitters .jsn-items-list").parent().parent().show();
				            }
				        });
				    };';
		$createFunctionVisualDesign[ 'checkLimitation' ] = '  JSNVisualDesign.checkLimitation = function () {
				        if ($("#visualdesign-options-values #option-limitation-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #option-limitMin-number").removeAttr("disabled");
				            $("#visualdesign-options-values #option-limitMax-number").removeAttr("disabled");
				            $("#visualdesign-options-values #option-limitType-select").removeAttr("disabled");
				        } else {
				            $("#visualdesign-options-values #option-limitMin-number").attr("disabled", "disabled");
				            $("#visualdesign-options-values #option-limitMax-number").attr("disabled", "disabled");
				            $("#visualdesign-options-values #option-limitType-select").attr("disabled", "disabled");
				        }
				    };';

		$createFunctionVisualDesign[ 'eventChangeallowOther' ] = ' JSNVisualDesign.eventChangeallowOther = function () {
				        if ($("#option-allowOther-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values .wr-allow-other #option-labelOthers-_text").show();
				        } else {
				            $("#visualdesign-options-values .wr-allow-other #option-labelOthers-_text").hide();
				        }
				    };';

		$createFunctionVisualDesign[ 'eventChangeConfirm' ] = 'JSNVisualDesign.eventChangeConfirm = function () {
				        if ($("#option-requiredConfirm-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #option-valueConfirm-text").show();
				        } else {
				            $("#visualdesign-options-values #option-valueConfirm-text").hide();
				        }
				    };';
		$actionFunctionCreateElement = array();
		$actionFunctionCreateElement[ 'duplicate' ] = 'wrapper.find(".element-duplicate").click(function () {
				                var newOtions = {};
				                var d = new Date();
								var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
								var getLabel = opts.label + "_" + Math.floor(Math.random() * 999999999) + time;
						        var label = getLabel.toLowerCase();
						        while (/[^a-zA-Z0-9_]+/.test(label)) {
						            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
						        }
				                newOtions = opts;
				                newOtions.identify = label;
				                var element = JSNVisualDesign.createElement(type, newOtions);
				                $(wrapper).after(element);
				                JSNVisualDesign.savePage();
				                JSNVisualDesign.contentGoogleMaps();
				            });';
		$actionFunctionCreateElement[ 'delete' ] = 'wrapper.find(\'.element-delete\').click(function () {
								if (confirm(lang["Are you sure you want to delete this field?"])) {
									$("#form-design-header .jsn-iconbar").css("display", "none");
					                $(".jsn-page-actions").css("display", "none");
					                if (id) {
					                    wrapper.remove();
					                    JSNVisualDesign.savePage(\'delete\');
					                } else {
					                    wrapper.remove();
					                    JSNVisualDesign.savePage(\'delete\');
					                }
								}
				            });';
		$actionFunctionCreateElement[ 'edit' ] = '  wrapper.find("a.element-edit").click(function (event) {
				                $("#form-design .ui-state-edit").removeClass("ui-state-edit");
				                wrapper.addClass("ui-state-edit");
				                JSNVisualDesign.openOptionsBox(wrapper, type, wrapper.data(\'visualdesign-element-data\').options, $(this));
				            });';
		$actionFunctionCreateElement[ 'address' ] = 'if (type == "address") {
				                if (!data.sortableField) {
				                    data.sortableField = \'["vstreetAddress", "vstreetAddress2", "vcity", "vstate", "vcode", "vcountry"]\';
				                }
				                if (data.sortableField) {
				                    control.tmpl = JSNVisualDesign.getTmplFieldAddress(data);
				                }
				            }';
		$actionFunctionCreateElement[ 'name' ] = 'if (type == "name") {
				                if (!data.sortableField) {
				                    data.sortableField = \'["vtitle", "vfirst", "vmiddle", "vlast"]\';
				                }
				                if (data.sortableField) {
				                    control.tmpl = JSNVisualDesign.getTmplFieldName(data);
				                }
				            }';
		/* Create filter get action on function create element */
		$actionFunctionCreateElement = apply_filters( 'wr_contactform_visualdesign_action_function_create_element', $actionFunctionCreateElement );
		$createFunctionVisualDesign[ 'createElement' ] = '
				    JSNVisualDesign.createElement = function (type, opts, id) {
				        var control = JSNVisualDesign.controls[type];
				        if (control) {
				            var data = (opts === undefined) ? control.defaults : $.extend({}, control.defaults, opts);
				            var wrapper = JSNVisualDesign.wrapper.clone();
				            wrapper.data(\'visualdesign-element-data\', {
				                id:id,
				                type:type,
				                options:data
				            });
				            ' . implode( '', $actionFunctionCreateElement ) . '
				            wrapper.find(\'.jsn-element-content\').append($.tmpl(control.tmpl, data));
				            return wrapper;
				        }
				    };';

		$actionOpenOptionsBox = array();
		$actionOpenOptionsBox[ 'eventChangeConfirm' ] = 'JSNVisualDesign.eventChangeConfirm(); $("#option-requiredConfirm-checkbox").change(function () { JSNVisualDesign.eventChangeConfirm();});';
		$actionOpenOptionsBox[ 'actions' ] = ' if (type == "form-actions") {
				            var pageItems = $("ul.jsn-page-list li.page-items");
				            if (pageItems.size() <= 1) {
				                $("#option-btnNext-text").parents(".control-group").remove();
				                $("#option-btnPrev-text").parents(".control-group").remove();
				            }
				        }';
		$actionOpenOptionsBox[ 'eventChangeallowOther' ] = '   JSNVisualDesign.eventChangeallowOther();
				        $("#option-allowOther-checkbox").change(function () {
				            JSNVisualDesign.eventChangeallowOther();
				        });';
		$actionOpenOptionsBox[ 'wysiwyg' ] = 'if ($("#visualdesign-options-general #option-value-textarea").size()) {
				            $("#visualdesign-options-general #option-value-textarea").wysiwyg({
				                controls:{
				                    bold:{ visible:true },
				                    italic:{ visible:true },
				                    underline:{ visible:true },
				                    strikeThrough:{ visible:true },
				                    justifyLeft:{ visible:true },
				                    justifyCenter:{ visible:true },
				                    justifyRight:{ visible:true },
				                    justifyFull:{ visible:true },
				                    indent:{ visible:true },
				                    outdent:{ visible:true },
				                    subscript:{ visible:true },
				                    superscript:{ visible:true },
				                    undo:{ visible:true },
				                    redo:{ visible:true },
				                    insertOrderedList:{ visible:true },
				                    insertUnorderedList:{ visible:true },
				                    insertHorizontalRule:{ visible:true },
				                    h1:{ visible:false },
				                    h2:{ visible:false },
				                    h3:{ visible:false },
				                    h4:{
				                        visible:false,
				                        className:\'h4\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h4>\' : \'h4\',
				                        tags:[\'h4\'],
				                        tooltip:\'Header 4\'
				                    },
				                    h5:{
				                        visible:false,
				                        className:\'h5\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h5>\' : \'h5\',
				                        tags:[\'h5\'],
				                        tooltip:\'Header 5\'
				                    },
				                    h6:{
				                        visible:false,
				                        className:\'h6\',
				                        command:($.browser.msie || $.browser.safari) ? \'formatBlock\' : \'heading\',
				                        arguments:($.browser.msie || $.browser.safari) ? \'<h6>\' : \'h6\',
				                        tags:[\'h6\'],
				                        tooltip:\'Header 6\'
				                    },
				                    html:{ visible:true },
				                    increaseFontSize:{ visible:true },
				                    decreaseFontSize:{ visible:true }
				                },
				                html:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body style="margin:0; padding:10px;">INITIAL_CONTENT</body></html>\'
				            });
				        }';
		$actionOpenOptionsBox[ 'checkLimitation' ] = 'JSNVisualDesign.checkLimitation();';
		$actionOpenOptionsBox[ 'itemAction' ] = 'if (JSNVisualDesign.controls[type].params.values) {
				            if (JSNVisualDesign.controls[type].params.values.itemAction) {
				                var itemAction = $("#visualdesign-options-values #option-itemAction-hidden").val();
				                if (itemAction) {
				                    itemAction = $.evalJSON(itemAction);
				                }
				                if (itemAction) {
				                    $("#visualdesign-options-values .jsn-items-list .jsn-item input[name=item-list]").each(function () {
				                        var inputItem = $(this);
				                        $.each(itemAction, function (i, item) {
				                            if (i == $(inputItem).val()) {
				                                $(inputItem).attr("action-show-field", $.toJSON(item.showField));
				                                $(inputItem).attr("action-hide-field", $.toJSON(item.hideField));
				                                if ($(item.showField).length > 0 || $(item.hideField).length > 0) {
				                                    var jsnItem = $(inputItem).parents(".jsn-item");
				                                    $(jsnItem).addClass("jsn-highlight");
				                                } else {
				                                    var jsnItem = $(inputItem).parents(".jsn-item");
				                                    $(jsnItem).removeClass("jsn-highlight");
				                                }
				                            }
				                        })
				                    });
				                }
				            }
				        }';

		$createFunctionVisualDesign[ 'renderOptionsBox' ] = 'JSNVisualDesign.renderOptionsBox = function (options, data) {
				        if (options.general === undefined) {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().hide();
				        } else {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().show();
				        }
				        if (options.values === undefined) {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-values"]\').parent().hide();
				        } else {
				            JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-values"]\').parent().show();
				        }
				        if (options.quickeditstyle === undefined) {
				            JSNVisualDesign.optionsBoxContent.find(\'.quick-edit-style\').hide();
				        } else {
				            JSNVisualDesign.optionsBoxContent.find(\'.quick-edit-style\').off(\'click\');
				            JSNVisualDesign.optionsBoxContent.find(\'.quick-edit-style\').on(\'click\', function() {
				                JSNVisualDesign.closeOptionsBox();
				                $(\'#select_form_style\').click();
				                $(\'#container-select-style a[href="#formStyle\' + options.quickeditstyle.tab + \'"]\').click();
				                $(window).scrollTop($(\'#select_form_style\').offset().top - 40);
				            });
				            JSNVisualDesign.optionsBoxContent.find(\'.quick-edit-style\').show();
				        }
				        JSNVisualDesign.optionsBoxContent.find(\'div[id^="visualdesign-options-"]\').removeClass(\'active\').empty();
				        JSNVisualDesign.optionsBoxContent.find(\'div#visualdesign-options-general\').addClass(\'active\');
				        JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-"]\').parent().removeClass(\'active\');
				        JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-general"]\').parent().addClass(\'active\');
				        $.map(options, function (params, tabName) {
				            var tabPane = JSNVisualDesign.optionsBoxContent.find(\'#visualdesign-options-\' + tabName);
				            $.map(params, function (elementOptions, name) {
				                // Render for group option
				                if (elementOptions.type == \'group\') {
				                    var group = null;
				                    group = $(\'<div/>\').append($(elementOptions.decorator));
				                    group.addClass(\'group \' + name);
				                    $.map(elementOptions.elements, function (itemOptions, itemName) {
				                        itemOptions.name = itemName;
				                        group.find(itemName.toLowerCase()).replaceWith(JSNVisualDesign.createControl(itemOptions, data[itemName], data.identify));
				                    });
				                    tabPane.append(group);
				                    return false;
				                }
				                if (elementOptions.type == \'horizontal\') {
				                    var group = null;
				                    group = $(\'<div/>\', {
				                        "class":"control-group"
				                    }).append($("<label/>", {
				                        "class":"control-label"
				                    }).append(elementOptions.title)).append($("<div/>", {
				                        "class":"controls"
				                    }).append($(elementOptions.decorator)));
				                    $.map(elementOptions.elements, function (itemOptions, itemName) {
				                        itemOptions.name = itemName;
				                        group.find(itemName.toLowerCase()).replaceWith(JSNVisualDesign.createControl(itemOptions, data[itemName], data.identify));
				                    });
				                    tabPane.append(group);
				                    return false;
				                }
				                elementOptions.name = name;
				                if (elementOptions.name == \'group\') {
				                    var groupControl = $(\'<div/>\', {
				                        \'class\':\'controls\'
				                    });
				                    $.each(elementOptions, function (index, value) {
				                        if (index != "name") {
				                            value.name = index;
				                            value.classLabel = false;
				                            groupControl.append(JSNVisualDesign.createControl(value, data[index], data.identify));
				                        }
				                    });
				                    tabPane.append($(\'<div/>\', {
				                        \'class\':\'control-group visualdesign-options-group\'
				                    }).append(groupControl));
				                } else {
				                    tabPane.append(JSNVisualDesign.createControl(elementOptions, data[name], data.identify))
				                }
				                JSNVisualDesign.optionsBoxContent.find(\'a[href^="#visualdesign-options-\' + tabName + \'"]\').parent().show();
				            });
				        });
				        JSNVisualDesign.optionsBoxContent.find(\'input[type="text"], textarea\')
				            .bind(\'keyup\', function () {
				                $(this).closest(\'form\').trigger(\'change\');
				            });
				    };';

		$createFunctionVisualDesign[ 'closeOptionsBox' ] = ' JSNVisualDesign.closeOptionsBox = function () {
				        if (checkChangeEmail) {
				            JSNVisualDesign.savePage();
				        }
				        checkChangeEmail = false;
				        JSNVisualDesign.optionsBox.hide();
				    };';

		$actionTypeCheckBoxCreateControl = array();
		$actionTypeCheckBoxCreateControl[ 'default' ] = ' if (options.field == "address" || options.field == "name") {
				                element.find(\'label\').append(control).addClass(\'checkbox\').removeClass("control-label");
				                var contentLabel = element.find(\'label\').remove();
				                element.append($("<li/>", {
				                    "class":"jsn-item ui-state-default"
				                }).append(contentLabel));
				                element.find(".control-group").remove();
				            } else if (options.field == "allowOther") {
				                element.find(\'label\').append(control).addClass(\'checkbox\').removeClass("control-label");
				                var contentLabel = element.find(\'label\').remove();
				                element.find(".control-group").parent().append(contentLabel);
				                element.find(".control-group").remove();
				            } else {
				                element.find(\'label\').append(control).addClass(\'checkbox\').removeClass("control-label");
				                var contentLabel = element.find(\'label\').remove();
				                element.find(".control-group").append($("<div/>", {
				                    "class":"controls"
				                }).append(contentLabel));
				            }';
		/* Create Filter get action if type check on create control */
		$actionTypeCheckBoxCreateControl = apply_filters( 'wr_contactform_visualdesign_action_type_checkbox_create_control', $actionTypeCheckBoxCreateControl );
		$createFunctionVisualDesign[ 'createControl' ] = 'JSNVisualDesign.createControl = function (options, value, identify) {
				        var templates = {
				            \'hidden\':\'<input type="hidden" value="${value}" name="${options.name}" id="${id}" />\',
				            \'text\':\'<div class="controls"><input type="text" value="${value}" name="${options.name}" id="${id}" class="text jsn-input-xxlarge-fluid" /></div>\',
				            \'_text\':\'<input type="text" value="${value}" name="${options.name}" id="${id}" class="text jsn-input-xxlarge-fluid" />\',
				            \'number\':\'<div class="controls"><input type="number" value="${value}" name="${options.name}" id="${id}" class="number input-mini" /></div>\',
				            \'select\':\'<div class="controls"><select name="${options.name}" id="${id}" class="select">{{each(i, val) options.options}}<option value="${i}" {{if val==value || (typeof(i) == "string" && i==value)}}selected{{/if}}>${val}</option>{{/each}}</select></div>\',
				            \'checkbox\':\'<input type="checkbox" value="1" name="${options.name}" id="${id}" {{if value==1 || value == "1"}}checked{{/if}} />\',
				            \'checkboxes\':\'<div class="controls">{{each(i, val) options.options}}<label for="${id}-${i}" class="{{if options.class == ""}}checkbox{{else}}${options.class}{{/if}}"><input type="checkbox" name="${options.name}[]" value="${val}" id="${id}-${i}" {{if value.indexOf(val)!=-1}}checked{{/if}} />${val}</label>{{/each}}</div>\',
				            \'radio\':\'<div class="controls">{{each(i, val) options.options}}<label for="${id}-${i}" class="{{if options.class == ""}}radio{{else}}${options.class}{{/if}}"><input type="radio" name="${options.name}" value="${i}" id="${id}-${i}" {{if value==val}}checked{{/if}} />${val}</label>{{/each}}</div>\',
				            \'textarea\':\'<div class="controls"><textarea name="${options.name}" id="${id}" rows="3" class="textarea jsn-input-xxlarge-fluid">${value}</textarea></div>\'
				        };
				        var elementId = \'option-\' + options.name + \'-\' + options.type;
				        var control = null;
				        var element = $(\'<div/>\');
				        var setAttributes = function (element, attrs) {
				            var elm = $(element),
				                field = elm.is(\':input\') ? elm : elm.find(\':input\');
				            field.attr(attrs);
				        };
				        if (templates[options.type] !== undefined) {
				            control = $.tmpl(templates[options.type], {
				                options:options,
				                value:value,
				                id:elementId
				            });
				            if ($.isPlainObject(options.attrs))
				                setAttributes(control, options.attrs);
				        } else if (options.type == \'itemlist\') {
				            control = $.itemList($.extend({}, {
				                listItems:value,
				                id:elementId,
				                identify:identify,
				                language:lang
				            }, options));
				        } else
				            return;
				        if (options.label !== undefined && options.classLabel == undefined) {
				            element.append($("<div/>", {
				                "class":"control-group"
				            }).append($(\'<label/>\', {
				                \'for\':elementId,
				                text:options.label,
				                \'class\':\'control-label\',
				                title:lang[options.title]
				            })));
				        } else if (!options.classLabel && options.group != "horizontal") {
				            element.append($("<div/>", {
				                "class":"control-group "
				            }).append($(\'<label/>\', {
				                \'for\':elementId,
				                text:options.label,
				                title:lang[options.title]
				            })));
				        }
				        if (options.type == \'checkbox\') {
							' . implode( '', $actionTypeCheckBoxCreateControl ) . '
				        } else {
				            if (options.type == "itemlist") {
				                element.find(".control-group").append(control).addClass("jsn-items-list-container");
				            } else if (options.group == "horizontal") {
				                if (options.field && (options.field == "horizontal" || options.field == "currency" || options.field == "input-inline")) {
				                    $(control).attr("class", "wr-inline");
				                    element.append(control);
				                } else if (options.field && (options.field == "horizontal" || options.field == "number")) {
				                    $(control).attr("class", "wr-inline");
				                    element.append(control);
				                } else {
				                    $(control).attr("class", "input-append wr-inline");
				                    element.append(control);
				                }
				            } else if (options.field == "allowOther") {
				                element.append(control);
				                element.find(".control-group").remove();
				            } else {
				                element.find(".control-group").append(control);
				            }
				        }

				        return element.children();
				    };';
		$actionOpenOptionsBox[ 'date' ] = 'if (type == "date") {
				            JSNVisualDesign.eventChangeDate();
				            $("#option-enableRageSelection-checkbox").change(function () {
				                JSNVisualDesign.eventChangeDate();
				            });
				            $("#option-dateFormat-checkbox").change(function () {
				                if (!$("#option-timeFormat-checkbox").is(\':checked\') && !$("#option-dateFormat-checkbox").is(\':checked\')) {
				                    $(this).prop("checked", true);
				                } else {
				                    JSNVisualDesign.eventChangeDate();
				                }
				            });
				            $("#option-timeFormat-checkbox").change(function () {
				                if (!$("#option-timeFormat-checkbox").is(\':checked\') && !$("#option-dateFormat-checkbox").is(\':checked\')) {
				                    $(this).prop("checked", true);
				                } else {
				                    JSNVisualDesign.eventChangeDate();
				                }
				            });
				            $("#option-yearRangeMax-text,#option-yearRangeMin-text,#option-timeOptionFormat-select").change(function () {
				                JSNVisualDesign.eventChangeDate();
				            });
				            var valueDateFormat = $("#option-dateOptionFormat-select").val();
				            $("#option-dateOptionFormat-select").change(function () {
				                if ($(this).val() != "custom") {
				                    valueDateFormat = $("#option-dateOptionFormat-select").val();
				                    JSNVisualDesign.eventChangeDate();
				                } else {
				                    $("#wr-custom-date-field").val(valueDateFormat);
				                    JSNVisualDesign.eventChangeDate();
				                }
				            });
				            $("#option-yearRangeMin-text,#option-yearRangeMax-text").keypress(function (e) {
				                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				                    return false;
				                }
				            });
				        }';
		$actionOpenOptionsBox[ 'phone' ] = 'if (type == "phone") {
				            JSNVisualDesign.eventChangePhone();
				            $("#option-format-select").change(function () {
				                JSNVisualDesign.eventChangePhone();
				            });
				        }';
		$actionOpenOptionsBox[ 'password' ] = 'if (type == "password") {
				            JSNVisualDesign.eventChangeConfirmPassWord();
				            $("#option-confirmation-checkbox").change(function () {
				                JSNVisualDesign.eventChangeConfirmPassWord();
				            });
				        }';
		$actionOpenOptionsBox[ 'file-upload' ] = 'if (type == "file-upload") {
				            $("#visualdesign-options #visualdesign-options-general #limit-size-upload").attr("original-title", lang["Even if you do not set limitation here, there will still be a limitation set by server which is: "] + limitSize + " MB");
				        }';
		$actionOpenOptionsBox[ 'check-field-number' ] = '$("#option-limitMin-number,#option-limitMax-number,#option-rows-number,#option-maxSize-number,#option-width-number,#option-height-number").keypress(function (e) {
				            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				                return false;
				            }
				        });';
		$actionOpenOptionsBox[ 'currency' ] = 'if (type == "currency") {
				            JSNVisualDesign.eventChangeCurrency();
				            $("#option-format-select").change(function () {
				                JSNVisualDesign.eventChangeCurrency();
				            });
				        }';
		$actionOpenOptionsBox[ 'number' ] = 'if (type == "number") {
				            JSNVisualDesign.eventChangeNumber();
				            $("#option-showDecimal-checkbox").change(function () {
				                JSNVisualDesign.eventChangeNumber();
				            });
				        }';
		$actionOpenOptionsBox[ 'address' ] = 'if (type == "address") {
				            JSNVisualDesign.eventChangeAddress();
				            $("#option-vcountry-checkbox").change(function () {
				                JSNVisualDesign.eventChangeAddress();
				            });
				            $("#visualdesign-options-values #wr-field-address .jsn-items-list").sortable({
				                forceHelperSize:true, axis:\'y\',
				                update:function () {
				                    var positionField = [];
				                    $("#visualdesign-options-values #wr-field-address .jsn-items-list li.jsn-item").each(function () {
				                        positionField.push($(this).find("input[type=checkbox]").attr("name"));
				                    });
				                    $("#visualdesign-options-values #wr-field-address input#option-sortableField-hidden").val($.toJSON(positionField)).change();
				                }
				            });
				            var sortableField = $("#visualdesign-options-values #wr-field-address input#option-sortableField-hidden").val();
				            if (sortableField) {
				                sortableField = $.evalJSON(sortableField);
				                if (sortableField) {
				                    var listFields = $("#visualdesign-options-values #wr-field-address .jsn-items-list .jsn-item");
				                    listFields.detach();
				                    $.each(sortableField, function (i, val) {
				                        $("#visualdesign-options-values #wr-field-address .jsn-items-list").append(
				                            $(listFields).find("input[name=" + val + "]").parents(".jsn-item")
				                        )
				                    });
				                }
				            }
				        }';
		$actionOpenOptionsBox[ 'name' ] = 'if (type == "name") {
				            JSNVisualDesign.eventChangeName();
				            $("#option-vtitle-checkbox").change(function () {
				                JSNVisualDesign.eventChangeName();
				            });
				            $("#visualdesign-options-values #wr-field-name .jsn-items-list").sortable({
				                forceHelperSize:true, axis:\'y\',
				                update:function () {
				                    var positionField = [];
				                    $("#visualdesign-options-values #wr-field-name .jsn-items-list li.jsn-item").each(function () {
				                        positionField.push($(this).find("input[type=checkbox]").attr("name"));
				                    });
				                    $("#visualdesign-options-values #wr-field-name input#option-sortableField-hidden").val($.toJSON(positionField)).change();
				                }
				            });
				            var sortableField = $("#visualdesign-options-values #wr-field-name input#option-sortableField-hidden").val();
				            if (sortableField) {
				                sortableField = $.evalJSON(sortableField);
				                if (sortableField) {
				                    var listFields = $("#visualdesign-options-values #wr-field-name .jsn-items-list .jsn-item");
				                    listFields.detach();
				                    $.each(sortableField, function (i, val) {
				                        $("#visualdesign-options-values #wr-field-name .jsn-items-list").append(
				                            $(listFields).find("input[name=" + val + "]").parents(".jsn-item")
				                        )
				                    });
				                }
				            }
				        }';
		$actionOpenOptionsBox[ 'google-maps' ] = 'if (type == "google-maps") {
				            $(".tabs").tabs({
				                activate:function (event, ui) {
				                    if ($(ui.newPanel).attr("id") == "visualdesign-options-values") {
				                        $("#google-maps-search #places-search").bind(\'keypress\', function (e) {
				                            if (e.keyCode == 13) {
				                                return false;
				                            }
				                        });
				                        $(".wr-search-google-maps .jsn-reset-search").click(function () {
				                            $(".wr-search-google-maps #places-search").val("");
				                            $(this).hide();
				                        });
				                        $(".wr-search-google-maps #places-search").change(function () {
				                            if ($(this).val() != "") {
				                                $(".wr-search-google-maps .jsn-reset-search").show();
				                            } else {
				                                $(".wr-search-google-maps .jsn-reset-search").hide();
				                            }
				                        });
				                        $(\'#visualdesign-options-values .google_maps\').gmap({\'zoom\':15, \'disableDefaultUI\':false, \'callback\':function (map) {
				                            var self = this;
				                            var checkOpenInfo = false;
				                            var control = self.get(\'control\', function () {
				                                self.autocomplete($(\'#places-search\')[0], function (ui) {
				                                    self.get(\'map\').setCenter(self._latLng(ui.item.position));
				                                    self.get(\'map\').setZoom(15);
				                                    if (self.get(\'iw\')) {
				                                        self.get(\'iw\').close();
				                                        $("#marker-google-maps").find("[name$=\'open\']").val(\'\');
				                                        JSNVisualDesign.markerGoogleMaps();
				                                    }
				                                    if ($(".wr-search-google-maps #places-search").val() != "") {
				                                        $(".wr-search-google-maps .jsn-reset-search").show();
				                                    } else {
				                                        $(".wr-search-google-maps .jsn-reset-search").hide();
				                                    }
				                                });
				                                return $(\'#google-maps-search\')[0];
				                            });
				                            new control();
				                            self.set(\'openDialog\', function (marker) {
				                                var button = \'<div class="google-toolbar" ><a href="javascript:void(0);" title="Remove Marker" class="google-remove-marker"><i class="icon-trash"></i></a></div>\';
				                                var content = \'<div class="mk-form-\' + marker.__gm_id + \' google-maps-info">\' + $("#mk-" + marker.__gm_id).html() + \'</div>\' + button;
				                                self.openInfoWindow({ \'content\':content}, marker, function () {
				                                    setTimeout(function () {
				                                        $(".mk-form-" + marker.__gm_id).find(\'input[type="text"], textarea\').each(function () {
				                                            $(this).val($("#mk-" + marker.__gm_id).find("[name$=\'" + $(this).attr("name") + "\']").val());
				                                        }).bind(\'change\', function () {
				                                                $("#mk-" + marker.__gm_id).find("[name$=\'" + $(this).attr("name") + "\']").val($(this).val());
				                                                JSNVisualDesign.markerGoogleMaps();
				                                            });
				                                        $(".google-remove-marker").click(function () {
				                                            marker.setMap(null);
				                                            $("#mk-" + marker.__gm_id).remove();
				                                            JSNVisualDesign.markerGoogleMaps();
				                                        });
				                                        $(".gm-style-iw").next().find("img").attr("title", "Close Marker");
				                                    }, 500);
				                                });

				                                $(self.get(\'iw\')).addEventListener(\'closeclick\', function (event) {
				                                    $("#marker-google-maps").find("[name$=\'open\']").val(\'\');
				                                    JSNVisualDesign.markerGoogleMaps();
				                                });
				                                JSNVisualDesign.markerGoogleMaps();
				                            });
				                            self.get(\'map\').setOptions({streetViewControl:false});

				                            $(map).addEventListener(\'idle\', function (event) {
				                                var position = {}, check = 0;
				                                position.center = self.get(\'map\').getCenter();
				                                position.zoom = self.get(\'map\').getZoom();
				                                position.mapTypeId = self.get(\'map\').getMapTypeId();

				                                $.each(self.get(\'map\').getCenter(), function (i, val) {
				                                    if (check == 0) {
				                                        position.center.nb = val;
				                                    } else if (check == 1) {
				                                        position.center.ob = val;
				                                    }
				                                    check++;
				                                });
				                                JSNVisualDesign.positionGoogleMaps($.toJSON(position));
				                            });
				                            $(map).addEventListener(\'maptypeid_changed\', function (event) {
				                                var position = {}, check = 0;
				                                position.center = self.get(\'map\').getCenter();
				                                position.zoom = self.get(\'map\').getZoom();
				                                position.mapTypeId = self.get(\'map\').getMapTypeId();
				                                $.each(self.get(\'map\').getCenter(), function (i, val) {
				                                    if (check == 0) {
				                                        position.center.nb = val;
				                                    } else if (check == 1) {
				                                        position.center.ob = val;
				                                    }
				                                    check++;
				                                });
				                                JSNVisualDesign.positionGoogleMaps($.toJSON(position));
				                            });
				                            $("#visualdesign-options-values .btn-google-location").click(function () {

				                                if ($(this).hasClass("active")) {
				                                    $(this).removeClass("active");
				                                    self.get(\'map\').setOptions({draggableCursor:\'\'});
				                                    $("#visualdesign-options-values .google_maps").parent().removeClass("wr-google-active");

				                                } else {
				                                    $(this).addClass("active");
				                                    if (self.get(\'iw\')) {
				                                        self.get(\'iw\').close();
				                                        $("#marker-google-maps").find("[name$=\'open\']").val(\'\');
				                                        JSNVisualDesign.markerGoogleMaps();
				                                    }
				                                    self.get(\'map\').setOptions({draggableCursor:\'crosshair\'});
				                                    $("#visualdesign-options-values .google_maps").parent().addClass("wr-google-active");
				                                }
				                            });
				                            self.set(\'findLocation\', function (location, marker, getdata) {
				                                self.search({\'location\':location}, function (results, status) {
				                                    if (status === \'OK\' && getdata == true) {
				                                        marker.setTitle(results[0].formatted_address);
				                                        $(\'#mk-\' + marker.__gm_id + \' textarea[name=descriptions]\').val(results[0].formatted_address);
				                                        self.get(\'openDialog\')(marker);
				                                    } else {
				                                        self.get(\'openDialog\')(marker);
				                                    }
				                                });
				                            });
				                            $(map).xclick(function (event) {
				                                if ($("#visualdesign-options-values .btn-google-location").hasClass("active")) {
				                                    var position = {}, check = 0;
				                                    $.each(event.latLng, function (i, val) {
				                                        if (check == 0) {
				                                            position.nb = val;
				                                        } else if (check == 1) {
				                                            position.ob = val;
				                                        }
				                                        check++;
				                                    });
				                                    JSNVisualDesign.addMarker(self, map, position, \'\', \'\', \'\', \'\', true, true);
				                                    JSNVisualDesign.markerGoogleMaps();
				                                    $(".btn-google-location").trigger("click");
				                                }
				                            });
				                            var googleMarker = $("#option-googleMapsMarKer-hidden").val();
				                            if (googleMarker) {
				                                var markerList = $.evalJSON(googleMarker);
				                                $.each(markerList, function (i, val) {
				                                console.log(val.position);
				                                    var position = $.evalJSON(val.position);

				                                    if (!position.nb && position.lb) {
				                                        position.nb = position.lb;
				                                    }
				                                    if (!position.ob && position.mb) {
				                                        position.ob = position.mb;
				                                    }
				                                    if (val.open == "true") {
				                                        checkOpenInfo = true;
				                                        JSNVisualDesign.addMarker(self, map, position, val.title, val.descriptions, val.images, val.link, true);
				                                    } else {
				                                        JSNVisualDesign.addMarker(self, map, position, val.title, val.descriptions, val.images, val.link, false);
				                                    }
				                                });
				                            }
				                            var googleMaps = $("#option-googleMaps-hidden").val();
				                            if (googleMaps) {
				                                var gmaps = $.evalJSON(googleMaps);
				                                if (!gmaps.center.nb && gmaps.center.lb) {
				                                    gmaps.center.nb = gmaps.center.lb;
				                                }
				                                if (!gmaps.center.ob && gmaps.center.mb) {
				                                    gmaps.center.ob = gmaps.center.mb;
				                                }
				                                if (gmaps.center.nb && gmaps.center.ob) {
				                                    if (checkOpenInfo == false) {
				                                        self.get(\'map\').setCenter(self._latLng(gmaps.center.nb + "," + gmaps.center.ob));
				                                    } else {
				                                        setTimeout(function () {
				                                            self.get(\'map\').setCenter(self._latLng(gmaps.center.nb + "," + gmaps.center.ob));
				                                        }, 1000);
				                                    }
				                                }
				                                if (gmaps.zoom) {
				                                    self.get(\'map\').setZoom(gmaps.zoom);
				                                }
				                                if (gmaps.mapTypeId) {
				                                    self.get(\'map\').setMapTypeId(gmaps.mapTypeId);
				                                }
				                            }
				                        }});
				                    }
				                }
				            });
				        }';
		$actionOpenOptionsBox = apply_filters( 'wr_contactform_visualdesign_action_open_options_box', $actionOpenOptionsBox );
		$prototypeSerialize = array();
		$prototypeSerialize[ 'default' ] = ' $(\'input, textarea\').placeholder();  $(".control-group.wr-hidden-field").parents(".jsn-element").addClass("jsn-disabled");';
		$prototypeSerialize[ 'contentGoogleMaps' ] = 'JSNVisualDesign.contentGoogleMaps();
				            $("#wr_contactform_form_settings .hndle,#wr_contactform_form_settings .handlediv").click(function(){
				                setTimeout(function(){
				                    JSNVisualDesign.contentGoogleMaps();
				                },200)
				            });
				            $(".jsn-tabs").tabs({
				                activate:function (event, ui) {
				                    if ($(ui.newPanel).attr("id") == "form-design") {
				                        JSNVisualDesign.contentGoogleMaps();
				                    }
				                }
				            });';
		$prototypeSerialize[ 'dateTime' ] = ' JSNVisualDesign.dateTime();';
		$prototypeSerialize = apply_filters( 'wr_contactform_visualdesign_prototype_serialize', $prototypeSerialize );
		$createFunctionVisualDesign[ 'getTmplFieldAddress' ] = 'JSNVisualDesign.getTmplFieldAddress = function (data) {
				        if (data.sortableField) {
				            var listField = $.evalJSON(data.sortableField);
				            var sortableField = [];
				            var field = {};
				            $.each(listField, function (i, val) {
				                if (data[val]) {
				                    sortableField.push(val);
				                }
				                switch (val) {
				                    case "vstreetAddress":
				                        field[val] = \'<input type="text" placeholder="\' + lang[\'STREET_ADDRESS\'] + \'" class="jsn-input-xxlarge-fluid" />\';
				                        break;
				                    case "vstreetAddress2":
				                        field[val] = \'<input type="text" placeholder="\' + lang[\'ADDRESS_LINE_2\'] + \'" class="jsn-input-xxlarge-fluid" />\';
				                        break;
				                    case "vcity":
				                        field[val] = \'<input type="text" placeholder="\' + lang[\'CITY\'] + \'" class="jsn-input-xxlarge-fluid" />\';
				                        break;
				                    case "vstate":
				                        field[val] = \'<input type="text" placeholder="\' + lang[\'STATE_PROVINCE_REGION\'] + \'" class="jsn-input-xxlarge-fluid" />\';
				                        break;
				                    case "vcode":
				                        field[val] = \'<input type="text" placeholder="\' + lang[\'POSTAL_ZIP_CODE\'] + \'" class="jsn-input-xxlarge-fluid" />\';
				                        break;
				                    case "vcountry":
				                        field[val] = \'<select class="jsn-input-xlarge-fluid">{{each(i, val) country}}<option value="${val.text}" {{if val.checked == true || val.checked=="true"}}selected{{/if}}>${val.text}</option>{{/each}}</select>\';
				                        break;
				                }
				            });
				            var position1 = $.inArray(\'vstreetAddress\', sortableField);
				            var position2 = $.inArray(\'vstreetAddress2\', sortableField);
				            if (position1 > position2) {
				                position2 = $.inArray(\'vstreetAddress\', sortableField);
				                position1 = $.inArray(\'vstreetAddress2\', sortableField);
				            }
				            var html = \'<div class="control-group {{if hideField}}wr-hidden-field{{/if}} wr-group-field">\' +
				                \'<label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i>{{/if}}</label>\' +
				                \'<div class="controls">\';
				            if (position1 > 0) {
				                var check = 0;
				                for (var i = 0; i < position1; i++) {
				                    if (check % 2 == 0) {
				                        html += \'<div class="row-fluid">\';
				                    }
				                    if (data[sortableField[i]]) {
				                        html += \'<div class="span6">\' + field[sortableField[i]] + \'</div>\';
				                    }
				                    if (check % 2 != 0 || i == position1 - 1) {
				                        html += \'</div>\';
				                    }
				                    check++;
				                }
				            }
				            if (data[sortableField[position1]]) {
				                html += \'<div class="row-fluid"><div class="span12">\' + field[sortableField[position1]] + \'</div></div>\';
				            }
				            check = 0;
				            for (var i = position1 + 1; i < position2; i++) {
				                if (check % 2 == 0) {
				                    html += \'<div class="row-fluid">\';
				                }
				                if (data[sortableField[i]]) {
				                    html += \'<div class="span6">\' + field[sortableField[i]] + \'</div>\';
				                }
				                if (check % 2 != 0 || i == position2 - 1) {
				                    html += \'</div>\';
				                }
				                check++;
				            }
				            if (data[sortableField[position2]]) {
				                html += \'<div class="row-fluid"><div class="span12">\' + field[sortableField[position2]] + \'</div></div>\';
				            }
				            check = 0;
				            if (position2 < sortableField.length) {
				                for (var i = position2 + 1; i < sortableField.length; i++) {
				                    if (check % 2 == 0) {
				                        html += \'<div class="row-fluid">\';
				                    }
				                    html += \'<div class="span6">\' + field[sortableField[i]] + \'</div>\';
				                    if (check % 2 != 0 || i == sortableField.length - 1) {
				                        html += \'</div>\';
				                    }
				                    check++;
				                }
				            }
				            html += "</div></div>";
				            return html;
				        }
				    };';
		$createFunctionVisualDesign[ 'getTmplFieldName' ] = 'JSNVisualDesign.getTmplFieldName = function (data) {
				        if (data.sortableField) {
				            var listField = $.evalJSON(data.sortableField);
				            var sortableField = [];
				            var field = {};
				            $.each(listField, function (i, val) {
				                if (data[val]) {
				                    sortableField.push(val);
				                }
				                switch (val) {
				                    case "vtitle":
				                        field[val] = \' <select class="input-small" >{{each(i, val) items}}<option value="${val.text}" {{if val.checked == true || val.checked=="true"}}selected{{/if}}>${val.text}</option>{{/each}}</select> \';
				                        break;
				                    case "vfirst":
				                        field[val] = \' <input type="text" class="${size}" placeholder="\' + lang[\'FIRST\'] + \'" /> \';
				                        break;
				                    case "vmiddle":
				                        field[val] = \' <input type="text" class="${size}" placeholder="\' + lang[\'MIDDLE\'] + \'" /> \';
				                        break;
				                    case "vlast":
				                        field[val] = \' <input type="text" class="${size}" placeholder="\' + lang[\'LAST\'] + \'" /> \';
				                        break;
				                }
				            });

				            var html = \'<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}">\' +
				                \'<label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i>{{/if}}</label>\' +
				                \'<div class="controls">\';
				            $.each(sortableField, function (i, val) {
				                html += field[val];
				            });
				            html += \'</div></div>\';
				            return html;
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeDate' ] = 'JSNVisualDesign.eventChangeDate = function () {
				        var dateFormat = "mm/dd/yy";
				        var formatDate = "";
				        if ($("#option-dateOptionFormat-select").val() == "custom") {
				            formatDate = $("#wr-custom-date-field").val();
				            $("#wr-custom-date-field").change(function () {
				                JSNVisualDesign.eventChangeDate();
				            });
				            $("#wr-custom-date").removeClass("hide");
				        } else {
				            formatDate = $("#option-dateOptionFormat-select").val();
				            $("#wr-custom-date").addClass("hide");
				        }
				        if ($("#option-dateFormat-checkbox").is(\':checked\')) {
				            dateFormat = formatDate;
				        }
				        var divAppend = $("input.input-date-time").parent();
				        var dateValue = $("#option-dateValue-text").datetimepicker(\'getDate\');
				        var dateRageValue = $("#option-dateValueRange-text").datetimepicker(\'getDate\');
				        $("input.input-date-time").datepicker("destroy");
				        $(divAppend).attr("class", "input-append wr-inline");
				        var timeFormat = $("#option-timeOptionFormat-select").val();
				        $("#option-timeFormat-checkbox").show();
				        $("#option-dateFormat-checkbox").show();
				        $(".wr-tmp-date").remove();
				        var yearRangeList = [];
				        var yearRangeMax = $("#option-yearRangeMax-text").val();
				        var yearRangeMin = $("#option-yearRangeMin-text").val();
				        if (yearRangeMin && yearRangeMax) {
				            yearRangeList.push(yearRangeMin);
				            yearRangeList.push(yearRangeMax);
				        } else if (yearRangeMin) {
				            yearRangeList.push(yearRangeMin);
				            yearRangeList.push((new Date).getFullYear());
				        } else if (yearRangeMax) {
				            yearRangeList.push(yearRangeMax);
				            yearRangeList.push((new Date).getFullYear());
				        }
				        var yearRange = "1930:+0";
				        if (yearRangeList.length) {
				            yearRange = yearRangeList.join(":");
				        }
				        if ($("#option-timeFormat-checkbox").is(\':checked\') && $("#option-dateFormat-checkbox").is(\':checked\')) {
				            $("input.input-date-time").datetimepicker({
				                changeMonth:true,
				                changeYear:true,
				                showOn:"button",
				                yearRange:yearRange,
				                dateFormat:dateFormat,
				                timeFormat:timeFormat,
				                hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
				                minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
				                closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
				                prevText:lang[\'WR_CONTACTFORM_DATE_PREV_TEXT\'],
				                nextText:lang[\'WR_CONTACTFORM_DATE_NEXT_TEXT\'],
				                currentText:lang[\'WR_CONTACTFORM_DATE_CURRENT_TEXT\'],
				                monthNames:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER\']
				                ],
				                monthNamesShort:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT\']
				                ],
				                dayNames:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY\']
				                ],
				                dayNamesShort:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT\']
				                ],
				                dayNamesMin:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN\']
				                ],
				                weekHeader:lang[\'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER\']
				            }).removeClass("jsn-input-xxlarge-fluid input-small input-medium").addClass("input-medium");
				            if (dateValue) {
				                $("#option-dateValue-text").datetimepicker(\'setDate\', dateValue);
				            }
				            if (dateRageValue) {
				                $("#option-dateValueRange-text").datetimepicker(\'setDate\', dateRageValue);
				            }
				        } else if ($("#option-timeFormat-checkbox").is(\':checked\')) {
				            $("input.input-date-time").timepicker({
				                changeMonth:true,
				                changeYear:true,
				                showOn:"button",
				                timeFormat:timeFormat,
				                hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
				                minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
				                closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
				                prevText:lang[\'WR_CONTACTFORM_DATE_PREV_TEXT\'],
				                nextText:lang[\'WR_CONTACTFORM_DATE_NEXT_TEXT\'],
				                currentText:lang[\'WR_CONTACTFORM_DATE_CURRENT_TEXT\'],
				                monthNames:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER\']
				                ],
				                monthNamesShort:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT\']
				                ],
				                dayNames:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY\']
				                ],
				                dayNamesShort:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT\']
				                ],
				                dayNamesMin:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN\']
				                ],
				                weekHeader:lang[\'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER\']
				            }).removeClass("jsn-input-xxlarge-fluid input-small input-medium").addClass("input-small");
				            if (dateValue) {
				                $("#option-dateValue-text").timepicker(\'setTime\', dateValue);
				            }
				            if (dateRageValue) {
				                $("#option-dateValueRange-text").timepicker(\'setTime\', dateRageValue);
				            }
				            $("#option-timeFormat-checkbox").before($("<input/>", {
				                "class":"wr-tmp-date",
				                "type":"checkbox",
				                "disabled":true,
				                "checked":true
				            })).hide();
				        } else {
				            $("#option-dateFormat-checkbox").prop("checked", true);
				            $("input.input-date-time").datepicker({
				                changeMonth:true,
				                changeYear:true,
				                showOn:"button",
				                yearRange:yearRange,
				                dateFormat:dateFormat,
				                hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
				                minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
				                closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
				                prevText:lang[\'WR_CONTACTFORM_DATE_PREV_TEXT\'],
				                nextText:lang[\'WR_CONTACTFORM_DATE_NEXT_TEXT\'],
				                currentText:lang[\'WR_CONTACTFORM_DATE_CURRENT_TEXT\'],
				                monthNames:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER\']
				                ],
				                monthNamesShort:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT\']
				                ],
				                dayNames:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY\']
				                ],
				                dayNamesShort:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT\']
				                ],
				                dayNamesMin:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN\'],
				                    lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN\']
				                ],
				                weekHeader:lang[\'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER\']
				            }).removeClass("jsn-input-xxlarge-fluid input-small input-medium").addClass("input-small");
				            if (dateValue) {
				                $("#option-dateValue-text").datepicker(\'setDate\', dateValue);
				            }
				            if (dateRageValue) {
				                $("#option-dateValueRange-text").datepicker(\'setDate\', dateRageValue);
				            }
				            $("#option-dateFormat-checkbox").before($("<input/>", {
				                "class":"wr-tmp-date",
				                "type":"checkbox",
				                "disabled":true,
				                "checked":true
				            })).hide();
				        }
				        $("button.ui-datepicker-trigger").addClass("btn btn-icon").html($("<i/>", {
				            "class":"icon-calendar"
				        }));
				        if ($("#option-enableRageSelection-checkbox").is(\':checked\')) {
				            $("input#option-dateValueRange-text").parent().show();
				        } else {
				            $("input#option-dateValueRange-text").parent().hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'dateTime' ] = 'JSNVisualDesign.dateTime = function () {
				        $(\'input.contactform-date-time\').each(function () {
				            if ($(this).attr("dateFormat") || $(this).attr("timeFormat")) {
				                $(this).datetimepicker({
				                    changeMonth:true,
				                    changeYear:true,
				                    showOn:"button",
				                    hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
				                    minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
				                    closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
				                    prevText:lang[\'WR_CONTACTFORM_DATE_PREV_TEXT\'],
				                    nextText:lang[\'WR_CONTACTFORM_DATE_NEXT_TEXT\'],
				                    currentText:lang[\'WR_CONTACTFORM_DATE_CURRENT_TEXT\'],
				                    monthNames:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JULY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER\']
				                    ],
				                    monthNamesShort:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT\']
				                    ],
				                    dayNames:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY\']
				                    ],
				                    dayNamesShort:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT\']
				                    ],
				                    dayNamesMin:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN\']
				                    ],
				                    weekHeader:lang[\'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER\']
				                });
				            } else {
				                $(this).datepicker({
				                    changeMonth:true,
				                    changeYear:true,
				                    showOn:"button",
				                    hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
				                    minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
				                    closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
				                    prevText:lang[\'WR_CONTACTFORM_DATE_PREV_TEXT\'],
				                    nextText:lang[\'WR_CONTACTFORM_DATE_NEXT_TEXT\'],
				                    currentText:lang[\'WR_CONTACTFORM_DATE_CURRENT_TEXT\'],
				                    monthNames:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JULY\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER\']
				                    ],
				                    monthNamesShort:[lang[\'WR_CONTACTFORM_DATE_MONTH_JANUARY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_FEBRUARY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MARCH_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_APRIL_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_MAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JUNE_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_JULY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_AUGUST_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_SEPTEMBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_OCTOBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_NOVEMBER_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_MONTH_DECEMBER_SHORT\']
				                    ],
				                    dayNames:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY\']
				                    ],
				                    dayNamesShort:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_SHORT\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_SHORT\']
				                    ],
				                    dayNamesMin:[lang[\'WR_CONTACTFORM_DATE_DAY_SUNDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_MONDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_TUESDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_WEDNESDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_THURSDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_FRIDAY_MIN\'],
				                        lang[\'WR_CONTACTFORM_DATE_DAY_SATURDAY_MIN\']
				                    ],
				                    weekHeader:lang[\'WR_CONTACTFORM_DATE_DAY_WEEK_HEADER\']
				                });
				            }
				            $("button.ui-datepicker-trigger").addClass("btn btn-icon").html($("<i/>", {
				                "class":"icon-calendar"
				            }));
				        });
				    };';
		$createFunctionVisualDesign[ 'eventChangePhone' ] = 'JSNVisualDesign.eventChangePhone = function () {
				        if ($("#option-format-select").val() == "3-field") {
				            $("#visualdesign-options-values #option-value-text").parents(".control-group").addClass("hide");
				            $("#visualdesign-options-values #option-oneField-text").parents(".control-group").removeClass("hide");
				        } else {
				            $("#visualdesign-options-values #option-value-text").parents(".control-group").removeClass("hide");
				            $("#visualdesign-options-values #option-oneField-text").parents(".control-group").addClass("hide");
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeCurrency' ] = ' JSNVisualDesign.eventChangeCurrency = function () {
				        if ($("#option-format-select").val() != "Yen" && $("#option-format-select").val() != "Rupee") {
				            $("#visualdesign-options-values .wr-field-prefix").show();
				            $("#visualdesign-options-values .wr-inline #option-cents-text").parent().show();
				        } else {
				            $("#visualdesign-options-values .wr-field-prefix").hide();
				            $("#visualdesign-options-values .wr-inline #option-cents-text").parent().hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeName' ] = ' JSNVisualDesign.eventChangeName = function () {
				        if ($("#option-vtitle-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #wr-name-default-titles").show();
				        } else {
				            $("#visualdesign-options-values #wr-name-default-titles").hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeConfirmPassWord' ] = 'JSNVisualDesign.eventChangeConfirmPassWord = function () {
				        if ($("#option-confirmation-checkbox").is(\':checked\')) {
				            $("#option-valueConfirmation-text").parents(".control-group").show();
				        } else {
				            $("#option-valueConfirmation-text").parents(".control-group").hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeNumber' ] = 'JSNVisualDesign.eventChangeNumber = function () {
				        if ($("#option-showDecimal-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values .wr-field-prefix").show();
				            $("#visualdesign-options-values .wr-inline #option-decimal-number").parent().show();
				        } else {
				            $("#visualdesign-options-values .wr-field-prefix").hide();
				            $("#visualdesign-options-values .wr-inline #option-decimal-number").parent().hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'eventChangeAddress' ] = 'JSNVisualDesign.eventChangeAddress = function () {
				        if ($("#option-vcountry-checkbox").is(\':checked\')) {
				            $("#visualdesign-options-values #wr-address-default-country").show();
				        } else {
				            $("#visualdesign-options-values #wr-address-default-country").hide();
				        }
				    };';
		$createFunctionVisualDesign[ 'addMarker' ] = ' JSNVisualDesign.addMarker = function (self, map, position, title, descriptions, images, link, open, getdata) {
				        self.addMarker({\'position\':position.nb + "," + position.ob, \'draggable\':true, \'bounds\':false},function (map, marker) {
				            var vtitle = \'\', vdescriptions = \'\', vimages = \'\', vlink = \'\';
				            if (title) {
				                vtitle = title;
				            }
				            if (images) {
				                vimages = images;
				            }
				            if (link) {
				                vlink = link;
				            }
				            if (descriptions) {
				                vdescriptions = descriptions;
				            }
				            $("#marker-google-maps").append(
				                $("<div/>", {"id":"mk-" + marker.__gm_id, "class":"mk-items"}).append(
				                    \'<div class="control-group"><label for="Country" class="control-label">Title</label><div class="controls"><input type="text" class="jsn-input-large-fluid" name="title" value="\' + vtitle + \'"></div></div>\' +
				                        \'<div class="control-group"><label for="Comment" class="control-label">Descriptions</label><div class="controls"><textarea class="jsn-input-large-fluid google-descriptions" name="descriptions" cols="40" rows="2">\' + vdescriptions + \'</textarea></div></div>\' +
				                        \'<div class="control-group"><label for="Country" class="control-label">Images</label><\' +
				                        \'div class="controls"><input type="text" class="text jsn-input-large-fluid" name="images" value="\' + vimages + \'"></div></div>\' +
				                        \'<div class="control-group"><label for="Country" class="control-label">Link</label><div class="controls"><input type="text" class="jsn-input-large-fluid" name="link" value="\' + vlink + \'"></div></div>\' +
				                        \'<input type="hidden" name="position" value=\\\'\' + $.toJSON(position) + \'\\\' />\' +
				                        \'<input type="hidden" name="open" value=\\\'\' + open + \'\\\' />\'
				                )
				            );
				            if (open == true) {
				                self.get(\'findLocation\')(marker.getPosition(), marker, getdata);
				            }

				        }).xdragend(function (event) {
				                var position = {}, check = 0;
				                $.each(event.latLng, function (i, val) {
				                    if (check == 0) {
				                        position.nb = val;
				                    } else if (check == 1) {
				                        position.ob = val;
				                    }
				                    check++;
				                });
				                $("#mk-" + this.__gm_id).find("[name$=\'position\']").val($.toJSON(position));
				                JSNVisualDesign.markerGoogleMaps();
				            }).xclick(function () {
				                $("#marker-google-maps").find("[name$=\'open\']").val(\'\');
				                $("#mk-" + this.__gm_id).find("[name$=\'open\']").val(\'true\');
				                self.get(\'openDialog\')(this);
				            });
				    };';
		$createFunctionVisualDesign[ 'positionGoogleMaps' ] = 'JSNVisualDesign.positionGoogleMaps = function (position) {
				        $("#option-googleMaps-hidden").val(position).change();
				    };';
		$createFunctionVisualDesign[ 'markerGoogleMaps' ] = 'JSNVisualDesign.markerGoogleMaps = function () {
				        var marker = [];
				        $("#marker-google-maps .mk-items").each(function () {
				            var mkItems = {};
				            mkItems.title = $(this).find("input[name=title]").val();
				            mkItems.descriptions = $(this).find("textarea[name=descriptions]").val();
				            mkItems.images = $(this).find("input[name=images]").val();
				            mkItems.link = $(this).find("input[name=link]").val();
				            mkItems.position = $(this).find("input[name=position]").val();
				            mkItems.open = $(this).find("input[name=open]").val();
				            marker.push(mkItems);
				        });
				        $("#option-googleMapsMarKer-hidden").val($.toJSON(marker)).change();
				    };';

		$createFunctionVisualDesign[ 'contentGoogleMaps' ] = 'JSNVisualDesign.contentGoogleMaps = function (edit) {
				        if (!$("#wr_contactform_master #form-container").width()) {
				            return;
				        }
				        if (edit) {
				            $(".ui-state-edit .content-google-maps").each(function () {

				                $(this).find(\'.google_maps\').width($(this).attr("data-width"));
				                $(this).find(\'.google_maps\').height($(this).attr("data-height"));
				                var dataValue = $(this).attr("data-value");
				                var dataMarker = $(this).attr("data-marker");

				                if (dataValue) {
				                    var gmapOptions = $.evalJSON(dataValue);
				                    if (dataMarker) {
				                        var gmapMarker = $.evalJSON(dataMarker);
				                    }
				                    if (!gmapOptions.center.nb && gmapOptions.center.lb) {
				                        gmapOptions.center.nb = gmapOptions.center.lb;
				                    }
				                    if (!gmapOptions.center.ob && gmapOptions.center.mb) {
				                        gmapOptions.center.ob = gmapOptions.center.mb;
				                    }

				                    $(this).find(\'.google_maps\').gmap({\'zoom\':gmapOptions.zoom, \'mapTypeId\':gmapOptions.mapTypeId, \'center\':gmapOptions.center.nb + \',\' + gmapOptions.center.ob, \'streetViewControl\':false, \'overviewMapControl\':true, \'rotateControl\':true, \'zoomControl\':true, \'mapTypeControl\':true, \'scaleControl\':true, \'callback\':function (map) {
				                        var self = this;
				                        var checkOpenInfo = false;
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

				                        if (gmapMarker) {

				                            $.each(gmapMarker, function (i, val) {

				                                var position = $.evalJSON(val.position);

				                                if (!position.nb && position.lb) {
				                                    position.nb = position.lb;
				                                }
				                                if (!position.ob && position.mb) {
				                                    position.ob = position.mb;
				                                }
				                                self.addMarker({\'position\':position.nb + "," + position.ob, \'draggable\':false, \'bounds\':false}, function (map, marker) {
				                                    if (val.open == "true") {
				                                        checkOpenInfo = true;
				                                        self.get(\'inforWindow\')(marker, val);
				                                    }
				                                })
				                            });

				                            if (checkOpenInfo == true) {
				                                setTimeout(function () {
				                                    self.get(\'map\').setCenter(self._latLng(gmapOptions.center.nb + \',\' + gmapOptions.center.ob));
				                                    self.get(\'map\').setZoom(gmapOptions.zoom);
				                                    self.get(\'map\').setMapTypeId(gmapOptions.mapTypeId);
				                                }, 500);

				                            }
				                        }
				                    }});
				                }
				            });
				        } else {
				            $(".content-google-maps").each(function () {
				                $(this).find(\'.google_maps\').width($(this).attr("data-width"));
				                $(this).find(\'.google_maps\').height($(this).attr("data-height"));
				                var dataValue = $(this).attr("data-value");
				                var dataMarker = $(this).attr("data-marker");
				                if (dataValue) {
				                    var gmapOptions = $.evalJSON(dataValue);
				                    if (dataMarker) {
				                        var gmapMarker = $.evalJSON(dataMarker);
				                    }
				                    if (!gmapOptions.center.nb && gmapOptions.center.lb) {
				                        gmapOptions.center.nb = gmapOptions.center.lb;
				                    }
				                    if (!gmapOptions.center.ob && gmapOptions.center.mb) {
				                        gmapOptions.center.ob = gmapOptions.center.mb;
				                    }
				                    $(this).find(\'.google_maps\').gmap({\'zoom\':gmapOptions.zoom, \'mapTypeId\':gmapOptions.mapTypeId, \'center\':gmapOptions.center.nb + \',\' + gmapOptions.center.ob, \'streetViewControl\':false, \'overviewMapControl\':true, \'rotateControl\':true, \'zoomControl\':true, \'mapTypeControl\':true, \'scaleControl\':true, \'callback\':function (map) {
				                        var self = this;
				                        var checkOpenInfo = false;
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

				                        if (gmapMarker) {
				                            $.each(gmapMarker, function (i, val) {
				                                var position = $.evalJSON(val.position);
				                                if (!position.nb && position.lb) {
				                                    position.nb = position.lb;
				                                }
				                                if (!position.ob && position.mb) {
				                                    position.ob = position.mb;
				                                }
				                                self.addMarker({\'position\':position.nb + "," + position.ob, \'draggable\':false, \'bounds\':false}, function (map, marker) {
				                                    if (val.open == "true") {
				                                        checkOpenInfo = true;
				                                        self.get(\'inforWindow\')(marker, val);
				                                    }
				                                })
				                            });

				                            if (checkOpenInfo == true) {
				                                setTimeout(function () {
				                                    self.get(\'map\').setCenter(self._latLng(gmapOptions.center.nb + \',\' + gmapOptions.center.ob));
				                                    self.get(\'map\').setZoom(gmapOptions.zoom);
				                                    self.get(\'map\').setMapTypeId(gmapOptions.mapTypeId);
				                                }, 500);
				                            }

				                        }
				                    }});
				                }
				            });
				        }

				    };';
		$createFunctionVisualDesign = apply_filters( 'wr_contactform_visualdesign_create_function', $createFunctionVisualDesign );
		$containerFunction = array();
		$getContainerFunction = apply_filters( 'wr_contactform_visualdesign_container_function', $containerFunction );
		if ( ! empty( $getContainerFunction ) ) {
			$containerFunction = $getContainerFunction;
		}
		$javascript = '(function ($) {
				    var listLabel = [];
				    var checkChangeEmail = false;
				    var dataEmailSubmitter = [];

				    var lang = [];
				    var limitSize = \'\';
				    var limitEx = \'\';
				    ' . implode( '', $containerFunction ) . '
				    function JSNVisualDesign(container, params) {
				        this.params = params;
				        lang = params.language;

				        limitSize = params.limitSize;
				        limitEx = params.limitEx;
						' . implode( '', $addParamsVisualDesign ) . '
				        this.container;
				        this.init(container);
				    }
				    /**
				     * This variable will contains all registered control
				     * @var object
				     */
				    JSNVisualDesign.controls = {};
				    JSNVisualDesign.controlGroups = {};
				    JSNVisualDesign.toolboxTarget = null;
				    JSNVisualDesign.optionsBox = null;
				    JSNVisualDesign.optionsBoxContent = null;
				    JSNVisualDesign.toolbox = null;
				    JSNVisualDesign.wrapper = null;
				    JSNVisualDesign.initialize = function (language) {
				       ' . implode( '', $addBoxContent ) . '
				        JSNVisualDesign.optionsBoxContent.find(\'form\').change(function (event) {
				         ' . implode( '', $beforeActionChangeOptionBoxContent ) . '
				            var activeElement = JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\');
				            if (activeElement) {
				                var options = activeElement.data(\'visualdesign-element-data\');
				                if (options) {
				                    var eventId = $(event.target).attr("id");
				                    var optionsNew = $(this).toJSON();
				                    optionsNew.identify = options.options.identify;
				                    var newElement = JSNVisualDesign.createElement(options.type, optionsNew, options.id);
				                    activeElement.replaceWith(newElement);
				                    JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\', newElement);
				                    ' . implode( '', $actionChangeOptionsBoxContent ) . '
				                    newElement.addClass("ui-state-edit");
				                }
				            }
				            $(\'input, textarea\').placeholder();
				            $(".control-group.wr-hidden-field").parents(".jsn-element").addClass("jsn-disabled");
							 ' . implode( '', $afterActionChangeOptionBoxContent ) . '
				        }).submit(function (e) {
								' . implode( '', $eventBoxContentSubmit ) . '
				            });
				        $(function () {
				            $(document).mousedown(function (event) {
				                ' . implode( '', $eventMouseDownBoxContent ) . '
				            });
				        });
				        // Register class as global object
				        window.JSNVisualDesign = JSNVisualDesign;
				    };
				    /**
				     * Register control item that can use for page design
				     * @param string identify
				     * @param object options
				     */
				    JSNVisualDesign.register = function (identify, options) {
				        if (JSNVisualDesign.controls[identify] !== undefined || identify === undefined || identify == \'\' || options.caption === undefined || options.caption == \'\' || options.defaults === undefined || !$.isPlainObject(options.defaults) || options.params === undefined || !$.isPlainObject(options.params) || options.tmpl === undefined || options.tmpl == \'\') {
				            return false;
				        }
				        if (JSNVisualDesign.controlGroups[options.group] === undefined) {
				            JSNVisualDesign.controlGroups[options.group] = [];
				        }
				        // Save control to list
				        //options.identify;
				        JSNVisualDesign.controls[identify] = options;
				        JSNVisualDesign.controlGroups[options.group].push(identify);
				    };
				    /**
				     * Draw registered buttons to toolbox
				     * @return void
				     */
				    JSNVisualDesign.drawToolboxButtons = function () {
				        this.buttons = {};
				        var self = this;
				        $.map(JSNVisualDesign.controlGroups, function (buttons, group) {
				            var buttonList = [];
				            $(buttons).each(function (index, identify) {
				                if (' . implode( '', $ifCheckRenderButtonAddField ) . ') {
				                    var options = JSNVisualDesign.controls[identify];
				                    var button = $(\'<li/>\', {
				                        \'class\':\'jsn-item\',
				                        \'data-value\':options.caption
				                    }).append($(\'<button/>\', {
				                        \'name\':identify,
				                        \'class\':\'btn\'
				                    }).click(function (e) {
				                                if (JSNVisualDesign.toolboxTarget == null){
				                                    JSNVisualDesign.closeToolbox();
				                                }
				                                var control = JSNVisualDesign.controls[this.name];
				                                var d = new Date();
												var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
												var getLabel = this.name + "_" + Math.floor(Math.random() * 999999999) + time;
										        var label = getLabel.toLowerCase();
										        while (/[^a-zA-Z0-9_]+/.test(label)) {
										            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
										        }
				                                control.defaults.identify = label;
				                                var element = JSNVisualDesign.createElement(this.name, control.defaults);
				                                element.appendTo(JSNVisualDesign.toolboxTarget);
				                                element.find("a.element-edit").click();
												' . implode( '', $eventClickButtonAddField ) . '
				                                JSNVisualDesign.savePage();
				                                JSNVisualDesign.closeToolbox();
				                                JSNVisualDesign.optionsBox.find(\'form\').trigger("change");
				                            e.preventDefault();
				                        }).append($(\'<i/>\', {
				                        \'class\':\'wr-icon-formfields wr-cf-icon-\' + identify
				                    })).append(options.caption))
				                    buttonList.push(button);
				                }
				            });
				            self.buttons[group] = buttonList;
				        });
				        return self.buttons;
				    };
					' . implode( '', $createFunctionVisualDesign ) . '
				    JSNVisualDesign.closeToolbox = function () {
				        //JSNVisualDesign.toolbox.hide();
						tb_remove();
				    };
				    JSNVisualDesign.openOptionsBox = function (sender, type, params, action) {
				        $(window).trigger("resize");
				        if (JSNVisualDesign.controls[type] === undefined) {
				            return;
				        }
				        JSNVisualDesign.closeToolbox();
				        JSNVisualDesign.renderOptionsBox(JSNVisualDesign.controls[type].params, params);
				        JSNVisualDesign.optionsBox.data(\'visualdesign-active-element\', sender);
				        JSNVisualDesign.optionsBox.appendTo($(\'body\')).show();
				        $(".tabs").tabs({
				            active:0
				        });
				        $("#visualdesign-options-values #option-limitation-checkbox").change(function () {
				            JSNVisualDesign.checkLimitation();
				        });

				        $("#option-firstItemAsPlaceholder-checkbox").after(\'<i class="icon-question-sign" original-title="\' + lang["When checked, the first item will be used as placeholder without contributing value to form data."] + \'"></i>\');
						' . implode( '', $actionOpenOptionsBox ) . '
				        JSNVisualDesign.position(JSNVisualDesign.optionsBox, sender, \'bottom\', {
				            bottom:-5
				        }, action);

				        if ($(sender).offset().top - $(window).scrollTop() > JSNVisualDesign.optionsBox.find(".popover").height()) {
				            $(window).scrollTop($(sender).offset().top - JSNVisualDesign.optionsBox.find(".popover").height());
				        }
				        $(\'#visualdesign-options .icon-question-sign\').tipsy({
				            gravity:\'se\',
				            fade:true
				        });
				    };
				    JSNVisualDesign.position = function (e, p, pos, extra, action) {
				        var position = {},
				            elm = $(e);
				        if (action) {
				            var parent = $(action);
				        } else {
				            var parent = $(p);
				        }
				        //JSNVisualDesign.equalsHeight(elm.find(\'.tab-pane\'));
				        var elmStyle = JSNVisualDesign.getBoxStyle(elm),
				            parentStyle = JSNVisualDesign.getBoxStyle(parent),
				            elmStyleParet = JSNVisualDesign.getBoxStyle($(e).find(".popover"));
				        var modalWindow = JSNVisualDesign.getBoxStyle($("#form-design"));
				        if (pos === undefined) {
				            pos = \'center\';
				        }
				        if (pos == "top" && parentStyle.offset.top < elmStyleParet.outerHeight) {
				            pos = "bottom";
				        }
				        switch (pos) {
				            case \'left\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top;
				                elm.find(".popover").removeClass("top").removeClass("bottom");
				                break;
				            case \'center\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top + parentStyle.outerHeight;
				                elm.find(".popover").removeClass("top").addClass("bottom");
				                break;
				            case \'top\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top - elmStyleParet.outerHeight;
				                elm.find(".popover").removeClass("bottom").addClass("top");
				                break;
				            case \'bottom\':
				                position.left = parentStyle.offset.left + (parentStyle.outerWidth - elmStyleParet.outerWidth) / 2;
				                position.top = parentStyle.offset.top + parentStyle.outerHeight;
				                elm.find(".popover").removeClass("top").addClass("bottom");
				                break;
				        }
				        if (extra !== undefined) {
				            if (extra.left !== undefined) {
				                position.left = position.left + extra.left;
				            }
				            if (extra.right !== undefined) {
				                position.right = position.right + extra.right;
				            }
				            if (extra.top !== undefined) {
				                position.top = position.top + extra.top;
				            }
				            if (extra.bottom !== undefined) {
				                position.bottom = position.bottom + extra.bottom;
				            }
				        }
				        elm.css(position);
				    };
				    JSNVisualDesign.getBoxStyle = function (element) {
				        var style = {
				            width:element.width(),
				            height:element.height(),
				            outerHeight:element.outerHeight(),
				            outerWidth:element.outerWidth(),
				            offset:element.offset(),
				            margin:{
				                left:parseInt(element.css(\'margin-left\')),
				                right:parseInt(element.css(\'margin-right\')),
				                top:parseInt(element.css(\'margin-top\')),
				                bottom:parseInt(element.css(\'margin-bottom\'))
				            },
				            padding:{
				                left:parseInt(element.css(\'padding-left\')),
				                right:parseInt(element.css(\'padding-right\')),
				                top:parseInt(element.css(\'padding-top\')),
				                bottom:parseInt(element.css(\'padding-bottom\'))
				            }
				        };
				        return style;
				    };
				    /**
				     * Set all elements to same height
				     * @param elements
				     */
				    JSNVisualDesign.equalsHeight = function (elements) {
				        elements.css(\'height\', \'auto\');
				        var maxHeight = 0;
				        elements.each(function () {
				            var height = $(this).height();
				            if (maxHeight < height)
				                maxHeight = height;
				        });
				        elements.css(\'height\', maxHeight + \'px\');
				    };
				    /**
				     * Generate identify for field based on label
				     * @param label
				     * @return
				     */
				    JSNVisualDesign.generateIdentify = function (data, listLabel) {
				        if(!data.options.identify){
					        var d = new Date();
							var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
							var getLabel = data.options.label + "_" + Math.floor(Math.random() * 999999999) + time;
					        var label = getLabel.toLowerCase();
					        while (/[^a-zA-Z0-9_]+/.test(label)) {
					            label = label.replace(/[^a-zA-Z0-9_]+/, \'_\');
					        }
				            return label;
				        }else{
				            return data.options.identify;
				        }
				    };
				    JSNVisualDesign.prototype = {
				        /**
				         * Initialize page for design
				         * @param object element
				         * @param object options
				         */
				        init:function (container) {
				            $("#visualdesign-options").remove();
				            $("#visualdesign-toolbox").remove();
				            JSNVisualDesign.initialize(lang);
				            // this.JSNContactformDialogEdition  = new JSNContactformDialogEdition(this.params);
				            this.container = $(container);
				            this.document = $(document);
				            this.options = {
				                regionSelector:\'.jsn-column-content\',
				                elementSelector:\'.jsn-element\',
				                elements:{}
				            };
				            this.newElement.click(function (e) {
				                e.preventDefault();
				                e.stopPropagation();
				                JSNVisualDesign.openToolbox($(e.currentTarget), $(e.currentTarget).prev());
				            });
				            // Enable sortable
				            this.container.data(\'visualdesign-instance\', this).find(this.options.regionSelector + \' .jsn-element-container\').sortable({
				                items:this.options.elementSelector,
				                connectWith:this.options.regionSelector + \' .jsn-element-container\',
				                placeholder:\'ui-state-highlight\',
				                forcePlaceholderSize:true
				            }).parent().append(this.newElement);
				        },
				        clearElements:function () {
				            this.container.find(\'div.jsn-element\').remove();
				        },
				        /**
				         * Add existing elements to designing page
				         * @param array elements
				         */
				        setElements:function (elements) {
				            var self = this;
				            $(elements).each(function () {
				                this.options.identify = this.identify;
				                var element = JSNVisualDesign.createElement(this.type, this.options, this.id);
				                var column = self.container.find(\'div[data-column-name="\' + this.position + \'"] .jsn-element-container\');
				                if (column.size() == 0) {
				                    column = self.container.find(\'div[data-column-name] .jsn-element-container\');
				                }
				                column.append(element);
				            });
				            return self;
				        },
				        /**
				         * Serialize designed page to JSON format for save it to database
				         * @return string
				         */
				        serialize:function (toObject) {
				            var serialized = [];
				            var serializeObject = toObject || false;
				            this.container.find(\'[data-column-name]\').each(function () {
				                var elements = $(this).find(\'.jsn-element\');
				                var column = $(this).attr(\'data-column-name\');
				                elements.each(function () {
				                    var data = $(this).data(\'visualdesign-element-data\');
				                    serialized.push({
				                        id:data.id,
				                        identify:JSNVisualDesign.generateIdentify(data, listLabel),
				                        options:data.options,
				                        type:data.type,
				                        position:column
				                    });
				                });
				            });
				            ' . implode( '', $prototypeSerialize ) . '
				            return serializeObject ? serialized : $.toJSON(serialized);
				        }
				    };
				    /**
				     * Plugin for jQuery to serialize a form to JSON format
				     * @param options
				     * @return
				     */
				    $.fn.toJSON = function (options) {
				        options = $.extend({}, options);
				        var self = this,
				            json = {},
				            push_counters = {},
				            patterns = {
				                "validate":/^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
				                "key":/[a-zA-Z0-9_]+|(?=\[\])/g,
				                "push":/^$/,
				                "fixed":/^\d+$/,
				                "named":/^[a-zA-Z0-9_]+$/,
				                "ignore":/^ignored:/
				            };
				        this.build = function (base, key, value) {
				            base[key] = (value.indexOf(\'json:\') == -1) ? value : $.evalJSON(value.substring(5));
				            return base;
				        };
				        this.push_counter = function (key, i) {
				            if (push_counters[key] === undefined) {
				                push_counters[key] = 0;
				            }
				            if (i === undefined) {
				                return push_counters[key]++;
				            } else if (i !== undefined && i > push_counters[key]) {
				                return push_counters[key] = ++i;
				            }
				        };
				        $.each($(this).serializeArray(), function () {
				            // skip invalid keys
				            if (!patterns.validate.test(this.name) || patterns.ignore.test(this.name)) {
				                return;
				            }
				            var k, keys = this.name.match(patterns.key),
				                merge = this.value,
				                reverse_key = this.name;
				            while ((k = keys.pop()) !== undefined) {
				                // adjust reverse_key
				                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), \'\');
				                // push
				                if (k.match(patterns.push)) {
				                    merge = self.build([], self.push_counter(reverse_key), merge);
				                }
				                // fixed
				                else if (k.match(patterns.fixed)) {
				                    self.push_counter(reverse_key, k);
				                    merge = self.build([], k, merge);
				                }
				                // named
				                else if (k.match(patterns.named)) {
				                    merge = self.build({}, k, merge);
				                }
				            }
				            json = $.extend(true, json, merge);
				        });
				        return json;
				    };
				    JSNVisualDesign.initialize();
				})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
