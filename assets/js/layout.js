/**
 * @version     $Id$
 * @package     JSNTPLFW
 * @author      woorockets Team <support@woorockets.com>
 * @copyright   Copyright (C) 2012 woorockets.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com/contact-us/get-support.html
 */

(function ($) {
    function JSNLayoutCustomizer(visualDesign, lang) {
        var self = this;
        this.visualDesign = visualDesign;
        this.lang = lang;
        $("#wr-add-container").click(function (e) {
            self.addContainer(1);
        });
        // Handle window resize event
        $(window).resize($.proxy(function(event) {
            if (event.target == window) {
                $("#form-design #form-container .jsn-row-container").each(function(){
                    self.init($(this));
                });
            }
        }, this));
    }

    JSNLayoutCustomizer.prototype = {
        init:function (_this) {
            // Get necessary elements
            var container = $(_this);
            var columns = container.children('.jsn-column-container');
            // Reset width for necessary elements
            columns.children().css('width', '');
            container.css('width', '');
            // Initialize variables
            var maxWidth = $('#form-design #form-container').width(), spacing = 12;
            container.find(".last-child").removeClass("last-child");
            var formRowLength = columns.length;
            var step = parseInt(maxWidth / 12);
            if (formRowLength == 2) {
                step = parseInt(parseInt(maxWidth - parseInt(spacing)) / 12);
            } else if (formRowLength == 3) {
                step = parseInt(parseInt(maxWidth - parseInt(spacing * 2)) / 12);
            }
            // Calculate width for resizable columns
            var total = 0;
            columns.children().each($.proxy(function (i, e) {
                    // Calculate column width
                    var span = parseInt($(e).attr('class').replace("ui-resizable", "").replace("wr-column", "").replace('span', ''));
                    var width = (step * span);
                    $(e).css('width', width + 'px');
                    // Count total width
                    total += $(e).parent().outerWidth(true);
                }
                ,
                this
            ))
            ;
            // Update width for container
            container.css('width', maxWidth + 'px');
            columns.each($.proxy(function (i, e) {
                if (i + 1 == columns.length) {
                    $(e).addClass("last-child");
                } else {
                    $(e).removeClass("last-child");
                }
            }, this));

            // Initialize sortable
            container.sortable({
                axis:'x',
                //   placeholder:'ui-state-highlight',
                start:$.proxy(function (event, ui) {
                    ui.placeholder.append(ui.item.children().clone());
                }, this),
                handle:".jsn-handle-drag",
                stop:$.proxy(function (event, ui) {
                    // Refresh columns ordering
                    columns = container.children('.jsn-column-container');

                    // Re-initialize resizable
                    this.init($(_this));
                    columns.each($.proxy(function (i, e) {
                        if (i + 1 == columns.length) {
                            $(e).addClass("last-child");
                        }
                    }, this));
                }, this)
            });
            container.disableSelection();
            // Initialize resizable
            this.initResizable(step, columns);
        },

        initResizable:function (step, columns) {
            var handleResize = $.proxy(function (event, ui) {
                var span = parseInt((ui.element.width() ) / step),
                    thisWidth = (step * span),
                    nextWidth = ui.element[0].__next[0].originalWidth - (thisWidth - ui.originalSize.width);

                if (thisWidth < step) {
                    thisWidth = step;
                    nextWidth = ui.element[0].__next[0].originalWidth - (thisWidth - ui.originalSize.width);

                    // Set min width to prevent column from collapse more
                    ui.element.resizable('option', 'minWidth', step);
                } else if (nextWidth < step) {

                    nextWidth = step;
                    thisWidth = ui.originalSize.width - (nextWidth - ui.element[0].__next[0].originalWidth);

                    // Set max width to prevent column from expand more
                    ui.element.resizable('option', 'maxWidth', thisWidth);
                }
                // Snap column to grid
                ui.element.css('width', thisWidth + 'px');

                // Resize next sibling element as well
                ui.element[0].__next.css('width', nextWidth + 'px');

            }, this);

            columns.children().each($.proxy(function (i, e) {
                // Initialize resizable column
                !$(e).hasClass('ui-resizable') || $(e).resizable('destroy');
                !e.__next || (e.__next = null);
                if (i + 1 < columns.length) {
                    // Reset resizable column

                    $(e).resizable({
                        handles:'e',
                        minWidth:step,
                        grid:[step, 0],
                        start:$.proxy(function (event, ui) {
                            ui.element[0].__next = ui.element[0].__next || ui.element.parent().next().children();
                            ui.element[0].__next[0].originalWidth = ui.element[0].__next.width();
                            ui.element.resizable('option', 'maxWidth', '');
                        }, this),
                        resize:handleResize,
                        stop:$.proxy(function (event, ui) {
                            //  handleResize(event, ui);
                            var oldValue = parseInt(ui.element.find(".jsn-column-content").attr("data-column-class").replace('span', '')),
                                newValue = parseInt(ui.element.width() / step),
                                nextOldValue = parseInt(ui.element[0].__next.find(".jsn-column-content").attr("data-column-class").replace('span', ''));
                            // Update field values
                            if (nextOldValue > 0 && newValue > 0) {
                                ui.element.find(".jsn-column-content").attr("data-column-class", 'span' + newValue);
                                ui.element[0].__next.find(".jsn-column-content").attr('data-column-class', 'span' + (nextOldValue - (newValue - oldValue)));
                                // Update visual classes
                                ui.element.attr('class', ui.element.attr('class').replace(/\bspan\d+\b/, 'span' + newValue));
                                ui.element[0].__next.attr('class', ui.element[0].__next.attr('class').replace(/\bspan\d+\b/, 'span' + (nextOldValue - (newValue - oldValue))));
                                $(e).css({"height":"auto"});
                            }

                        }, this)
                    });
                }
            }, this));
        },
        addContainer:function (count) {
            var listContainer = [];
            $("#form-container .jsn-row-container").each(function (j) {
                $(this).find(".jsn-column-content").each(function (i) {
                    var columnName = $(this).attr("data-column-name");
                    columnName = columnName.split("_");
                    var column = columnName[1] ? columnName[1] : 1;
                    column = parseInt(column);
                    if (column && listContainer.indexOf(column) == -1) {
                        listContainer.push(parseInt(column));
                    }
                })
            });
            var identify = 1;
            var c = 1;
            while ($.inArray(identify, listContainer) != -1) {
                identify = parseInt(identify) + c;
                c++;
            }
            if (identify >= 1) {
                identify = "_" + identify;
            }

            var htmlContainer = "";
            htmlContainer = $("<div/>", {"class":"jsn-row-container row-fluid"});
            var positionsColumn = ['left', 'center', 'right'];
            for (i = 0; i < count; i++) {
                var span = "span" + 12 / count;
                htmlContainer.append(
                    $("<div/>", {"class":"jsn-column-container clearafter"}).append(
                        $("<div/>", {"class":"wr-column " + span}).append(
                            $("<div/>", {"class":"thumbnail clearafter"}).append(
                                $("<div/>", {"class":"jsn-column-content", "data-column-name":positionsColumn[i] + identify, "data-column-class":span}).append(
                                    $("<div/>", {"class":"jsn-handle-drag jsn-horizontal jsn-iconbar-trigger"}).append('<div class="jsn-iconbar layout"><a class="row-delete column" onclick="return false;" title="Delete column" href="#"><i class="icon-trash"></i></a></div>')
                                ).append(
                                    $("<div/>", {"class":"jsn-element-container"})
                                )
                            )
                        )
                    )
                )
            }
            $("#wr-add-container").before(htmlContainer);
            $(".jsn-row-container .jsn-add-more").remove();
            this.eventContainer();

        }, renderContainer:function (container) {
            $("#form-container .jsn-row-container").remove();
            if (container) {
                var containerPage = $.parseJSON(container);
                containerPage.reverse();

                $.each(containerPage, function (i, value) {
                    var containerPageHtml = $("<div/>", {"class":"jsn-row-container row-fluid"});

                    $.each(value, function () {

                        $(containerPageHtml).append(
                            $("<div/>", {"class":"jsn-column-container clearafter"}).append(
                                $("<div/>", {"class":"wr-column " + this.columnClass}).append(
                                    $("<div/>", {"class":"thumbnail clearafter"}).append(
                                        $("<div/>", {"class":"jsn-column-content", "data-column-name":this.columnName, "data-column-class":this.columnClass}).append(
                                            $("<div/>", {"class":"jsn-handle-drag jsn-horizontal jsn-iconbar-trigger"}).append('<div class="jsn-iconbar layout"><a class="row-delete column" onclick="return false;" title="Delete column" href="#"><i class="icon-trash"></i></a></div>')
                                        ).append(
                                            $("<div/>", {"class":"jsn-element-container"})
                                        )
                                    )
                                )
                            )
                        )
                    })
                    $("#form-container #page-loading").after($(containerPageHtml))
                })
            } else {
                $("#form-container #page-loading").after(
                    $("<div/>", {"class":"jsn-row-container row-fluid"}).append(
                        $("<div/>", {"class":"jsn-column-container clearafter"}).append(
                            $("<div/>", {"class":"wr-column span12"}).append(
                                $("<div/>", {"class":"thumbnail clearafter"}).append(
                                    $("<div/>", {"class":"jsn-column-content", "data-column-name":"left", "data-column-class":"span12"}).append(
                                        $("<div/>", {"class":"jsn-handle-drag jsn-horizontal jsn-iconbar-trigger"}).append('<div class="jsn-iconbar layout"><a class="row-delete column" onclick="return false;" title="Delete column" href="#"><i class="icon-trash"></i></a></div>')
                                    ).append(
                                        $("<div/>", {"class":"jsn-element-container"})
                                    )
                                )
                            )
                        )
                    )
                )
            }
            this.eventContainer();
        },
        eventContainer:function () {
            var self = this;
            $(".jsn-row-container .jsn-add-more").remove();
            self.visualDesign.init($(".jsn-row-container"));
            $(".jsn-iconbar a.add-container").parent().remove();
            $(".jsn-iconbar a.wr-move-up").parent().remove();
            $(".jsn-row-container").each(function (e) {
                $(this).append(
                    $("<div/>", {"class":"jsn-iconbar jsn-vertical", "title":self.lang['Add Column']}).append(
                        $("<a/>", {"href":"javascript:void(0);", "class":"add-container"}).append(
                            $("<i/>", {"class":"icon-plus"})
                        ).click(function () {
                                if (!$(this).hasClass("disabled")) {
                                    var parentForm = $(this).parents(".jsn-row-container");
                                    var countColumn = $(parentForm).find(".jsn-column-container").length;
                                    if (countColumn < 3) {
                                        var positionsColumn = ['left', 'center', 'right'];

                                        var columnName = [];
                                        var columnCount = "";
                                        var numberClass = 0;
                                        var span = "span" + (12 / parseInt($(parentForm).find(".jsn-column-container").length + 1));

                                        $(parentForm).find(".jsn-column-container .jsn-column-content").each(function () {
                                            var dataColumn = $(this).attr("data-column-name");
                                            var columnClass = $(this).attr("data-column-class").replace("span", "");
                                            $(this).attr("data-column-class", span);
                                            var splitDataColumn = dataColumn.split("_");
                                            columnName.push(splitDataColumn[0]);
                                            columnCount = splitDataColumn[1] ? "_" + splitDataColumn[1] : "";
                                        });
                                        var i = 0;
                                        $.each(positionsColumn, function (j, val) {
                                            if (i == 0 && columnName[0] && columnName.indexOf(val) == -1) {
                                                i++;
                                                $(parentForm).find(".jsn-iconbar a.add-container").parent().before(
                                                    $("<div/>", {"class":"jsn-column-container clearafter"}).append(
                                                        $("<div/>", {"class":"wr-column span12"}).append(
                                                            $("<div/>", {"class":"thumbnail clearafter"}).append(
                                                                $("<div/>", {"class":"jsn-column-content", "data-column-name":this + columnCount, "data-column-class":span}).append(
                                                                    $("<div/>", {"class":"jsn-handle-drag jsn-horizontal jsn-iconbar-trigger"}).append('<div class="jsn-iconbar layout"><a class="row-delete column" onclick="return false;" title="Delete column" href="#"><i class="icon-trash"></i></a></div>')
                                                                ).append(
                                                                    $("<div/>", {"class":"jsn-element-container"})
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            }
                                        });
                                        $(parentForm).find(".jsn-column-container .wr-column").each(function () {
                                            $(this).attr('class', $(this).attr('class').replace(/\bspan\d+\b/, span));
                                        });
                                    }
                                }
                                self.eventContainer();
                            })
                    ).append(
                        $("<a/>", {"href":"javascript:void(0);", "title":self.lang['Delete Container']}).append(
                            $("<i/>", {"class":"icon-trash"})
                        ).click(function () {
                                if ($(this).parents(".jsn-row-container").find(".jsn-column-container .jsn-element").length > 0) {
                                    if (confirm(self.lang['Are you sure you want to delete the whole row including all elements it contains?'])) {
                                        $(this).parents(".jsn-row-container").remove();
                                        self.eventContainer();
                                    }
                                } else {
                                    $(this).parents(".jsn-row-container").remove();
                                    self.eventContainer();
                                }
                            })
                    )
                ).append(
                    $("<div/>", {"class":"jsn-iconbar jsn-vertical iconbar-left", "title":self.lang['Add Column']}).append(
                        $("<a/>", {"href":"javascript:void(0);", "title":self.lang['WR_CONTACTFORM_MOVE_UP_CONTAINER'], "class":"wr-move-up"}).append(
                            $("<i/>", {"class":"icon-chevron-up"})
                        ).click(function () {
                                if (!$(this).hasClass("disabled")) {
                                    var prevContainer = $(this).parents(".jsn-row-container").prev(".jsn-row-container");
                                    if (prevContainer.length) {
                                        var temp = $(this).parents(".jsn-row-container").detach();

                                        temp.insertBefore($(prevContainer));
                                        self.eventContainer();
                                    }
                                }
                            })
                    ).append(
                        $("<a/>", {"href":"javascript:void(0);", "title":self.lang['WR_CONTACTFORM_MOVE_DOWN_CONTAINER'], "class":"wr-move-down"}).append(
                            $("<i/>", {"class":" icon-chevron-down"})
                        ).click(function () {
                                if (!$(this).hasClass("disabled")) {
                                    var nextContainer = $(this).parents(".jsn-row-container").next(".jsn-row-container");
                                    if (nextContainer.length) {
                                        var temp = $(this).parents(".jsn-row-container").detach();
                                        temp.insertAfter($(nextContainer));
                                        self.eventContainer();
                                    }
                                }
                            })
                    )
                )
                $(".jsn-row-container.row-fluid").each(function () {
                    var selfContainer = this;
                    var formRow = $(this).find(".jsn-column-container").length;
                    if (formRow == 3) {
                        $(this).find("a.add-container").addClass("disabled");
                    } else {
                        $(this).find("a.add-container").removeClass("disabled");
                    }
                    if ($(this).prev(".jsn-row-container")[0]) {
                        $(this).find("a.wr-move-up").removeClass("disabled");
                    } else {
                        $(this).find("a.wr-move-up").addClass("disabled");
                    }
                    if ($(this).next(".jsn-row-container")[0]) {
                        $(this).find("a.wr-move-down").removeClass("disabled");
                    } else {
                        $(this).find("a.wr-move-down").addClass("disabled");
                    }
                    $(this).find(".jsn-iconbar a.row-delete").unbind('click');
                    $(this).find("a.row-delete").click(function () {
                        var actionDelete = function (selfContainer, _this) {
                            if ($(selfContainer).find(".jsn-column-container").length > 1) {
                                var parentContainer = $(_this).parents(".jsn-row-container");
                                var spanNumber = $(_this).parents(".jsn-column-container").find(".jsn-column-content").attr("data-column-class").replace("span", "");
                                $(_this).parents(".jsn-column-container").remove();
                                var span = "span" + (12 / parseInt($(parentContainer).find(".jsn-column-container").length));
                                $(parentContainer).find(".jsn-column-container .wr-column").each(function () {
                                    $(this).attr('class', $(this).attr('class').replace(/\bspan\d+\b/, span));
                                    $(this).find(".jsn-column-content").attr("data-column-class", span);
                                    $(this).find(".wr-column").removeAttr("style");
                                });
                            } else {
                                $(selfContainer).remove();
                            }
                            self.eventContainer();
                        }
                        if ($(this).parents(".jsn-column-container").find(".jsn-element").length > 0) {
                            if (confirm(self.lang['Are you sure you want to delete the whole column including all elements it contains?'])) {
                                actionDelete(selfContainer, $(this));
                            }
                        } else {
                            actionDelete(selfContainer, $(this));
                        }
                    });
                    self.init(this);
                });
            });
        }
    };
    //  JSNLayoutCustomizer.init();
    window.JSNLayoutCustomizer = JSNLayoutCustomizer;
})(jQuery);