/*------------------------------------------------------------------------
 # Full Name of WR ContactForm
 # ------------------------------------------------------------------------
 # author    woorockets.com Team
 # copyright Copyright (C) 2012 woorockets.com. All Rights Reserved.
 # Websites: http://www.woorockets.com
 # Technical Support:  Feedback - http://www.woorockets.com/contact-us/get-support.html
 # @license - GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 # @version $Id: emailsettings.js 14957 2012-08-10 11:47:52Z thailv $
 -------------------------------------------------------------------------*/
(function ($) {
    $.fn.getCursorPosition = function () {
        var el = $(this).get(0);
        var pos = 0;
        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
    var JSNContactformEmailSettingsView = function (params) {
        this.params = params;
        this.lang = params.language;
        this.init();
        $("body").addClass("jsn-master");
    }
    function updateEmailNotificationData() {
        var data = {}, attach = [];
        data.from = $("#jform_template_from").val();
        data.reply = $("#jform_template_reply_to").val();
        data.subject = $("#jform_template_subject").val();
        data.message = $("#jform_template_message").val();
        $("#attach-file .jsn-item input[type=checkbox]").each(function () {
            if ($(this).is(':checked')) {
                attach.push($(this).val());
            }
        });
        data.attach = attach;
        if ($("#template_notify_to").val() == 1) {
        	parent.jQuery("#wr-form-field-content_email_send_to").val($.toJSON(data));
        } else {
        	parent.jQuery("#wr-form-field-content_email_send_to_submitter").val($.toJSON(data));
        }
    }
    JSNContactformEmailSettingsView.prototype = {
        init:function () {

            var self = this;
            var listOptionPage = [];
            var wordlist = [];
            $('.wr-label-des-tipsy').tipsy({
                gravity:'w',
                fade:true
            });
            if (parent.jQuery(".jsn-page-settings").length < 1) {
                // window.location.href = "index.php?option=com_contactform";
            }

            if ($("#template_notify_to").val() == 1) {
                var emailContent = parent.jQuery("#wr-form-field-content_email_send_to").val();
            } else {
                var emailContent = parent.jQuery("#wr-form-field-content_email_send_to_submitter").val();
            }

            if ($("#template_notify_to").val() == 0) {
                $("#jform_template_from").attr("placeholder", this.lang['e.g. Customer Department']);
                $("#jform_template_reply_to").attr("placeholder", this.lang['e.g. support@yourdomain.com']);
                $("#jform_template_subject").attr("placeholder", this.lang['e.g. Thank you for contacting us']);
            } else {
                $("#jform_template_from").attr("placeholder", this.lang['Click the button on the right to select the form field identifying submitter name']);
                $("#jform_template_reply_to").attr("placeholder", this.lang['Click the button on the right to select the form field identifying submitter email']);
                $("#jform_template_subject").attr("placeholder", this.lang['e.g. Contact inquiry']);
            }
            parent.jQuery(" ul.jsn-page-list li.page-items").each(function () {
                listOptionPage.push([$(this).find("input").attr('data-id'), $(this).find("input").attr('value')]);
            });
            $.ajax({
                type:"POST",
                dataType:'json',
                // url:"index.php?option=com_contactform&view=form&task=form.loadsessionfield&tmpl=component",
                url:"admin-ajax.php?action=wr_contactform_load_session_field",
                data:{
                    form_id:parent.jQuery("#jform_form_id").val(),
                    form_page_name:parent.jQuery("#form-design-header").attr('data-value'),
                    form_list_page:listOptionPage
                },
                success:function (response) {

                    var replyToSelect = "";
                    var liFields = "";
                    var fileAttach = "";
                    // var typeClear = ["file-upload"];
                    var defaultAttach = $("#attach-file ul").attr("data-value");
                    var dataAttach = "";
                    if (defaultAttach) {
                        dataAttach = $.evalJSON(defaultAttach);
                    }
                    if (response) {
                        $.each(response, function (i, item) {
                            if (item.type != "google-maps") {
                                if (item.type == 'email') {
                                    replyToSelect += "<li class=\"jsn-item\" id='" + item.identify + "'>" + item.options.label + "</li>";
                                }
                                if (item.type == 'file-upload') {

                                        fileAttach += '<li class="jsn-item ui-state-default"><label class="checkbox">' + item.options.label + '<input type="checkbox" name="file_attach[]" value="' + item.identify + '"></label></li>';

                                }
                                liFields += "<li class=\"jsn-item\" id='" + item.identify + "'>" + item.options.label + "</li>";
                                wordlist.push(item.options.label);
                            }
                        });
                    }
                    if ($("#template_notify_to").val() == 1) {
                        self.createListField($("#btn-select-field-from"), liFields, "FIELD");
                        self.createListField($("#btn-select-field-to"), replyToSelect, "EMAIL");
                    }
                    if (fileAttach) {
                        $("#attach-file ul").html(fileAttach);
                    }
                    self.createListField($("#btn-select-field-message"), liFields, "FIELD");
                    self.createListField($("#btn-select-field-subject"), liFields, "FIELD");

                    var Jsnwysiwyg = {
                        // required
                        name:"jsnwysiwyg",
                        methodForRealLife:function (object, text) {
                            // jQuery chain
                            return object.each(function () {
                                // standard operations
                                var Wysiwyg = $(this).data("wysiwyg");
                                if (!Wysiwyg) {
                                    return this;
                                }
                                // Plugin code
                                // Wysiwyg gives access to all methods and properties, also
                                // you can extend base functionality
                                Wysiwyg.newPropertyName = "methodForRealLife";
                                Wysiwyg.newMethodName = function () {
                                    this.setContent(this.newPropertyName + text);
                                };
                                Wysiwyg.newMethodName();
                            });
                        }
                    };
                    // Register your plugin
                    $.wysiwyg.plugin.register(Jsnwysiwyg);
                    $("#template-msg #jform_template_message").wysiwyg({
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
                                className:'h4',
                                command:($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                                arguments:($.browser.msie || $.browser.safari) ? '<h4>' : 'h4',
                                tags:['h4'],
                                tooltip:'Header 4'
                            },
                            h5:{
                                visible:false,
                                className:'h5',
                                command:($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                                arguments:($.browser.msie || $.browser.safari) ? '<h5>' : 'h5',
                                tags:['h5'],
                                tooltip:'Header 5'
                            },
                            h6:{
                                visible:false,
                                className:'h6',
                                command:($.browser.msie || $.browser.safari) ? 'formatBlock' : 'heading',
                                arguments:($.browser.msie || $.browser.safari) ? '<h6>' : 'h6',
                                tags:['h6'],
                                tooltip:'Header 6'
                            },
                            html:{ visible:true },
                            increaseFontSize:{ visible:true },
                            decreaseFontSize:{ visible:true }
                        },
                        html:'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body style="margin:0; padding:10px;">INITIAL_CONTENT</body></html>'
                    });
                    if (emailContent) {
                        emailContent = $.evalJSON(emailContent);
                        if (emailContent.from) {
                            $("#jform_template_from").val(emailContent.from);
                        }
                        if (emailContent.reply) {
                            $("#jform_template_reply_to").val(emailContent.reply);
                        }
                        if (emailContent.subject) {
                            $("#jform_template_subject").val(emailContent.subject);
                        }
                        if (emailContent.message) {
                            $("#template-msg #jform_template_message").wysiwyg("setContent",emailContent.message);
                        }
                        if (emailContent.attach) {
                            $("#attach-file .jsn-item input[type=checkbox]").each(function () {
                                if ($.inArray($(this).val(), emailContent.attach) >= 0) {
                                    $(this).attr( "checked","checked" );
                                }
                            });
                        }
                    }
                    $(".template-msg-content").css({"width":"80%"});
                    $("#wr_email_settings").removeClass("hide");
                    $("#form-loading").hide();

                    $('input, textarea').change(function() {
                    	updateEmailNotificationData();
                    });
                    $('#attach-file').click(function() {
                    	updateEmailNotificationData();
                    });
                }
            });
            $('input, textarea').placeholder();
        },
        eventField:function (field, btnField, type) {
            var self = this;
            var oldField = "";
            $(field).find(".jsn-items-list .jsn-item").click(function () {
                if (this.id) {
                    switch (type) {
                        case "btn-select-field-message":
                            $("#template-msg #jform_template_message").wysiwyg("insertText", '{$' + this.id + '}');
                            break;
                        case "btn-select-field-from":
                            $("#jform_template_from").val($("#jform_template_from").val() + "{$" + this.id + "}");
                            break;
                        case "btn-select-field-subject":
                            $("#jform_template_subject").val($("#jform_template_subject").val() + "{$" + this.id + "}");
                            break;
                        case "btn-select-field-to":
                            $("#jform_template_reply_to").val($("#jform_template_reply_to").val() + "{$" + this.id + "}");
                            break;
                    }
                    $("div.control-list-fields").hide();
                }
                updateEmailNotificationData();
            });
            $(btnField).click(function (e) {
                $("div.control-list-fields").hide();
                var elmStyle = self.getBoxStyle($(field)),
                    parentStyle = self.getBoxStyle($(this)),
                    position = {};
                position.left = parentStyle.offset.left - elmStyle.outerWidth + parentStyle.outerWidth;
                position.top = parentStyle.offset.top + parentStyle.outerHeight;
                $(field).find(".arrow").css("left", elmStyle.outerWidth - (parentStyle.outerWidth / 2));
                $(field).css(position);
                $(field).show();
                e.stopPropagation();
            });
            $("div.control-list-fields").click(function (e) {
                e.stopPropagation();
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
            $(field).find(".jsn-quicksearch-field").delayKeyup(function (el) {
                self.searchField($(el).val(), $(field).find(".jsn-items-list"));
                if ($(el).val() == "") {
                    $(field).find(".jsn-reset-search").hide();
                } else {
                    $(field).find(".jsn-reset-search").show();
                }
            }, 500)

            $(document).click(function () {
                $("div.control-list-fields").hide();
                $(field).find(".jsn-reset-search").trigger("click");
            });
        },
        // Search field in list
        searchField:function (value, resultsFilter) {
            $(resultsFilter).find("li").hide();
            if (value != "") {
                $(resultsFilter).find("li").each(function () {
                    var textField = $(this).attr("id").toLowerCase();
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
        },
        //Create list field
        createListField:function (btnInput, fields, type) {
            var self = this;
            var listField = fields;
            if (!fields) {
                listField = "<li title=\"" + self.lang["WR_CONTACTFORM_NO_" + type + "_DES"] + "\" class=\"ui-state-default ui-state-disabled\">" + self.lang["WR_CONTACTFORM_NO_" + type] + "</li>"
            }
            var dialog = $("<div/>", {
                'class':'control-list-fields jsn-bootstrap hide',
                'id':"control-" + $(btnInput).attr("id")
            }).append(
                $("<div/>", {
                    "class":"popover"
                }).css("display", "block").append($("<div/>", {
                    "class":"arrow"
                })).append($("<h3/>", {
                    "class":"popover-title",
                    "text":this.lang['Select Fields']
                })).append(
                    $("<form/>").append(
                        $("<div/>", {"class":"jsn-elementselector"}).append(
                            $("<div/>", {"class":"jsn-fieldset-filter"}).append(
                                $("<fieldset/>").append(
                                    $("<div/>", {"class":"pull-right"}).append(
                                        $("<input/>", {
                                            "type":"text",
                                            "class":"jsn-quicksearch-field input search-query",
                                            "placeholder":"Search…"
                                        }).bind('keypress', function (e) {
                                                if (e.keyCode == 13) {
                                                    return false;
                                                }
                                            })
                                    ).append(
                                        $("<a/>", {"href":"javascript:void(0);", "title":"Clear Search", "class":"jsn-reset-search"}).append($("<i/>", {"class":"icon-remove"})).click(function () {
                                            $(dialog).find(".jsn-quicksearch-field").val("");
                                            self.searchField("", $(dialog).find(".jsn-items-list"));
                                            $(this).hide();
                                        })
                                    )
                                )
                            )
                        ).append(
                            $("<ul/>", {"class":"jsn-items-list"}).append(listField)
                        )
                    )
                )
            )
            if (!fields) {
                $(dialog).find(".field-seach").hide();
            } else {
                $(dialog).find(".field-seach").show();
            }
            $(dialog).find(".jsn-quicksearch-field").attr("placeholder", "Search…");
            $(dialog).appendTo('body');
            dialog.hide();
            self.eventField("#control-" + $(btnInput).attr("id"), btnInput, $(btnInput).attr("id"));
            $(document).click(function () {
                dialog.hide();
            });
            $('input, textarea').placeholder();
        },
        getBoxStyle:function (element) {
            var display = element.css('display')
            if (display == 'none') {
                element.css({
                    display:'block',
                    visibility:'hidden'
                });
            }
            var style = {
                width:element.width(),
                height:element.height(),
                outerHeight:element.outerHeight(),
                outerWidth:element.outerWidth(),
                offset:element.offset(),
                margin:{
                    left:parseInt(element.css('margin-left')),
                    right:parseInt(element.css('margin-right')),
                    top:parseInt(element.css('margin-top')),
                    bottom:parseInt(element.css('margin-bottom'))
                },
                padding:{
                    left:parseInt(element.css('padding-left')),
                    right:parseInt(element.css('padding-right')),
                    top:parseInt(element.css('padding-top')),
                    bottom:parseInt(element.css('padding-bottom'))
                }
            };
            element.css({
                display:display,
                visibility:'visible'
            });
            return style;
        }
    }
    var params = {};
    params.language = $.evalJSON($("#wr_contactform_languages").val());
    new JSNContactformEmailSettingsView(params);
    $("html").addClass("wr-contactform-modal");
})(jQuery);
