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

class WR_CF_Gadget_Contactform_Js_Form_Frontend extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-form-frontend';

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

		header( 'Content-Type: application/javascript' );
		$filterFunctionInit = array();
		$filterFunctionInit[ 'button-reset-click' ] = '$(formname).find(".form-actions .reset").click(function () {
									$(formname).find("form").trigger("reset");
									$(formname).find("div.choices .jsn-column-item input").trigger("change");
									$(formname).find("div.checkboxes .jsn-column-item input").trigger("change");
									$(formname).find("select.dropdown").trigger("change");
								});';
		$filterFunctionInit[ 'document-click' ] = '$(document).click(function () {
					                $(".ui-state-highlight").removeClass("ui-state-highlight");
					            });';
		$filterFunctionInit[ 'action-form-submit' ] = '$(formname).find("form").submit(function () {
					                var selfsubmit = this;
					                if (self.checkValidateForm($(this))) {
					                    $("body").append($("<div/>", {
					                        "class":"jsn-modal-overlay",
					                        "style":"z-index: 1000; display: inline;"
					                    })).append($("<div/>", {
					                        "class":"jsn-modal-indicator",
					                        "style":"display:block"
					                    })).addClass("jsn-loading-page");
					                    $(this).find(".help-block").remove();

					                    $("#jsn-form-target").remove();
					                    $(selfsubmit).find(\'.message-contactform\').html("");
					                    var iframe = $(\'<iframe/>\', {
					                        name:\'jsn-form-target\',
					                        id:\'jsn-form-target\'
					                    });
					                    iframe.appendTo($(\'body\'));
					                    iframe.css({
					                        display:\'none\'
					                    });
					                    var publickey = $(this).find(".form-captcha").attr("publickey");
					                    iframe.load(function () {
					                        var message = iframe.contents().find("input[name$=message]").val();
					                        var error = iframe.contents().find("input[name$=error]").val();

					                        var redirect = iframe.contents().find("input[name$=redirect]").val();
					                        if (redirect) {
					                            window.location = redirect;
					                        } else if (error) {
					                            error = $.parseJSON(error);
					                            self.callMessageError(formname, error);
					                            self.createRecaptcha(selfsubmit, publickey, error);
					                            $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                        } else if (message) {
					                            $.ajax({
					                                type:"GET",
					                                async:true,
					                                encoding:"UTF-8",
					                                scriptCharset:"utf-8",
					                                cache:false,
					                                contentType:"text/plain; charset=UTF-8",
					                                url:baseUrl + "/?wr-cf-gadget=contactform-frontend&action=default&task=form.getHtmlForm&form_id=" + $(selfsubmit).find("input[name=form_id]").val(),
					                                success:function (htmlForm) {
					                                    $(selfsubmit).find(".jsn-row-container").empty();
					                                    $(selfsubmit).find(".jsn-row-container").html(htmlForm);
					                                    if (message) {
					                                        $(selfsubmit).find(\'.message-contactform\').html(
					                                            $("<div/>", {
					                                                "class":"success-contactform alert alert-success clearfix"
					                                            }).append(
					                                                $("<button/>", {
					                                                    "class":"close",
					                                                    "onclick":"return false;",
					                                                    "data-dismiss":"alert",
					                                                    text:"×"
					                                                })).append(message));
					                                    }
					                                    self.initJSNForm(formname);
					                                    var messagesFocus = $(formname).find(".message-contactform")[0];
					                                    $(window).scrollTop($(messagesFocus).offset().top - 50);
					                                    setTimeout( function() {
					                                        self.createRecaptcha(selfsubmit, publickey, error);
					                                        $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                                    }, 1000 );
					                                    $(".jsn-form-content, .form-actions").hide(200);
					                                }
					                            });
					                        } else {
					                            $.ajax({
					                                type:"GET",
					                                async:true,
					                                cache:false,
					                                encoding:"UTF-8",
					                                scriptCharset:"utf-8",
					                                contentType:"text/plain; charset=UTF-8",
					                                url:baseUrl + "/?wr-cf-gadget=contactform-frontend&action=default&task=form.getHtmlForm&form_id=" + $(selfsubmit).find("input[name=form_id]").val(),
					                                success:function (htmlForm) {
					                                    $(selfsubmit).find(".jsn-row-container").empty();
					                                    $(selfsubmit).find(".jsn-row-container").html(htmlForm);
					                                    self.initJSNForm(formname);
					                                    var messagesFocus = $(formname).find(".message-contactform")[0];
					                                    $(window).scrollTop($(messagesFocus).offset().top - 50);
					                                    setTimeout( function() {
					                                        self.createRecaptcha(selfsubmit, publickey, error);
					                                        $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
					                                    }, 1000 );
					                                    $(".jsn-form-content, .form-actions").hide(200);
					                                }
					                            });
					                        }
					                    });

					                    self.checkPage(formname);
					                    $(this).attr(\'target\', \'jsn-form-target\');
					                } else {

					                    return false;
					                }
					            });';
		$filterFunctionInit[ 'validate-field-number' ] = '$(formname).find("input.number,input.phone,input.currency").each(function () {
					                $(this).keypress(function (e) {
					                    if (e.which != 45 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					                        return false;
					                    }
					                });
					            });';
		$filterFunctionInit[ 'daterangepicker' ] = '$(formname).find("input.wr-daterangepicker").each(function () {
					                var dateSettings = $.parseJSON($(this).attr("date-settings"));
					                if (dateSettings) {
					                    var yearRangeList = [];
					                    if (dateSettings.yearRangeMin && dateSettings.yearRangeMax) {
					                        yearRangeList.push(dateSettings.yearRangeMin);
					                        yearRangeList.push(dateSettings.yearRangeMax);
					                    } else if (dateSettings.yearRangeMin) {
					                        yearRangeList.push(dateSettings.yearRangeMin);
					                        yearRangeList.push((new Date).getFullYear());
					                    } else if (dateSettings.yearRangeMax) {
					                        yearRangeList.push(dateSettings.yearRangeMax);
					                        yearRangeList.push((new Date).getFullYear());
					                    }
					                    var yearRange = "1930:+0";
					                    if (yearRangeList.length) {
					                        yearRange = yearRangeList.join(":");
					                    }
					                    var dateOptionFormat = "";
					                    if (dateSettings.dateOptionFormat == "custom") {
					                        dateOptionFormat = dateSettings.customFormatDate;
					                    } else {
					                        dateOptionFormat = dateSettings.dateOptionFormat;
					                    }
					                    if (dateSettings.dateFormat == "1" && dateSettings.timeFormat == "1") {
					                        $(this).datetimepicker({
					                            changeMonth:true,
					                            changeYear:true,
					                            showOn:"button",
					                            yearRange:yearRange,
					                            dateFormat:dateOptionFormat,
					                            timeFormat:dateSettings.timeOptionFormat,
					                            timeText:"",
					                            hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
					                            minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
					                            closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
					                            prevText:lang[\'Prev\'],
					                            nextText:lang[\'Next\'],
					                            currentText:lang[\'Today\'],
					                            monthNames:[lang[\'January\'],
					                                lang[\'February\'],
					                                lang[\'March\'],
					                                lang[\'April\'],
					                                lang[\'May\'],
					                                lang[\'June\'],
					                                lang[\'July\'],
					                                lang[\'August\'],
					                                lang[\'September\'],
					                                lang[\'October\'],
					                                lang[\'November\'],
					                                lang[\'December\']],
					                            monthNamesShort:[lang[\'Jan\'],
					                                lang[\'Feb\'],
					                                lang[\'Mar\'],
					                                lang[\'Apr\'],
					                                lang[\'May\'],
					                                lang[\'Jun\'],
					                                lang[\'Jul\'],
					                                lang[\'Aug\'],
					                                lang[\'Sep\'],
					                                lang[\'Oct\'],
					                                lang[\'Nov\'],
					                                lang[\'Dec\']],
					                            dayNames:[lang[\'Sunday\'],
					                                lang[\'Monday\'],
					                                lang[\'Tuesday\'],
					                                lang[\'Wednesday\'],
					                                lang[\'Thursday\'],
					                                lang[\'Friday\'],
					                                lang[\'Saturday\']],
					                            dayNamesShort:[lang[\'Sun\'],
					                                lang[\'Mon\'],
					                                lang[\'Tue\'],
					                                lang[\'Wed\'],
					                                lang[\'Thu\'],
					                                lang[\'Fri\'],
					                                lang[\'Sat\']],
					                            dayNamesMin:[lang[\'Su\'],
					                                lang[\'Mo\'],
					                                lang[\'Tu\'],
					                                lang[\'We\'],
					                                lang[\'Th\'],
					                                lang[\'Fr\'],
					                                lang[\'Sa\']],
					                            weekHeader:lang[\'Wk\']
					                        });
					                    } else if (dateSettings.dateFormat == "1") {
					                        $(this).datepicker({
					                            changeMonth:true,
					                            changeYear:true,
					                            showOn:"button",
					                            yearRange:yearRange,
					                            dateFormat:dateOptionFormat,
					                            hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
					                            minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
					                            closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
					                            prevText:lang[\'Prev\'],
					                            nextText:lang[\'Next\'],
					                            currentText:lang[\'Today\'],
					                            monthNames:[lang[\'January\'],
					                                lang[\'February\'],
					                                lang[\'March\'],
					                                lang[\'April\'],
					                                lang[\'May\'],
					                                lang[\'June\'],
					                                lang[\'July\'],
					                                lang[\'August\'],
					                                lang[\'September\'],
					                                lang[\'October\'],
					                                lang[\'November\'],
					                                lang[\'December\']],
					                            monthNamesShort:[lang[\'Jan\'],
					                                lang[\'Feb\'],
					                                lang[\'Mar\'],
					                                lang[\'Apr\'],
					                                lang[\'May\'],
					                                lang[\'Jun\'],
					                                lang[\'Jul\'],
					                                lang[\'Aug\'],
					                                lang[\'Sep\'],
					                                lang[\'Oct\'],
					                                lang[\'Nov\'],
					                                lang[\'Dec\']],
					                            dayNames:[lang[\'Sunday\'],
					                                lang[\'Monday\'],
					                                lang[\'Tuesday\'],
					                                lang[\'Wednesday\'],
					                                lang[\'Thursday\'],
					                                lang[\'Friday\'],
					                                lang[\'Saturday\']],
					                            dayNamesShort:[lang[\'Sun\'],
					                                lang[\'Mon\'],
					                                lang[\'Tue\'],
					                                lang[\'Wed\'],
					                                lang[\'Thu\'],
					                                lang[\'Fri\'],
					                                lang[\'Sat\']],
					                            dayNamesMin:[lang[\'Su\'],
					                                lang[\'Mo\'],
					                                lang[\'Tu\'],
					                                lang[\'We\'],
					                                lang[\'Th\'],
					                                lang[\'Fr\'],
					                                lang[\'Sa\']],
					                            weekHeader:lang[\'Wk\']
					                        });
					                    } else if (dateSettings.timeFormat == "1") {
					                        $(this).timepicker({
					                            showOn:"button",
					                            timeText:"",
					                            timeFormat:dateSettings.timeOptionFormat,
					                            hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
					                            minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
					                            closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
					                            prevText:lang[\'Prev\'],
					                            nextText:lang[\'Next\'],
					                            currentText:lang[\'Today\'],
					                            monthNames:[lang[\'January\'],
					                                lang[\'February\'],
					                                lang[\'March\'],
					                                lang[\'April\'],
					                                lang[\'May\'],
					                                lang[\'June\'],
					                                lang[\'July\'],
					                                lang[\'August\'],
					                                lang[\'September\'],
					                                lang[\'October\'],
					                                lang[\'November\'],
					                                lang[\'December\']],
					                            monthNamesShort:[lang[\'Jan\'],
					                                lang[\'Feb\'],
					                                lang[\'Mar\'],
					                                lang[\'Apr\'],
					                                lang[\'May\'],
					                                lang[\'Jun\'],
					                                lang[\'Jul\'],
					                                lang[\'Aug\'],
					                                lang[\'Sep\'],
					                                lang[\'Oct\'],
					                                lang[\'Nov\'],
					                                lang[\'Dec\']],
					                            dayNames:[lang[\'Sunday\'],
					                                lang[\'Monday\'],
					                                lang[\'Tuesday\'],
					                                lang[\'Wednesday\'],
					                                lang[\'Thursday\'],
					                                lang[\'Friday\'],
					                                lang[\'Saturday\']],
					                            dayNamesShort:[lang[\'Sun\'],
					                                lang[\'Mon\'],
					                                lang[\'Tue\'],
					                                lang[\'Wed\'],
					                                lang[\'Thu\'],
					                                lang[\'Fri\'],
					                                lang[\'Sat\']],
					                            dayNamesMin:[lang[\'Su\'],
					                                lang[\'Mo\'],
					                                lang[\'Tu\'],
					                                lang[\'We\'],
					                                lang[\'Th\'],
					                                lang[\'Fr\'],
					                                lang[\'Sa\']],
					                            weekHeader:lang[\'Wk\']
					                        });
					                    } else {
					                        $(this).datepicker({
					                            changeMonth:true,
					                            changeYear:true,
					                            yearRange:yearRange,
					                            showOn:"button",
					                            hourText:lang[\'WR_CONTACTFORM_DATE_HOUR_TEXT\'],
					                            minuteText:lang[\'WR_CONTACTFORM_DATE_MINUTE_TEXT\'],
					                            closeText:lang[\'WR_CONTACTFORM_DATE_CLOSE_TEXT\'],
					                            prevText:lang[\'Prev\'],
					                            nextText:lang[\'Next\'],
					                            currentText:lang[\'Today\'],
					                            monthNames:[lang[\'January\'],
					                                lang[\'February\'],
					                                lang[\'March\'],
					                                lang[\'April\'],
					                                lang[\'May\'],
					                                lang[\'June\'],
					                                lang[\'July\'],
					                                lang[\'August\'],
					                                lang[\'September\'],
					                                lang[\'October\'],
					                                lang[\'November\'],
					                                lang[\'December\']],
					                            monthNamesShort:[lang[\'Jan\'],
					                                lang[\'Feb\'],
					                                lang[\'Mar\'],
					                                lang[\'Apr\'],
					                                lang[\'May\'],
					                                lang[\'Jun\'],
					                                lang[\'Jul\'],
					                                lang[\'Aug\'],
					                                lang[\'Sep\'],
					                                lang[\'Oct\'],
					                                lang[\'Nov\'],
					                                lang[\'Dec\']],
					                            dayNames:[lang[\'Sunday\'],
					                                lang[\'Monday\'],
					                                lang[\'Tuesday\'],
					                                lang[\'Wednesday\'],
					                                lang[\'Thursday\'],
					                                lang[\'Friday\'],
					                                lang[\'Saturday\']],
					                            dayNamesShort:[lang[\'Sun\'],
					                                lang[\'Mon\'],
					                                lang[\'Tue\'],
					                                lang[\'Wed\'],
					                                lang[\'Thu\'],
					                                lang[\'Fri\'],
					                                lang[\'Sat\']],
					                            dayNamesMin:[lang[\'Su\'],
					                                lang[\'Mo\'],
					                                lang[\'Tu\'],
					                                lang[\'We\'],
					                                lang[\'Th\'],
					                                lang[\'Fr\'],
					                                lang[\'Sa\']],
					                            weekHeader:lang[\'Wk\']
					                        });
					                    }
					                    $("button.ui-datepicker-trigger").addClass("btn btn-icon").html($("<i/>", {
					                        "class":"icon-calendar"
					                    }));
					                }
					            });';
		$filterFunctionInit = apply_filters( 'wr_contactform_frontend_javascript_function_init', $filterFunctionInit );
		$functionForm = array();
		$functionForm[ 'initJSNForm' ] = '$.initJSNForm = function (formname) {
					            var self = this;
					            $(".form-captcha").hide();
					            if ($(\'.wr-contactform .icon-question-sign\').length) {
					                $(\'.wr-contactform .icon-question-sign\').tipsy({
					                    gravity:\'w\',
					                    fade:true
					                });
					            }
					            $(formname).find("input,button.btn,textarea,select").focus(function () {
					                var form = $(this).parents(\'form:first\');
					                $(form).find(".ui-state-highlight").removeClass("ui-state-highlight");
					                $(this).parents(".control-group").addClass("ui-state-highlight");
					                self.captcha(form);
					            }).click(function (e) {
					                    var form = $(this).parents(\'form:first\');
					                    $(form).find(".ui-state-highlight").removeClass("ui-state-highlight");
					                    $(this).parents(".control-group").addClass("ui-state-highlight");
					                    e.stopPropagation();
					                });
					           $(formname).find("input").keypress(function (e) {
					                if (e.which == 13) {
					                    if ($(formname).find("button.next").hasClass("hide")) {
					                        $(formname).find("button.jsn-form-submit").click();
					                    } else {
					                        $(formname).find("button.next").click();
					                    }
					                    return false;
					                }
					            });
					            ' . implode( '', $filterFunctionInit ) . '


					            var formDefaultCaptcha = $(".form-captcha")[0];
					            if ($(formDefaultCaptcha).size()) {
					                $($(formDefaultCaptcha).parents("form:first").find("input,textarea,select")[0]).focus();
					            }
					            var randomizeListGroups = $(formname).find("select.list");
					            randomizeListGroups.each(function () {
					                if ($(this).hasClass("list-randomize")) {
					                    self.randomValueItems(this);
					                }
					            });
					            var randomizeDropdownGroups = $(formname).find("select.dropdown");
					            randomizeDropdownGroups.each(function () {
					                var selfDropdown = this;
					                if ($(this).hasClass("dropdown-randomize")) {
					                    self.randomValueItems(this);
					                    $(this).find("option").each(function () {
					                        if ($(this).attr("selectdefault") == "true") {
					                            $(this).prop("selected", true);
					                        }
					                    });
					                }
					                $(this).change(function () {
					                    if ($(this).val() == "Others" || $(this).val() == "others") {
					                        $(selfDropdown).parent().find("textarea.wr-dropdown-Others").removeClass("hide");
					                    } else {
					                        $(selfDropdown).parent().find("textarea.wr-dropdown-Others").addClass("hide");
					                    }
					                });
					            });
					            var randomizeChoiceGroups = $(formname).find("div.choices");
					            randomizeChoiceGroups.each(function () {
					                var selfChoices = this;
					                if ($(this).hasClass("choices-randomize")) {
					                    self.randomValueItems(this);
					                }
					                $(this).find("input[type=radio]").click(function () {
					                    if ($(this).val() == "Others" || $(this).val() == "others") {
					                        $(selfChoices).find("textarea.wr-value-Others").removeAttr("disabled");
					                    } else {
					                        $(selfChoices).find("textarea.wr-value-Others").attr("disabled", "true");
					                    }
					                });
					            });
					            var randomizeCheckboxGroups = $(formname).find("div.checkboxes");
					            randomizeCheckboxGroups.each(function () {
					                var selfChexbox = this;
					                if ($(this).hasClass("checkbox-randomize")) {
					                    self.randomValueItems(this);
					                }
					                $(this).find(".lbl-allowOther input[type=checkbox]").click(function () {
					                    if ($(this).is(\':checked\')) {
					                        $(selfChexbox).find("textarea.wr-value-Others").removeAttr("disabled");
					                    } else {
					                        $(selfChexbox).find("textarea.wr-value-Others").attr("disabled", "true");
					                    }
					                });
					            });

					            $(formname).find("div.choices .jsn-column-item input").change(function () {
					                if ($(this).is(\':checked\')) {
					                    var idField = $(this).parents(".jsn-columns-container").attr("id");
					                    $(formname).find("div.control-group." + idField).removeAttr("style").find("input,select,textarea").removeAttr("disabled");
					                    self.getActionField(formname, $(this), idField);
					                }
					            }).trigger("change");
					            $(formname).find("div.checkboxes .jsn-column-item input").change(function () {
					                var idField = $(this).parents(".jsn-columns-container").attr("id");
					                $(formname).find("div.control-group." + idField).removeAttr("style").find("input,select,textarea").removeAttr("disabled");
					                $(this).parents(".jsn-columns-container").find("input").each(function () {
					                    if ($(this).is(\':checked\')) {
					                        self.getActionField(formname, $(this), idField);
					                    }
					                });
					            }).trigger("change");
					            $(formname).find("select.dropdown").change(function () {
					                var idField = $(this).attr("id");
					                $(formname).find("div.control-group." + idField).removeAttr("style").find("input,select,textarea").removeAttr("disabled");
					                self.getActionField(formname, $(this), idField);
					            }).trigger("change");
					            $(formname).find("input.limit-required,textarea.limit-required").each(function () {
					                var settings = $(this).attr("data-limit");
					                var limitSettings = $.parseJSON(settings);
					                if (limitSettings) {
					                    $(this).keypress(function (e) {
					                            if (e.which != 27 && e.which != 13 && e.which != 8) {
					                                if (limitSettings.limitType == "Characters" && $(this).val().length == limitSettings.limitMax) {
					                                    alert(lang[\'The information cannot contain more than\'] + " " + limitSettings.limitMax + " Characters");
					                                    return false;
					                                }
					                                if (limitSettings.limitType == "Words") {
					                                    var lengthValue = $.trim($(this).val() + String.fromCharCode(e.which)).split(/[\s]+/);
					                                    if (lengthValue.length > limitSettings.limitMax && e.which != 0) {
					                                        alert(lang[\'The information cannot contain more than\'] + " " + limitSettings.limitMax + " Words");
					                                        return false;
					                                    }
					                                }
					                            }
					                        }
					                    );
					                }
					            });
					            $(formname).find("input,textarea").bind(\'change\', function () {
					                self.checkValidateForm($(this).parents(".control-group"), "detailInput", $(this), "onchange");
					            });

					            $(formname).find(".form-actions .prev").click(function () {
					                $(formname).find("div.jsn-form-content").each(function (i) {
					                    if (!$(this).is(\':hidden\')) {
					                        self.prevpaginationPage(formname);
					                        return false;
					                    }
					                });
					            });

					            $(formname).find(".form-actions .next").click(function () {
					                $(formname).find("div.jsn-form-content").each(function (i) {
					                    if (!$(this).is(\':hidden\')) {
					                        if (self.checkValidateForm($(this))) {
					                            self.nextpaginationPage(formname);
					                        }
					                        return false;
					                    }
					                });
					            });
					            $(formname).find(".form-actions .reset").click(function () {
					                $(formname).trigger("reset");
					                $(formname).find(".error").removeClass("error").find(".help-block").remove();
					                $(formname).find(".jsn-form-content").addClass("hide");
					                $(formname).find(".jsn-form-content").each(function (i, _formContent) {
					                    if (i == 0) {
					                        $(_formContent).removeClass("hide");
					                    }
					                });
					                self.checkPage(formname);
					            });
					            this.defaultPage(formname);
					            $("input, textarea").placeholder();
					        };';
		$functionForm[ 'getActionField' ] = '$.getActionField = function (formname, selfInput, idField) {
					            var dataSettings = $(selfInput).parents(".control-group").attr("data-settings");
					            if (dataSettings) {
					                dataSettings = $.parseJSON(dataSettings);
					            }
					            if (dataSettings) {
					                $.each(dataSettings, function (i, item) {
					                    if ($(selfInput).val() == i) {
					                        if (item.showField) {
					                            var classShow = [];
					                            $.each(item.showField, function (j, actionField) {
					                                if (actionField) {
					                                    classShow.push(".control-group." + actionField);
					                                }
					                            });
					                            $(formname).find(classShow.join(",")).addClass(idField).show();
					                        }
					                        if (item.hideField) {
					                            var classHide = [];
					                            $.each(item.hideField, function (j, actionField) {
					                                if (actionField) {
					                                    classHide.push("div.control-group." + actionField);
					                                }
					                            });
					                            $(formname).find(classHide.join(",")).addClass(idField).hide().find("input,select,textarea").attr("disabled", "true");
					                        }
					                    }
					                });
					            }
					        };';
		$functionForm[ 'randomValueItems' ] = '$.randomValueItems = function (_this) {
					            var group = $(_this),
					                choices = group.find(\'.jsn-column-item\'),
					                otherItem = choices.filter(function () {
					                    return $(\'label.lbl-allowOther\', this).size() > 0;
					                }),
					                randomItems = choices.not(otherItem);
					            randomItems.detach();
					            otherItem.detach();
					            while (randomItems.length > 0) {
					                var index = Math.floor(Math.random() * choices.length),
					                    choice = randomItems[index];
					                if (group.find(".lbl-allowOther").size()) {
					                    group.find(".lbl-allowOther").before(choice);
					                } else {
					                    group.append(choice);
					                }
					                delete(randomItems[index]);
					                var newList = [];
					                $(randomItems).each(function (index, element) {
					                    if (element !== undefined) {
					                        newList.push(element);
					                    }
					                });
					                randomItems = newList;
					            }
					            delete(randomItems[0]);
					            if (group.find(".lbl-allowOther").size()) {
					                group.find(".lbl-allowOther").before(otherItem);
					            } else {
					                group.append(otherItem);
					            }
					            return true;
					        };';
		$functionForm[ 'captcha' ] = '$.captcha = function (form) {
					            var self = this;
					            var idcaptcha = "";
					            var idcaptcha = form.find(".form-captcha").attr("id");
					            var publickey = form.find(".form-captcha").attr("publickey");
					            if (form.find(".form-captcha").length > 0 && form.find(".form-captcha").is(\':hidden\') && idcaptcha) {
					                $(".form-captcha").hide();
					                //form.find(".form-captcha").show();
					                Recaptcha.create(publickey, idcaptcha, {
					                    theme:\'white\',
					                    tabindex:0,
					                    callback:function () {
					                        $(form).find(".form-captcha").removeClass("error");
					                        $(form).find(".form-captcha #recaptcha_area").addClass("controls");
					                        $(form).find("#recaptcha_response_field").keypress(function (e) {
					                            if (e.which == 13) {
					                                if ($(form).find("button.next").hasClass("hide")) {
					                                    $(form).find("button.jsn-form-submit").click();
					                                } else {
					                                   $(form).find("button.next").click();
					                                }
					                                return false;
					                            }
					                        });
					                        $(form).find(".form-captcha").show();
					                    }
					                });
					            }
					        };
					        $.createRecaptcha = function (selfsubmit, publickey, error) {
					            var idcaptcha;
					            idcaptcha = $(selfsubmit).find(".form-captcha").attr("id");
					            if (idcaptcha) {
					                Recaptcha.destroy();
					                Recaptcha.create(publickey, idcaptcha, {
					                    theme:\'white\',
					                    tabindex:0,
					                    callback:function () {
					                        $(selfsubmit).find(".form-captcha").removeClass("error");
					                        $(selfsubmit).find(".form-captcha #recaptcha_area").addClass("controls");
					                        $(selfsubmit).find("#recaptcha_response_field").keypress(function (e) {
					                            if (e.which == 13) {
					                                if ($(selfsubmit).find("button.next").hasClass("hide")) {
					                                    $(selfsubmit).find("button.jsn-form-submit").click();
					                                } else {
					                                    $(selfsubmit).find("button.next").click();
					                                }
					                                return false;
					                            }
					                        });
					                        if (error) {
					                            if (error.captcha) {
					                                $(selfsubmit).find(".form-captcha").addClass("error");
					                                $(selfsubmit).find(".form-captcha #recaptcha_area").append(
					                                    $("<span/>", {
					                                        "class":"help-block"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:error.captcha
					                                        })));
					                                $(selfsubmit).find("#recaptcha_response_field").focus();
					                            }
					                        }
					                    }
					                });
					            }
					        };';
		$filterCheckFieldError = array();
		$filterCheckFieldError[ 'default' ] = 'if (key != "captcha") {
					                    if (key == "name" || key == "address" || key == "date" || key == "phone" || key == "currency" || key == "password") {
					                        $.each(value, function (i, item) {
					                            $(formname).find("input[name=password\\\\[" + i + "\\\\]\\\\[\\\\]], input[name=currency\\\\[" + i + "\\\\]\\\\[value\\\\]], input[name=phone\\\\[" + i + "\\\\]\\\\[default\\\\]], input[name=phone\\\\[" + i + "\\\\]\\\\[one\\\\]], input[name=date\\\\[" + i + "\\\\]\\\\[date\\\\]],input[name=name\\\\[" + i + "\\\\]\\\\[first\\\\]],input[name=address\\\\[" + i + "\\\\]\\\\[street\\\\]]").parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                "class":"help-block"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:item
					                                })));
					                        });
					                    } else if (key != "max-upload") {
											if (key == "captcha_2") {
					                            $(formname).find("#wr-captcha").parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                "class":"help-block"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:value
					                                })));
					                        } else {

					                            if ($(formname).find("#" + key).size()) {

					                                $(formname).find("#" + key).parents(".control-group").addClass("error").find(".controls").append($("<span/>", {
					                                    "class":"help-block"
					                                }).append(
					                                    $("<span/>", {
					                                        "class":"validation-result label label-important",
					                                        text:value
					                                    })));
					                            }
					                        }
					                    } else if (key == "max-upload") {
					                        $(formname).find(".message-contactform").html($("<div/>", {
					                            "class":"alert alert-error"
					                        }).append(value));
					                    }

					                }';
		$filterCheckFieldError = apply_filters( 'wr_contactform_frontend_javascript_check_field_error', $filterCheckFieldError );
		$functionForm[ 'callMessageError' ] = '$.callMessageError = function (formname, messageError) {
					            var self = this;
					            $.each(messageError, function (key, value) {
					                ' . implode( '', $filterCheckFieldError ) . '
					            });
					            var formError = $(formname).find(".error")[0];
					            if ($(formError).parents(".jsn-form-content").attr("data-value")) {
					                $(formname).find(".jsn-form-content").addClass("hide");
					                $(formError).parents(\'.jsn-form-content\').removeClass("hide");
					                self.checkPage(formname);
					            } else {
					                var countPage = $(formname).find("div.jsn-form-content").length;
					                if (countPage > 1) {
					                    $(formname).find("div.jsn-form-content")[countPage - 1].removeClass("hide");
					                } else {
					                    $(formname).find("div.jsn-form-content").removeClass("hide");
					                }
					                $(formname).find("input,button,textarea").focus();
					            }
					            if ($(formname).find(".error input,.error textarea,.error select").length) {
					                var fieldFocus = $(formname).find(".error")[0];
					                if ($(fieldFocus).find(".blank-required").size()) {
					                    $(fieldFocus).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        var val2 = val.replace(\' \', \'\');
					                        if (val2 == \'\' || val2 == 0) {
					                            $(window).scrollTop($(this).offset().top - 50);
					                            $(this).click();
					                            return false;
					                        }
					                    });
					                } else {
					                    var fieldFocus = $(formname).find(".error input,.error textarea,.error select")[0];
					                    $(window).scrollTop($(fieldFocus).offset().top - 50);
					                    fieldFocus.click();
					                }
					            }

					        };';
		$functionForm[ 'defaultPage' ] = '$.defaultPage = function (formname) {
					            if (forms.length < 1) {
					                this.captcha(formname);
					            }
					            $($(formname).find("div.jsn-form-content")[0]).removeClass("hide");
					            this.checkPage(formname);
					            $(formname).find("#page-loading").addClass("hide");
					            forms.push(formname);
					        };';
		$filterFunctionCheckPage = array();
		$filterFunctionCheckPage[ 'content-google-maps' ] = '$(this).find(".content-google-maps").each(function () {
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
		/* Create Filter frontend javascript check page */
		$filterFunctionCheckPage = apply_filters( 'wr_contactform_frontend_javascript_function_check_page', $filterFunctionCheckPage );
		$functionForm[ 'checkPage' ] = '$.checkPage = function (formname) {
					            $(formname).find("div.jsn-form-content").each(function (i) {

					                if (!$(this).hasClass("hide")) {
					                    if ($(this).next().attr("data-value")) {
					                        $(formname).find(".form-actions .next").removeClass("hide");
					                    } else {
					                        $(formname).find(".form-actions .next").addClass("hide");
					                    }
					                    if ($(this).prev().attr("data-value")) {
					                        $(formname).find(".form-actions .prev").removeClass("hide");
					                    } else {
					                        $(formname).find(".form-actions .prev").addClass("hide");
					                    }
					                    if (i + 1 == $(formname).find("div.jsn-form-content").length) {
					                        $(formname).find(".form-actions .next").addClass("hide");
					                        $(formname).find(".form-actions .jsn-form-submit").removeClass("hide");
					                    } else {
					                        $(formname).find(".form-actions .next").removeClass("hide");
					                        $(formname).find(".form-actions .jsn-form-submit").addClass("hide");
					                    }
					                    ' . implode( '', $filterFunctionCheckPage ) . '
					                }
					            });
					        };';
		$functionForm[ 'nextpaginationPage' ] = '$.nextpaginationPage = function (formname) {
					            var self = this;
					            $(formname).find("div.jsn-form-content").each(function () {
					                if (!$(this).hasClass("hide")) {
					                    $(this).addClass("hide");
					                    $(this).next().removeClass("hide");
					                    self.checkPage(formname);
					                    return false;
					                }
					            });
					        };';
		$functionForm[ 'prevpaginationPage' ] = '$.prevpaginationPage = function (formname) {
					            var self = this;
					           $(formname).find("div.jsn-form-content").each(function () {
					                if (!$(this).hasClass("hide")) {
					                    $(this).addClass("hide");
					                    $(this).prev().removeClass("hide");
					                    self.checkPage(formname);
					                    return false;
					                }
					            });
					        };';
		$functionForm[ 'checkValidateForm' ] = '$.checkValidateForm = function (_this, type, element, onchange) {
					            var check = 0;
					            var $inputBlank = $(_this).find(".blank-required");
					            var self = this;
					            $inputBlank.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var checkBlank = true;
					                    $(this).find(".help-blank").remove();
					                    $(this).parent().removeClass("error");
					                    $(this).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if ($(this).attr("type") == "text") {
					                                if (val2 == \'\') {
					                                    checkBlank = false;
					                                }
					                            } else {
					                                if (val2 == \'\') {
					                                    checkBlank = false;
					                                }
					                            }
					                        } else {
					                            checkBlank = false;
					                        }
					                    });
					                    if (!checkBlank) {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-blank"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'This field can not be empty, please enter required information.\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var groupBlank = $(_this).find(".group-blank-required");
					            groupBlank.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var checkGroupBlank = false;
					                    $(this).find(".help-blank").remove();
					                    $(this).parent().removeClass("error");
					                    $(this).find("input").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if (val2 != \'\') {
					                                checkGroupBlank = true;
					                            }
					                        }

					                    });
					                    if (!checkGroupBlank) {
					                        $(this).parents(".control-group").addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-blank"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'This field can not be empty, please enter required information.\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $dropdown = $(_this).find(".dropdown-required");
					            $dropdown.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-dropdown").remove();
					                    $(this).parent().removeClass("error");
					                    if ($(this).find("select").val() == "") {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-dropdown"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'This field can not be empty, please enter required information.\']
					                                })))
					                        check++;
					                    } else if ($(this).find("select option:selected").hasClass(\'lbl-allowOther\')) {
					                        var selfRadio = this;

					                        $(this).find(".wr-dropdown-Others").focusout(function () {
					                            var checkRadio = false;
					                            var valchoices = $(selfRadio).find(".wr-dropdown-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkRadio = true;
					                            }
					                            if (checkRadio) {
					                                $(selfRadio).find(".help-dropdown").remove();
					                                $(selfRadio).parent().addClass("error");
					                                $(selfRadio).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-dropdown"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'This field can not be empty, please enter required information.\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".wr-dropdown-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });
					            var $inputEmailNull = $(_this).find("input.email");
					            $inputEmailNull.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    var parentEmail = $(this).parents(".control-group");
					                    $(parentEmail).find(".help-email").remove();
					                    $(parentEmail).removeClass("error");
					                    var val = $(this).val();
					                    var filter = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/;
					                    if (!filter.test(val) && $(this).hasClass("email-required")) {
					                        $(parentEmail).addClass("error");
					                        $(this).parents(".controls").append(
					                            $("<span/>", {
					                                "class":"help-block help-email"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'The information is invalid, please correct.\']
					                                })));
					                        check++;
					                    } else if (!$(this).hasClass("email-required") && val && !filter.test(val)) {
					                        $(parentEmail).addClass("error");
					                        $(this).parents(".controls").append(
					                            $("<span/>", {
					                                "class":"help-block help-email"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'The information is invalid, please correct.\']
					                                })));
					                        check++;
					                    }
					                    if (val && filter.test(val) && $(parentEmail).find(".wr-email-confirm").hasClass("wr-email-confirm") && ($(element).hasClass("wr-email-confirm") || !$(parentEmail).hasClass("ui-state-highlight"))) {
					                        if ($(parentEmail).find(".wr-email-confirm").val() != $(this).val()) {
					                            $(parentEmail).addClass("error");
					                            $(this).parents(".controls").append(
					                                $("<span/>", {
					                                    "class":"help-block help-email"
					                                }).append(
					                                    $("<span/>", {
					                                        "class":"validation-result label label-important",
					                                        text:lang[\'Both email addresses must be the same.\']
					                                    })));
					                            check++;
					                        }
					                    }
					                }
					            });
					            var $inputWebsite = $(_this).find("input.website");
					            $inputWebsite.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).parent().find(".help-website").remove();
					                    $(this).parent().parent().removeClass("error");
					                    var val = $(this).val();
					                    var regexp = /^(https?:\/\/|ftp:\/\/|www([0-9]{0,9})?\.)?(((([a-zA-Z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
					                    if ((!regexp.test(val) && $(this).hasClass("website-required")) || (val != "" && val != "http://" && val != "https://" && !$(this).hasClass("website-required") && !regexp.test(val))) {
					                        $(this).parent().parent().addClass("error");
					                        $(this).after(
					                            $("<span/>", {
					                                "class":"help-block help-website"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'The information is invalid, please correct.\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $inputInteger = $(_this).find("input.integer-required");
					            $inputInteger.each(function () {
					                var thisGroup = $(this).parents(".control-group");
					                if (thisGroup.css("display") != "none" && !thisGroup.find("help-block").hasClass("help-blank")) {
					                    $(this).removeClass("error-invalid");
					                    thisGroup.find(".help-integer").remove();
					                    thisGroup.removeClass("error");
					                    var val = $(this).val();
					                    var regexp = /^(-[0-9])?[0-9]*$/;
					                    if (!regexp.test(val)) {
					                        $(this).addClass("error-invalid");
					                    }
										var hasError = false;
										thisGroup.find("input.integer-required").each(function() {
											if ($(this).hasClass("error-invalid")) {
												hasError = true;
											}
										});
										if (hasError) {
											thisGroup.addClass("error");
											thisGroup.find(".controls").append(
												$("<span/>", {
													"class":"help-block help-integer"
												}).append(
													$("<span/>", {
														"class":"validation-result label label-important",
														text:lang[\'The information is invalid, please correct.\']
													})
												)
											);
											check++;
										}
					                }
					            });
					            if (onchange != "onchange") {
					                var $valueLimitPassword = $(_this).find(".limit-password-required");
					                $valueLimitPassword.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var checkval = false;
					                        if ($(this).hasClass("group-blank-required")) {
					                            $(this).find("input").each(function () {
					                                var val = $(this).val();
					                                if (val) {
					                                    var val2 = val.replace(\' \', \'\');
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    checkval = true;
					                                }
					                            });
					                        }
					                        if (!checkval) {
					                            var inputPassword = $(this).find("input");
					                            var limitSettings = $.parseJSON($(inputPassword).attr("data-limit"));
					                            var checkPassword = false;
					                            if ($(this).find("input").length > 1) {
					                                $(this).parent().removeClass("error");
					                                $(this).find(".help-limit").remove();
					                                $(this).find("input").each(function () {
					                                    if ($(this).val().length < limitSettings.limitMin) {
					                                        checkPassword = true;
					                                    } else if ($(this).val().length > limitSettings.limitMax) {
					                                        checkPassword = true;
					                                    }
					                                });
					                            } else {
					                                if ($(inputPassword).val() != \'\' || $(inputPassword).val() != 0) {
					                                    $(inputPassword).parent().find(".help-limit").remove();
					                                    $(inputPassword).parent().parent().removeClass("error");
					                                    if ($(inputPassword).val().length < limitSettings.limitMin) {
					                                        checkPassword = true;
					                                    } else if ($(inputPassword).val().length > limitSettings.limitMax) {
					                                        checkPassword = true;
					                                    }
					                                }
					                            }

					                            if (checkPassword) {
					                                check++;
					                                var textLang = lang[\'The password must contain minimum %mi% and maximum %mx% character(s)\'];
					                                textLang = textLang.replace("%mi%", limitSettings.limitMin);
					                                textLang = textLang.replace("%mx%", limitSettings.limitMax);
					                                $(this).parent().addClass("error");
					                                $(this).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-limit"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:textLang
					                                        })));
					                            }
					                        }
					                    }
					                });

					                var $valueLimit = $(_this).find(".limit-required");
					                $valueLimit.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var limitSettings = $.parseJSON($(this).attr("data-limit"));
					                        var checkval = false;
					                        if ($(this).parent().hasClass("group-blank-required")) {
					                            $(this).find("input").each(function () {
					                                var val = $(this).val();
					                                if (val) {
					                                    var val2 = val.replace(\' \', \'\');
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    checkval = true;
					                                }
					                            });
					                        }
					                        if ($(this).parent().hasClass("blank-required")) {
					                            var val = $(this).val();
					                            if (val) {
					                                var val2 = val.replace(\' \', \'\');
					                                if ($(this).attr("type") == "text") {
					                                    if (val2 == \'\') {
					                                        checkval = true;
					                                    }
					                                } else {
					                                    if (val2 == \'\' || val2 == 0) {
					                                        checkval = true;
					                                    }
					                                }
					                            } else {
					                                checkval = true;
					                            }

					                        }
					                        ;
					                        if (!checkval) {
					                            $(this).parent().find(".help-limit").remove();
					                            $(this).parent().parent().removeClass("error");
					                            if (limitSettings.limitType == "Words") {
					                                //console.log($(this).parent().parent());
					                                return false;
					                                var lengthValue = $.trim($(this).val()).split(/[\s]+/);
					                                if (lengthValue.length < limitSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The information cannot contain less than\'] + " " + limitSettings.limitMin + " Words"
					                                            })));
					                                } else if (lengthValue.length > limitSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The information cannot contain more than\'] + " " + limitSettings.limitMax + " Words"
					                                            })));
					                                }
					                            } else {
					                                if ($(this).val().length < limitSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The information cannot contain less than\'] + " " + limitSettings.limitMin + " Character"
					                                            })));
					                                } else if ($(this).val().length > limitSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).after(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The information cannot contain more than\'] + " " + limitSettings.limitMax + " Character"
					                                            })));
					                                }
					                            }

					                        }
					                    }
					                });

					                var $valueNumberLimit = $(_this).find(".number-limit-required");
					                $valueNumberLimit.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        var checkval = false;
					                        if ($(this).hasClass("integer-required")) {
					                            var val = $(this).val();
					                            var regexp = /^[0-9]+$/;
					                            if (!regexp.test(val)) {
					                                checkval = true;
					                            }
					                        }
					                        if (!checkval) {
					                            var limitNumberSettings = $.parseJSON($(this).attr("data-limit"));
					                            $(this).parent().find(".help-limit").remove();
					                            $(this).parent().parent().removeClass("error");
					                            if ($(this).val() != \'\' || $(this).val() != 0) {
					                                if (parseInt($(this).val(), 10) < limitNumberSettings.limitMin) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).parent().append(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The number cannot be less than\'] + " " + limitNumberSettings.limitMin
					                                            })));
					                                } else if (parseInt($(this).val(), 10) > limitNumberSettings.limitMax) {
					                                    check++;
					                                    $(this).parent().parent().addClass("error");
					                                    $(this).parent().append(
					                                        $("<span/>", {
					                                            "class":"help-block help-limit"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'The number cannot be greater than\'] + " " + limitNumberSettings.limitMax
					                                            })));
					                                }
					                            }

					                        }
					                    }
					                });
					            }
					            var $list = $(_this).find(".list-required");
					            $list.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).parent().find(".help-list").remove();
					                    $(this).parent().removeClass("error");
					                    if (!$(this).find("select").val()) {
					                        $(this).parent().addClass("error");
					                        $(this).find("select").after(
					                            $("<span/>", {
					                                "class":"help-block help-list"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'The information is invalid, please correct.\']
					                                })));
					                        check++;
					                    }
					                }
					            });
					            var $inputchoices = $(_this).find(".choices-required");
					            $inputchoices.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-choices").remove();
					                    $(this).parent().removeClass("error");
					                    if ($(this).find("input[type=radio]:checked").length < 1) {
					                        $(this).parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-choices"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'This field can not be empty, please enter required information.\']
					                                })))
					                        check++;
					                    } else if ($(this).find("input[type=radio]:checked").hasClass(\'allowOther\') && $(this).find("input[type=radio]:checked").length == 1) {
					                        var selfRadio = this;
					                        $(this).find(".wr-value-Others").focusout(function () {
					                            var checkRadio = false;
					                            var valchoices = $(selfRadio).find(".wr-value-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkRadio = true;
					                            }
					                            if (checkRadio) {
					                                $(selfRadio).find(".help-choices").remove();
					                                $(selfRadio).parent().addClass("error");
					                                $(selfRadio).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-choices"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'This field can not be empty, please enter required information.\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".wr-value-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });
					            if (onchange != "onchange") {
					                var $inputlikert = $(_this).find(".likert-required");
					                $inputlikert.each(function () {
					                    if ($(this).parents(".control-group").css("display") != "none") {
					                        $(this).find(".help-likert").remove();
					                        $(this).parents(".control-group").removeClass("error");
					                        $(this).find("tbody tr").each(function () {
					                            if ($(this).find("input[type=radio]:checked").length < 1) {
					                                $(this).parents(".control-group").addClass("error");
					                                if (!$(this).parents(".controls").find(".help-likert").size()) {
					                                    $(this).parents(".controls").append(
					                                        $("<span/>", {
					                                            "class":"help-block help-likert"
					                                        }).append(
					                                            $("<span/>", {
					                                                "class":"validation-result label label-important",
					                                                text:lang[\'This field can not be empty, please enter required information.\']
					                                            })))
					                                }
					                                check++;
					                            }
					                        })

					                    }
					                });
					            }
					            var $inputCheckbox = $(_this).find(".checkbox-required");
					            $inputCheckbox.each(function () {
					                if ($(this).parents(".control-group").css("display") != "none") {
					                    $(this).find(".help-checkbox").remove();
					                    $(this).parent().parent().removeClass("error");
					                    if ($(this).find("input[type=checkbox]:checked").length < 1) {
					                        $(this).parent().parent().addClass("error");
					                        $(this).append(
					                            $("<span/>", {
					                                "class":"help-block help-checkbox"
					                            }).append(
					                                $("<span/>", {
					                                    "class":"validation-result label label-important",
					                                    text:lang[\'This field can not be empty, please enter required information.\']
					                                })))
					                        check++;
					                    } else if ($(this).find("input[type=checkbox]:checked").length == 1 && $(this).find("input[type=checkbox]:checked").hasClass(\'allowOther\')) {
					                        var selfCheckbox = this;
					                        $(this).find(".wr-value-Others").focusout(function () {
					                            var checkCheckbox = false;
					                            var valchoices = $(selfCheckbox).find(".wr-value-Others").val();
					                            var valchoices2 = valchoices.replace(\' \', \'\');
					                            if (valchoices2 == \'\') {
					                                checkCheckbox = true;
					                            }
					                            if (checkCheckbox) {
					                                $(selfCheckbox).find(".help-checkbox").remove();
					                                $(selfCheckbox).parent().parent().addClass("error");
					                                $(selfCheckbox).append(
					                                    $("<span/>", {
					                                        "class":"help-block help-checkbox"
					                                    }).append(
					                                        $("<span/>", {
					                                            "class":"validation-result label label-important",
					                                            text:lang[\'This field can not be empty, please enter required information.\']
					                                        })))
					                                check++;
					                            }
					                        });
					                        if (type != "detailInput") {
					                            $(this).find(".wr-value-Others").trigger("focusout");
					                        }
					                    }
					                }
					            });

					            if (check > 0 && type != "detailInput") {
					                var fieldFocus = $(_this).find(".error")[0];
					                if ($(fieldFocus).find(".blank-required").size()) {
					                    $(fieldFocus).find("input,select,textarea").each(function () {
					                        var val = $(this).val();
					                        if (val) {
					                            var val2 = val.replace(\' \', \'\');
					                            if (val2 == \'\' || val2 == 0) {
					                                $(window).scrollTop($(this).offset().top - 50);
					                                $(this).focus();
					                                $(this).click();
					                                return false;
					                            }
					                        } else {
					                            $(window).scrollTop($(this).offset().top - 50);
					                            $(this).focus();
					                            $(this).click();
					                            return false;
					                        }

					                    })
					                } else {
					                    var fieldFocus = $(_this).find(".error input,.error textarea,.error select")[0];
					                    $(window).scrollTop($(fieldFocus).offset().top - 50);
					                    $(fieldFocus).focus();
					                }
					                return false;
					            }

					            if (check > 0 && type == "detailInput") {
					                return false;
					            }
					            return true;
					        };';
		$functionForm[ 'getBoxStyle' ] = '$.getBoxStyle = function (element) {
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
					        };';
		$functionForm[ 'jsnLoadForm' ] = 'function jsnLoadForm($) {
					            $(".wr-contactform").each(function () {
					                if ($(this).attr("data-form-name")) {
					                    var getLang = $(this).find("span.wr-language").attr("data-value");
					                    baseUrl = $(this).find("span.wr-base-url").attr("data-value");
					                    if (getLang) {
					                        lang = $.parseJSON(getLang);
					                    }

					                    $.initJSNForm($(this));
					                }
					            });
					        }';
		$functionForm = apply_filters( 'wr_contactform_frontend_function_js_form', $functionForm );
		$javascript = '(function ($) {
					    $(function () {
					        var lang = null, forms = [], baseUrl = "";
							' . implode( '', $functionForm ) . '
							jQuery(document).ready(jsnLoadForm($));
					    });
					})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
