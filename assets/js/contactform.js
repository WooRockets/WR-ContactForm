/*------------------------------------------------------------------------
 # Full Name of WR ContactForm
 # ------------------------------------------------------------------------
 # author    woorockets.com Team
 # copyright Copyright (C) 2012 woorockets.com. All Rights Reserved.
 # Websites: http://www.woorockets.com
 # Technical Support:  Feedback - http://www.woorockets.com/contact-us/get-support.html
 # @license - GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 # @version $Id: emailAddresses.js 14957 2012-08-10 11:47:52Z thailv $
 -------------------------------------------------------------------------*/
(function ($) {
    function JSNContactform(params) {
        this.params = params;
        this.lang = params.language;
        this.init();
    }

    var listemail = []
    JSNContactform.prototype = {
        init:function () {

            this.showDivAddEmail = $("#show-div-add-email");
            this.addMoreEmail = $('#addMoreEmail');
            this.inputNewEmail = $("#input_new_email");
            this.spanEmailAddress = $("span.email-address");
            this.inputEditEmail = $(".input-editemail");
            this.btnDelEmail = $("#emailAddresses .element-delete");
            this.btnEditEmail = $(".element-edit");
            this.btnSaveEmail = $("#add-email");
            this.btnCustomizeEmail = $("#jsnconfig-email-notification-field #btn_email_list");
            this.btnCustomizeEmailList = $("#form-action #btn_email_list");
            this.btnCustomizeEmailSubmit = $("#btn_email_submit");
            this.visualDesign = new JSNVisualDesign('#form-container', this.params);

            var self = this;
            $('.wr-label-des-tipsy').tipsy({
                gravity:'w',
                fade:true
            });
            //Action
            this.btnCustomizeEmail.click(function () {
                self.createModalCustomizeEmail();
            });
            this.btnCustomizeEmailList.click(function () {
                self.createModalEmailList();
            });
            this.btnCustomizeEmailSubmit.click(function () {
                self.createModalEmailSubmit();
            });
            //Action Email notification
            this.showDivAddEmail.click(function (e) {
                e.stopPropagation();
                self.inputNewEmail.val('');
                self.addMoreEmail.show();
                self.inputNewEmail.focus();
                $(this).hide();
            });

            self.inputNewEmail.click(function (e) {
                e.stopPropagation();
            }).bind('keypress', function (e) {
                    if (e.keyCode == 13) {
                        self.saveEmail('new', $(this).val());
                        return false;
                    }
                    if (e.keyCode == 27) {
                        self.addMoreEmail.hide();
                        self.showDivAddEmail.show();
                    }
                });
            var list_email_send_to = $("#wr-form-field-list_email_send_to").val();
            if (list_email_send_to) {
                list_email_send_to = $.evalJSON(list_email_send_to);
                if (list_email_send_to) {
                    $.each(list_email_send_to, function (i, val) {
                        self.saveEmail('new', val);
                    });
                }
            }
            this.btnSaveEmail.click(function () {
                if (!self.inputNewEmail) {
                    self.inputNewEmail.focus();
                }
                self.saveEmail('new', self.inputNewEmail.val());
                return false;
            });

            this.btnEditEmail.click(function () {
                if (!$(this).parent().parent().hasClass('ui-state-edit')) {
                    self.editEmail($(this).parent().parent());
                }
            });

            this.btnDelEmail.click(function () {
                self.removeByValue(listemail, $(this).attr('data-email'));
                $(this).parent().parent().remove();
            });
            // close modal box
            $.closeModalBox = function () {
                self.jsnContactformModal.close();
                $(".jsn-modal").remove();
            }
            $(document).click(function () {
                self.addMoreEmail.hide();
                self.showDivAddEmail.show();
            });
        },
        //Create modal box Customize Email
        createModalCustomizeEmail:function () {
            var self = this;
            var buttons = {};
            buttons["Save"] = $.proxy(function () {
                this.jsnContactformModal.iframe[0].contentWindow.jQuery.save();
            }, this);
            buttons["Cancel"] = $.proxy(function () {
                $.closeModalBox();
            }, this);
            this.jsnContactformModal = new JSNModal({
                url:self.params.baseUrl + '?wr-cf-gadget=contactform-email-settings&layout=config&tmpl=component&action=default&email=1&control=config',
                title:this.lang['Edit email content being sent to specified address(es)'],
                buttons:buttons,
                height:600,
                width:850,
                scrollable:true
            });
            this.jsnContactformModal.show();
        },
        //Create modal box config contet send email list
        createModalEmailList:function () {
            var self = this;
            JSNVisualDesign.savePage();
            $('#jform_form_content').val(this.visualDesign.serialize());
            var buttons = {};
            buttons["Save"] = $.proxy(function () {
                var data = {}, attach = [], iframe = $(this.jsnContactformModal.iframe[0]).contents();
                data.from = $(iframe).find("#jform_template_from").val();
                data.reply = $(iframe).find("#jform_template_reply_to").val();
                data.subject = $(iframe).find("#jform_template_subject").val();
                data.message = $(iframe).find("#jform_template_message").val();
                $(iframe).find("#attach-file .jsn-item input[type=checkbox]").each(function () {
                    if ($(this).is(':checked')) {
                        attach.push($(this).val());
                    }
                });
                data.attach = attach;
                $("#wr-form-field-content_email_send_to").val($.toJSON(data));
                $.closeModalBox();
                //this.jsnContactformModal.iframe[0].contentWindow.save();
            }, this);
            buttons["Cancel"] = $.proxy(function () {
                $.closeModalBox();
            }, this);
            this.jsnContactformModal = new JSNModal({
                url:self.params.baseUrl + '?wr-cf-gadget=contactform-email-settings&email=1&action=default&control=form&form_id=' + $("#jform_form_id").val(),
                title:this.lang['Edit email content being sent to specified address(es)'],
                buttons:buttons,
                height:750,
                width:850,
                scrollable:true
            });
            this.jsnContactformModal.show();
        },
        //Create modal box config contet send email submit
        createModalEmailSubmit:function () {
            var self = this;
            JSNVisualDesign.savePage();
            $('#jform_form_content').val(this.visualDesign.serialize());
            var buttons = {};
            buttons["Save"] = $.proxy(function () {
                var data = {}, attach = [], iframe = $(this.jsnContactformModal.iframe[0]).contents();
                data.from = $(iframe).find("#jform_template_from").val();
                data.from = $(iframe).find("#jform_template_from").val();
                data.reply = $(iframe).find("#jform_template_reply_to").val();
                data.subject = $(iframe).find("#jform_template_subject").val();
                data.message = $(iframe).find("#jform_template_message").val();
                $(iframe).find("#attach-file .jsn-item input[type=checkbox]").each(function () {
                    if ($(this).is(':checked')) {
                        attach.push($(this).val());
                    }
                });
                data.attach = attach;
                $("#wr-form-field-content_email_send_to_submitter").val($.toJSON(data));
                $.closeModalBox();
                //this.jsnContactformModal.iframe[0].contentWindow.save();
            }, this);
            buttons["Cancel"] = $.proxy(function () {
                $.closeModalBox();
            }, this);
            this.jsnContactformModal = new JSNModal({
                url:self.params.baseUrl + '?wr-cf-gadget=contactform-email-settings&email=0&action=default&control=form&form_id=' + $("#jform_form_id").val(),
                title:this.lang['Email content being sent to form submitter'],
                buttons:buttons,
                height:750,
                width:850,
                scrollable:true
            });
            this.jsnContactformModal.show();
        },
        //Edit email
        editEmail:function (_this) {

            var idEmail = $(_this).attr('id');
            var self = this;
            var liEdit = $("#" + idEmail);
            $('#emailAddresses div').removeClass('ui-state-edit');
            $("#emailAddresses .input-editemail").remove();
            $("#emailAddresses span.email-address").show();
            this.inputEditEmail.remove();
            this.spanEmailAddress.show();
            liEdit.find(".input-editemail").remove();
            liEdit.find("span.email-address").show();
            liEdit.append(
                $('<div/>', {
                    'class':'input-editemail'
                }).append(
                    $("<div/>", {
                        "class":"control-group"
                    }).append(
                        $('<input/>', {
                            type:'text',
                            value:_this.attr('data-email'),
                            "class":"jsn-input-fluid"
                        })).append(
                        $("<button/>", {
                            "class":"btn btn-icon input-add",
                            "onclick":"return false;",
                            "title":self.lang['WR_CONTACTFORM_BUTTON_SAVE']
                        }).append(
                            $("<i/>", {
                                "class":"icon-ok"
                            }))).append(
                        $("<button/>", {
                            "class":"btn btn-icon input-cancel",
                            "onclick":"return false;",
                            "title":self.lang['Cancel']
                        }).append(
                            $("<i/>", {
                                "class":"icon-remove"
                            }))))).addClass("ui-state-edit");
            liEdit.find("span.email-address").hide();
            liEdit.find(".input-add").click(function (e) {
                if (liEdit.find(".jsn-input-fluid").val()) {
                    self.saveEmail('edit', liEdit.find(".jsn-input-fluid").val(), idEmail);
                    $('#emailAddresses .jsn-item').removeClass('ui-state-edit');
                    liEdit.find(".input-editemail").hide();
                    liEdit.find("span.email-address").show()
                    e.stopPropagation();
                } else {
                    liEdit.find(".jsn-input-fluid").focus();
                    return false;
                }
            })
            liEdit.find(".jsn-input-fluid").focus().bind('keypress', function (e) {
                if (e.keyCode == 13) {
                    self.saveEmail('edit', liEdit.find(".jsn-input-fluid").val(), idEmail);
                    return false;
                }
                if (e.keyCode == 27) {
                    $('#emailAddresses  .jsn-item').removeClass('ui-state-edit');
                    self.inputEditEmail.remove();
                    self.spanEmailAddress.show();

                }
            });
            liEdit.find(".input-cancel").click(function (e) {
                $('#emailAddresses  .jsn-item').removeClass('ui-state-edit');
                liEdit.find(".input-editemail").hide();
                liEdit.find("span.email-address").show();
                e.stopPropagation();
            })
        },
        //Save email
        saveEmail:function (check, value, liIdOld) {
            var liId = value,
                self = this;

            while (/[^a-zA-Z0-9_]+/.test(liId)) {
                liId = liId.replace(/[^a-zA-Z0-9_]+/, '_');
            }
            liId = "email_" + liId;
            if (check == "new" && this.checkEmail(value)) {
                $("#emailAddresses").append(
                    $("<li/>", {
                        id:liId,
                        "data-email":value,
                        "class":"jsn-item ui-state-default jsn-iconbar-trigger"
                    })
                        .append($("<input />", {
                        type:'hidden',
                        name:'wr_contactform[list_email_send_to][]',
                        value:value
                    }))
                        .append($("<span />", {
                        "class":"email-address"
                    }).text(value)).append(
                        $("<div/>", {
                            "class":"jsn-iconbar"
                        }).append(
                            $("<a/>", {
                                "href":"javascript:void(0)",
                                "title":"Edit email",
                                "class":"element-edit",
                                "data-email":value
                            }).append('<i class="icon-pencil"></i>')).append(
                            $("<a/>", {
                                "href":"javascript:void(0)",
                                "title":"Delete email",
                                "class":"element-delete",
                                "data-email":value
                            }).append('<i class="icon-trash"></i>'))));
                this.showDivAddEmail.show();
                this.addMoreEmail.hide();
                listemail.push(this.inputNewEmail.val());
                var element = JSNVisualDesign.getBoxStyle($("#" + liId));
                //$("#emailAddresses").scrollTop(element.offset.top);
            } else if (check == "edit" && this.checkEmail(value)) {
                this.removeByValue(listemail, $("#" + liIdOld).attr('data-email'));
                listemail.push(value);
                $("#emailAddresses #" + liIdOld).before(
                    $("<li/>", {
                        id:liId,
                        "data-email":value,
                        "class":"jsn-item ui-state-default jsn-iconbar-trigger"
                    })
                        .append($("<input />", {
                        type:'hidden',
                        name:'wr_contactform[list_email_send_to][]',
                        value:value
                    }))
                        .append($("<span />", {
                        "class":"email-address"
                    }).text(value)).append(
                        $("<div/>", {
                            "class":"jsn-iconbar"
                        }).append(
                            $("<a/>", {
                                "href":"javascript:void(0)",
                                "title":"Edit email",
                                "class":"element-edit",
                                "data-email":value
                            }).append('<i class="icon-pencil"></i>')).append(
                            $("<a/>", {
                                "href":"javascript:void(0)",
                                "title":"Delete email",
                                "class":"element-delete",
                                "data-email":value
                            }).append('<i class="icon-trash"></i>'))))
                $("#emailAddresses #" + liIdOld).hide();
                $("#emailAddresses #" + liIdOld).find("input").attr("name", "remove");
                $('#emailAddresses .jsn-item').removeClass('ui-state-edit');
                this.inputEditEmail.hide();
                this.spanEmailAddress.show();
            }
            $("#" + liId).find(".element-edit").click(function (e) {
                if (!$(this).parent().parent().hasClass('ui-state-edit')) {
                    e.stopPropagation();
                    self.editEmail($(this).parent().parent());
                }
            });
            $("#" + liId).find(".element-delete").click(function () {
                self.removeByValue(listemail, $(this).attr('data-email'));
                $(this).parent().parent().remove();
            });
        },
        //Remove value in array
        removeByValue:function (arr, val) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == val) {
                    arr.splice(i, 1);
                    break;
                }
            }
        },
        //Check validate email
        checkEmail:function (val) {
            var filter = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/;
            if (!filter.test(val) || val == "") {
                return false;
            }
            if ($.inArray(val, listemail) != -1) {
                var liId = val;
                while (/[^a-zA-Z0-9_]+/.test(liId)) {
                    liId = liId.replace(/[^a-zA-Z0-9_]+/, '_');
                }
                liId = "email_" + liId;
                $("#emailAddresses").scrollTo($("#" + liId));
                $('input[value="' + val + '"]').parent().effect("highlight", {}, 3000);
                return false;
            } else {
                return true;
            }
        }
    }
    var params = {};
    params.language = $.evalJSON($("#wr_contactform_languages").val());
    params.baseUrl = $("#urlAdmin").val();
    new JSNContactform(params);

	$(function() {
		var list_email_send_to = $("#wr-form-field-list_email_send_to").val();
		if (list_email_send_to) {
			list_email_send_to = $.evalJSON(list_email_send_to);
			if (list_email_send_to) {
				$.each(list_email_send_to, function (i, val) {
					if (i == 0) $('#wr-cf-list-email-send-to').val(val);
					else $('#wr-cf-list-email-send-to').val($('#wr-cf-list-email-send-to').val() + ',' + val);
				});
			}
		}
		$('#wr-cf-list-email-send-to').css('width', '100%');
		$('#wr-cf-list-email-send-to').select2({tags:$.unique($('#wr-cf-list-email-send-to').attr('pre-value').split(","))});
		$('#wr-cf-list-email-send-to').change(function() {
			$(this).parent('.controls').find('.select2-search-choice').each(function() {
				if (!checkEmail($(this).find('div').html())) {
					$(this).addClass('wr-cf-invalid-email');
				}
			});
		}).trigger('change');

		//Check validate email
		function checkEmail(val) {
			var filter = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,6})$/;
			if (!filter.test(val) || val == "") {
				return false;
			}
			if ($.inArray(val, listemail) != -1) {
				var liId = val;
				while (/[^a-zA-Z0-9_]+/.test(liId)) {
					liId = liId.replace(/[^a-zA-Z0-9_]+/, '_');
				}
				liId = "email_" + liId;
				$("#emailAddresses").scrollTo($("#" + liId));
				$('input[value="' + val + '"]').parent().effect("highlight", {}, 3000);
				return false;
			} else {
				return true;
			}
		}
	});
})(jQuery);
