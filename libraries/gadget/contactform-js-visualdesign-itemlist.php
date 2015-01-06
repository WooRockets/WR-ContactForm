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

class WR_CF_Gadget_Contactform_Js_Visualdesign_Itemlist extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-visualdesign-itemlist';

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

		$template = ' this.template = \'<div class="controls"><div class="jsn-buttonbar"><button id="items-list-edit" class="btn btn-small"><i class="icon-pencil"></i>Edit</button><button id="items-list-save" class="btn btn-small btn-primary"><i class="icon-ok"></i>Done</button></div>\' +
            \'<ul class="jsn-items-list ui-sortable">\' +
            \'{{each(i, val) listItems}}<li class="jsn-item ui-state-default jsn-iconbar-trigger">\' +
            \'<label class="{{if multipleCheck==true || multipleCheck=="true"}}checkbox{{else}}radio{{/if}}"><input type="{{if multipleCheck==true || multipleCheck=="true"}}checkbox{{else}}radio{{/if}}" value="${val.text}" name="item-list" {{if val.checked == "true" || val.checked == true}}checked{{/if}} />${val.text}</label>\' +
            \'{{if actionField}}<div class="jsn-iconbar"><a class="element-action-edit" href="javascript:void(0)"><i class="icon-lightning"></i></a></div>{{/if}}\' +
            \'</li>{{/each}}\' +
            \'</ul>\' +
            \'{{if allowOther}}<div class="other ui-sortable">\' +
            \'<div class="jsn-item ui-state-default">\' +
            \'<label class="{{if multipleCheck==true || multipleCheck=="true"}}checkbox{{else}}radio{{/if}}"><input type="{{if multipleCheck==true || multipleCheck=="true"}}checkbox{{else}}radio{{/if}}" disabled="disabled" value="other" />Other</label>\' +
            \'<input type="text" value="" disabled="disabled" />\' +
            \'</div>\' +
            \'</div>{{/if}}</div>\' +
            \'<input type="hidden" name="${name}" value="json:${value}" id="${id}" />\';
        };';
		$template = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_template', $template );

		$updateItems = 'var items = this.control.find(\'input[type="checkbox"],input[type="radio"]\');
            var listItems = [];
            items.each(function (index, item) {
                listItems.push({
                    text:item.value,
                    checked:item.checked
                });
            });
            //this.updateAction();
            $(\'#\' + this.options.id).val(\'json:\' + $.toJSON(listItems));
            $(\'#\' + this.options.id).trigger(\'change\');';
		$updateItems = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_update_items', $updateItems );

		$updateAction = '  var items = this.control.find(\'input[type="checkbox"],input[type="radio"]\');
            var listItems = {};
            $(".wr-action-active").remove();
            items.each(function (index, item) {
                var items = {}, checkActive = false;
                items.showField = $(this).attr("action-show-field");
                if (items.showField) {
                    items.showField = $.evalJSON(items.showField);
                    if (items.showField.length > 0) {
                        checkActive = true;
                    }
                }
                items.hideField = $(this).attr("action-hide-field");
                if (items.hideField) {
                    items.hideField = $.evalJSON(items.hideField);
                    if (items.hideField.length > 0) {
                        checkActive = true;
                    }
                }
                listItems[item.value] = items;
                if (checkActive) {
                    var jsnItem = $(item).parents(".jsn-item");
                    $(jsnItem).addClass("jsn-highlight");
                } else {
                    var jsnItem = $(item).parents(".jsn-item");
                    $(jsnItem).removeClass("jsn-highlight");
                }
            });
            $(\'#option-itemAction-hidden\').val($.toJSON(listItems));
            $(\'#option-itemAction-hidden\').trigger(\'change\');';
		$updateAction = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_update_action', $updateAction );

		$getBoxStyle = 'var display = element.css(\'display\')
            if (display == \'none\') {
                element.css({
                    display:\'block\',
                    visibility:\'hidden\'
                });
            }
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
            element.css({
                display:display,
                visibility:\'visible\'
            });
            return style;';
		$getBoxStyle = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_get_box_style', $getBoxStyle );

		$openActionSettings = '$(".wr-lock-screen").remove();
            $("body").append($("<div/>", {
                "class":"wr-lock-screen",
                "style":"z-index: 999999; display: inline;"
            }));
            var self = this;
            $("#visualdesign-options-values .jsn-items-list .jsn-item.ui-state-edit").removeClass("ui-state-edit");
            $(btnInput).parents(".jsn-item").addClass("ui-state-edit");
            $(".control-list-action").remove();
            var container = $("#wr_contactform_master #form-container"), listOptionPage = [], instance = container.data(\'visualdesign-instance\'), content = "";
            var serialize = instance.serialize(true);
            if (serialize != "" && serialize != "[]") {
                content = $.toJSON(serialize);
            }
            $(" ul.jsn-page-list li.page-items").each(function () {
                listOptionPage.push([$(this).find("input").attr(\'data-id\'), $(this).find("input").attr(\'value\')]);
            });

            var dialog = $("<div/>", {
                \'class\':\'control-list-action jsn-bootstrap\',
                \'id\':"control-action"
            }).append(
                $("<div/>", {
                    "class":"popover left"
                }).css("display", "block").append($("<div/>", {
                    "class":"arrow"
                })).append($("<h3/>", {
                    "class":"popover-title",
                    "text":"Action settings"
                })).append(
                    $("<div/>", {
                        "class":"popover-content"
                    }).append(
                        $("<div/>", {"class":"jsn-bgloading", "id":"action-loading"}).append(
                            $("<i/>", {"class":"jsn-icon32 jsn-icon-loading"})
                        )
                    ).append(
                        $("<div/>", {"id":"accordion_content", "class":"hide"}).append(
                            $("<h3/>").append(
                                $("<a/>", {"href":"#"}).append("Show form field(s)")
                            )
                        ).append(
                            $("<div/>", {"id":"wr-action-show"})
                        ).append(
                            $("<h3/>").append(
                                $("<a/>", {"href":"#"}).append("Hide form fields(s)")
                            )
                        ).append(
                            $("<div/>", {"id":"wr-action-hide"})
                        )
                    )
                )
            )
            $(dialog).appendTo(\'body\');
            var elmStyle = self.getBoxStyle($(dialog).find(".popover")),
                parentStyle = self.getBoxStyle($(btnInput)),
                position = {};
            position.left = parentStyle.offset.left - elmStyle.outerWidth;
            position.top = parentStyle.offset.top - (elmStyle.outerHeight / 2) + (parentStyle.outerHeight / 2);
            dialog.css(position).click(function (e) {
                e.stopPropagation();
            });

            $.ajax({
                type:"POST",
                dataType:\'json\',
                url:"admin-ajax.php?action=wr_contactform_save_page",
                data:{
                    form_id:$("#jform_form_id").val(),
                    form_content:content,
                    form_page_name:$("#form-design-header").attr(\'data-value\'),
                    form_list_page:listOptionPage
                },
                success:function () {
                    var listOptionPage = [];
                    var _this = this;
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
                            form_list_page:listOptionPage
                        },
                        success:function (response) {
                            var listFieldShow = $("<ul/>", {"class":"jsn-items-list"}), listFieldHide = $("<ul/>", {"class":"jsn-items-list"});
                            if (response) {
                                var actionShowField = $("#visualdesign-options-values .jsn-items-list .ui-state-edit input[name=item-list]").attr("action-show-field"),
                                    actionHideField = $("#visualdesign-options-values .jsn-items-list .ui-state-edit input[name=item-list]").attr("action-hide-field");
                                if (actionShowField) {
                                    actionShowField = $.evalJSON(actionShowField);
                                }
                                if (actionHideField) {
                                    actionHideField = $.evalJSON(actionHideField);
                                }
                                $.each(response, function (i, item) {
                                    if (self.options.identify != item.options.identify) {
                                        var checkedHideField = false, checkedShowField = false;
                                        if (actionShowField) {
                                            $.each(actionShowField, function (i, val) {
                                                if (val == item.identify) {
                                                    checkedShowField = true;
                                                }
                                            })
                                        }
                                        if (actionHideField) {
                                            $.each(actionHideField, function (i, val) {
                                                if (val == item.identify) {
                                                    checkedHideField = true;
                                                }
                                            })
                                        }
                                        if (item.options.hideField) {
                                            listFieldShow.append(
                                                $("<li/>", {"class":"jsn-item jsn-iconbar-trigger"}).append(
                                                    $("<label/>", {"class":"checkbox"}).append(
                                                        $("<input/>", {"type":"checkbox", "value":item.identify}).prop("checked", checkedShowField)
                                                    ).append(
                                                        item.options.label
                                                    )
                                                )
                                            )
                                        } else {
                                            listFieldHide.append(
                                                $("<li/>", {"class":"jsn-item jsn-iconbar-trigger"}).append(
                                                    $("<label/>", {"class":"checkbox"}).append(
                                                        $("<input/>", {"type":"checkbox", "value":item.identify}).prop("checked", checkedHideField)
                                                    ).append(
                                                        item.options.label
                                                    )
                                                )
                                            )
                                        }
                                    }
                                });
                            }
                            if ($(listFieldShow).html()) {
                                $(".control-list-action #wr-action-show").append(listFieldShow);
                            } else {
                                $(".control-list-action #wr-action-show").append($("<ul/>", {"class":"jsn-items-list"}).append(
                                    $("<div/>", {"class":"ui-state-disabled"}).append(
                                        self.options.language.WR_CONTACTFORM_ALL_FORM_FIELD_ARE_DISPLAYED
                                    )
                                ));
                            }
                            if ($(listFieldHide).html()) {
                                $(".control-list-action #wr-action-hide").append(listFieldHide);
                            } else {
                                $(".control-list-action #wr-action-hide").append($("<ul/>", {"class":"jsn-items-list"}).append(
                                    $("<div/>", {"class":"ui-state-disabled"}).append(
                                        self.options.language.WR_CONTACTFORM_ALL_FORM_FIELD_ARE_HIDDEN
                                    )
                                ));
                            }
                            $("#wr-action-show input[type=checkbox]").change(function () {
                                var dataShowField = [];
                                $("#wr-action-show input[type=checkbox]:checked").each(function () {
                                    dataShowField.push($(this).val());
                                });
                                $("#visualdesign-options-values .jsn-items-list .ui-state-edit input[name=item-list]").attr("action-show-field", $.toJSON(dataShowField));
                                self.updateAction();
                            });
                            $("#wr-action-hide input[type=checkbox]").change(function () {
                                var dataHideField = [];
                                $("#wr-action-hide input[type=checkbox]:checked").each(function () {
                                    dataHideField.push($(this).val());
                                });
                                $("#visualdesign-options-values .jsn-items-list .ui-state-edit input[name=item-list]").attr("action-hide-field", $.toJSON(dataHideField));
                                self.updateAction();
                            });
                            $(".control-list-action #accordion_content").accordion({
                                autoHeight:false
                            });
                            $(".control-list-action #accordion_content #wr-action-show,.control-list-action #accordion_content #wr-action-hide").css({\'height\':\'auto\'});
                            $("#action-loading").addClass("hide");
                            $("#accordion_content").removeClass("hide");
                            $(".wr-lock-screen").remove();
                            $(document).click(function () {
                                dialog.remove();
                                $("#visualdesign-options-values .jsn-items-list .jsn-item.ui-state-edit").removeClass("ui-state-edit");
                            });
                        }
                    });
                }
            });';
		$openActionSettings = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_action_settings', $openActionSettings );

		$addEvents = ' var self = this;
            var listItems = [];
            var itemChecked = [];
            this.control.find(\'a.wr-ic-move\').click(function () {
                return false;
            });
            this.control.find(\'ul.jsn-items-list input\').click(function (e) {
                e.stopPropagation();
            });
            this.control.find(\'input[type="checkbox"],input[type="radio"]\').change(function () {
                self.updateItems();
            });
            this.control.find(".element-action-edit").click(function (e) {
                self.openActionSettings($(this));
                e.stopPropagation();
            });
            this.control.find("#items-list-edit").click(function () {
                $(this).hide();
                listItems = [];
                itemChecked = [];
                self.control.find(".jsn-items-list .jsn-item").each(function () {
                    listItems.push($(this).find("input").val())
                    if ($(this).find("input").is(\':checked\')) {
                        itemChecked.push($(this).find("input:checked").val());
                    }
                });
                self.control.find(".jsn-items-list").hide().after(
                    $("<div/>", {
                        "id":"items-list-edit-content"
                    }).append(
                        $("<textarea/>", {
                            "class":"jsn-input-xxlarge-fluid",
                            "rows":"10",
                            "text":listItems.join("\r")
                        })));
                self.control.find("#items-list-save").show();
                self.control.find("#items-list-cancel").show();
                self.control.find("#items-list-edit-content textarea").focus();
            });
            self.control.find("#items-list-save").click(function (e) {
                var divItems = $(this).parent().parent();
                var valueItems = divItems.find("#items-list-edit-content textarea").val().split("\n");
                var classValue = self.options.multipleCheck ? "checkbox" : "radio";
                var addedItems = [];

                self.control.find(".jsn-items-list").html("");
                $.each(valueItems, function (key, value) {
                    if (value && addedItems.indexOf(value) == -1) {
                        addedItems.push(value);
                        var inputItem = "";
                        if ($.inArray(value, itemChecked) != -1) {
                            if (self.options.multipleCheck) {
                                inputItem = $("<input/>", {
                                    "type":"checkbox",
                                    "checked":"true",
                                    "name":"item-list",
                                    "value":value
                                });
                            } else {
                                inputItem = $("<input/>", {
                                    "type":"radio",
                                    "checked":"true",
                                    "name":"item-list",
                                    "value":value
                                });
                            }
                        } else {
                            if (self.options.multipleCheck) {
                                inputItem = $("<input/>", {
                                    "type":"checkbox",
                                    "name":"item-list",
                                    "value":value
                                });
                            } else {
                                inputItem = $("<input/>", {
                                    "type":"radio",
                                    "name":"item-list",
                                    "value":value
                                });
                            }
                        }
                        if (self.options.actionField) {
                            self.control.find(".jsn-items-list").append(
                                $("<li/>", {
                                    "class":"jsn-item ui-state-default jsn-iconbar-trigger"
                                }).append(
                                    $("<label/>", {
                                        "class":classValue
                                    }).append(inputItem).append(value)
                                ).append(
                                    $("<div/>", {"class":"jsn-iconbar"}).append(
                                        $("<a/>", {"class":"element-action-edit", href:"javascript:void(0)"}).append(
                                            $("<i/>", {"class":"icon-lightning"})
                                        )
                                    )
                                )
                            )
                        } else {
                            self.control.find(".jsn-items-list").append(
                                $("<li/>", {
                                    "class":"jsn-item ui-state-default jsn-iconbar-trigger"
                                }).append(
                                    $("<label/>", {
                                        "class":classValue
                                    }).append(inputItem).append(value)
                                )
                            )
                        }

                    }
                });
                addedItems = [];
                self.control.find(".jsn-items-list").show();
                self.control.find("#items-list-save").hide();
                self.control.find("#items-list-cancel").hide();
                self.control.find("#items-list-edit").show();
                self.control.find("#items-list-edit-content textarea").remove();
                self.updateItems();
                self.control.find(\'a.wr-ic-move\').click(function () {
                    return false;
                });
                self.control.find(\'ul.jsn-items-list input\').click(function (e) {
                    e.stopPropagation();
                });
                self.control.find(\'input[type="checkbox"],input[type="radio"]\').change(function () {
                    self.updateItems();
                });
                self.control.find(".element-action-edit").click(function (e) {
                    self.openActionSettings($(this));
                    e.stopPropagation();
                });
                var itemAction = $("#visualdesign-options-values #option-itemAction-hidden").val();

                if (itemAction) {
                    itemAction = $.evalJSON(itemAction);
                }

                if (itemAction) {
                    var index = 1, listFieldAction = [], itemlist = [];

                    $.each(itemAction, function (i) {
                        listFieldAction.push(i);
                    });

                    $("#visualdesign-options-values .jsn-items-list .jsn-item input[name=item-list]").each(function () {
                        itemlist.push($(this).val());
                    });

                    $("#visualdesign-options-values .jsn-items-list .jsn-item input[name=item-list]").each(function () {
                        index++;
                        var inputItem = $(this), index2 = 1, tmpShowField = "", tmpHideField = "";

                        $.each(itemAction, function (i, item) {
                            index2++;
                            var valueInput = $(inputItem).val();
                            if (i == valueInput) {
                                $(inputItem).attr("action-show-field", $.toJSON(item.showField));
                                $(inputItem).attr("action-hide-field", $.toJSON(item.hideField));
                            }
                            else if (index == index2 && $.inArray(valueInput, listFieldAction) < 0 && $.inArray(i, itemlist) < 0) {
                                $(inputItem).attr("action-show-field", $.toJSON(item.showField));
                                $(inputItem).attr("action-hide-field", $.toJSON(item.hideField));
                            }
                        });
                    });
                    $("#visualdesign-options-values .jsn-items-list .jsn-item input[name=item-list]").each(function () {
                        var actionShowField = $(this).attr("action-show-field"), actionHideField = $(this).attr("action-hide-field"),checkAction = false;
                        if (actionShowField) {
                            actionShowField = $.evalJSON(actionShowField);
                            if(actionShowField && actionShowField.length > 0){
                                checkAction = true;
                            }
                        }
                        if (actionHideField) {
                            actionHideField = $.evalJSON(actionHideField);
                            if(actionHideField && actionHideField.length > 0){
                                checkAction = true;
                            }
                        }
                        if (checkAction) {
                            var jsnItem = $(this).parents(".jsn-item");
                            $(jsnItem).addClass("jsn-highlight");
                        } else {
                            var jsnItem = $(this).parents(".jsn-item");
                            $(jsnItem).removeClass("jsn-highlight");
                        }
                    });
                    self.updateAction();
                }
            });';
		$addEvents = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_add_events', $addEvents );
		$render = 'var self = this;
		            this.control = $.tmpl(this.template, this.options);

		            this.control.find(\'ul.jsn-items-list\').sortable({
		                items:\'li.jsn-item\',
		                axis:\'y\',
		                forceHelperSize:true,
		                connectWith:\'.jsn-item\',
		                placeholder:\'ui-state-highlight\',
		                update:function () {
		                    self.updateItems();
		                    self.updateAction();
		                }
		            });
		            this.addEvents();
		            this.updateAction();
		            return this.control;';
		$render = apply_filters( 'wr_contactform_filter_visualdesign_itemlist_render', $render );

		$javascript = '
							!function ($) {
		    /**
		     * JSNItemList class
		     */
		    function JSNItemList(options) {
		        this.control = null;
		        this.options = $.extend({
		            name:\'item-list\',
		            allowOther:false,
		            listItems:[],
		            multipleCheck:false,
		            actionField:false
		        }, options);

		        this.options.value = $.toJSON(this.options.listItems);
				' . $template . '
		    JSNItemList.prototype = {
		        /**
		         * Update list of items to hidden field
		         * @return void
		         */
		        updateItems:function () {
					' . $updateItems . '
		        },
		        updateAction:function () {
					' . $updateAction . '
		        },
		        getBoxStyle:function (element) {
					' . $getBoxStyle . '
		        },
		        openActionSettings:function (btnInput) {
					' . $openActionSettings . '
		        },
		        /**
		         * Register event handling for elements
		         * @return void
		         */
		        addEvents:function () {
		           ' . $addEvents . '
		        },
		        /**
		         * Render UI for control
		         * @return void
		         */
		        render:function () {
		          ' . $render . '
		        }
		    };

		    /**
		     * Register jQuery plugin
		     */
		    $.itemList = function (options) {
		        var control = new JSNItemList(options);
		        return control.render();
		    };
		}(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
