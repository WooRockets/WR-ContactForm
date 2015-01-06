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

class WR_CF_Gadget_Contactform_Js_Submissions extends WR_CF_Gadget_Base {

	/**
	 * Gadget file name without extension.
	 *
	 * @var  string
	 */
	protected $gadget = 'contactform-js-submissions';

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
		/* Create filter get js main content submissions */
		$mainContent = apply_filters( 'wr_contactform_js_submissions_main_content', $mainContent );

		$listForm = new stdClass();
		$forms = get_posts(
			array(
				'post_type' => 'wr_cf_post_type',
				'post_status' => 'any',
				'numberposts' => '999999',
			)
		);
		if ( ! empty( $forms ) ) {
			foreach ( $forms as $f ) {
				$meta = get_post_meta( (int)$f->ID );
				if ( ! empty( $meta[ 'form_id' ][ 0 ] ) ) {
					$fID = (int)$meta[ 'form_id' ][ 0 ];
				}
				else {
					$fID = (int)$f->ID;
				}
				$fielForm = WR_Contactform_Helpers_Contactform::get_filed_by_form_id( $fID );
				if ( ! empty( $fielForm ) ) {
					$column = array();
					$column[ 'date_created' ] = __( 'Date Submitted', WR_CONTACTFORM_TEXTDOMAIN );
					foreach ( $fielForm as $field ) {
						if ( ! empty( $field->field_id ) && ! empty( $field->field_type ) && ! in_array(
							$field->field_type, array(
								'static-content',
								'google-maps',
							)
						)
						) {
							$column[ $field->field_id ] = ! empty( $field->field_title ) ? $field->field_title : '';
						}
					}
					$column[ 'ip' ] = __( 'IP Address', WR_CONTACTFORM_TEXTDOMAIN );
					$column[ 'browser' ] = __( 'Browser', WR_CONTACTFORM_TEXTDOMAIN );
					$column[ 'os' ] = __( 'Operating System', WR_CONTACTFORM_TEXTDOMAIN );
					$listForm->{$fID} = $column;
				}
			}
		}
		$javascript = '(function ($) {
				    $(function () {
					var listForm = $.evalJSON(\'' . json_encode( $listForm ) . '\');
				    $("#wpbody-content .wrap h2").append(
				       $("<input/>",{"type":"button","class":"button","id":"btn-contactform-export","value":"Export"})
				    );
				    $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
				                $("body").append($("<div/>", {
				                    "class":"jsn-modal-overlay",
				                    "style":"z-index: 1000; display: inline;"
				                })).append($("<div/>", {
				                    "class":"jsn-modal-indicator",
				                    "style":"display:block"
				                })).addClass("jsn-loading-page");
				        $("#wpbody .wrap h2 a.add-new-h2").remove();
				        $("#search-submit").val(\'Search...\');
				        var exportField = $("<ul/>", {"class":"container-export jsn-items-list ui-sortable"}).append(
				            $("<li/>",{"class":"jsn-item field-disabled"}).append(
				                 $("<label/>", {"class":"uf-check-all checkbox"}).append(
						                $("<input/>", {"id":"contactform-export-checkall", "type":"checkbox", "name":"contactform_field_export[]"})
						            ).append("Check All")
				            )
				        )
				        $("#adv-settings .metabox-prefs label").each(function () {
				            $(exportField).append(
				                $("<li/>", {"class":"field jsn-item"}).append(
				                    $("<label/>", {"class":"checkbox"}).append(
				                        $("<input/>", {"type":"checkbox", "value":$(this).find("input[type=checkbox]").val()})
				                    ).append($(this).text())
				                )
				            )
				        });
			            var count = $(".subsubsub .count").text();
			            count = count.replace("(","");
			            count = count.replace(")","");
				        if( $("#the-list>.no-items").length>0 && parseInt(count)<1){
							$("#btn-contactform-export,#wr-submission-filter-date,#clear-submit,.actions.bulkactions").remove();
							$("#the-list>.no-items .colspanchange").html("No submissions found.");
							$("#post-query-submit").hide();
							$.checkColspan();

				         }
						$("#dropdown_wr_form_id").change(function(){
							$(this).parents("form").submit();
						})
						if($("#dropdown_wr_form_id").val()=="-1"){
								$("table.wp-list-table").hide();
								$("#post-query-submit").hide();
						}
				        $("#clear-submit").click(function(){
							//$("#dropdown_wr_form_id option[value=-1]").attr("selected","selected");
							$("#wr-submission-filter-date").val("");
						//	$("#post-search-input").val("");
							return false;

				        });
				        $(".bulkactions select[name=action] option[value=edit]").remove();
			            $("#wr-submission-filter-date").daterangepicker({
                        startDate:moment().subtract("days", 29),
                        endDate:moment(),
                        showDropdowns:true,
                        showWeekNumbers:true,
                        ranges:{
                            "Today":[moment(), moment()],
                            "Yesterday":[moment().subtract("days", 1), moment().subtract("days", 1)],
                            "Last 7 Days":[moment().subtract("days", 6), moment()],
                            "Last 30 Days":[moment().subtract("days", 29), moment()]
                        },
                        beforeShow:function(input) {
					        $(input).css({
					            "position": "relative",
					            "z-index": 999999
					        });
					    },
                        opens:"right",
                        buttonClasses:["btn btn-default"],
                        applyClass:"btn-small btn-primary",
                        cancelClass:"btn-small",
                        format:"MM/DD/YYYY",
                        separator:" - ",
                        locale:{
                            applyLabel:"Apply",
                            fromLabel:"From",
                            toLabel:"To",
                            customRangeLabel:"Custom Range",
                            daysOfWeek:["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                            monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                            firstDay:1
	                        }
	                    });
	                    $(".daterangepicker").addClass("jsn-bootstrap hide");

				        $("body").addClass("jsn-master");
				        $("#dialog-export").remove();
				        $("#btn-contactform-export").after(
				            $("<div/>", {
				                "id":"dialog-export"
				            }).append(
				                $("<div/>", {
				                    "class":"ui-dialog-content-inner jsn-bootstrap"
				                }).append(
				                    $("<form/>", {"action":"?wr-cf-gadget=contactform-export&action=default", "method":"post", "id":"contactform_form_export"}).append(exportField).append(
				                        $("<input/>", {"type":"hidden", "name":"form_id", "id":"form_id"})
				                    ).append(
				                        $("<input/>", {"type":"hidden", "name":"task", "id":"task"})
				                    ).append(
				                        $("<input/>", {"type":"hidden", "name":"fieldExport", "id":"fieldExport"})
				                    ).append(
				                        $("<input/>", {"type":"hidden", "name":"exportType", "id":"exportType"})
				                    ).append(
				                        $("<input/>", {"type":"hidden", "name":"exportDate", "id":"exportDate"})
				                    ).append(
				                        $("<input/>", {"type":"hidden", "name":"form_title", "id":"form_title"})
				                    )
				                )
				            )
				        );
				        ' . implode( '', $mainContent ) . '
				        $("#dialog-export").dialog({
				            height:600,
				            width:700,
				            title:"Export Submissions Data",
				            draggable:false,
				            resizable:false,
				            autoOpen:false,
				            modal:true,
				            buttons:{
				                Export:function () {
				                    var checkExport = false;
				                    $("#dialog-export .container-export .field.jsn-item input[type=\"checkbox\"]").each(function () {
				                        if ($(this).is(\':checked\') == true) {
				                            checkExport = true;
				                        }
				                    });
				                    if (checkExport == false) {
				                        alert(\'Please select the field to get submissions\');
				                        return false;
				                    }
				                    var formID = $("#export_form_id").val();
				                    var exportType = $(".contactform-export-type").val();
				                     var exportDate = $(" #filter_date_submission").val();
				                    var fieldExport = [];
				                    $("#dialog-export .container-export .field.jsn-item input[type=checkbox]").each(function () {
				                        if ($(this).is(\':checked\') == true) {
				                            fieldExport.push($(this).val());
				                        }
				                    });
				                    $("#dialog-export #contactform_form_export #form_id").val(formID);
				                    $("#dialog-export #contactform_form_export #task").val(\'contactform.export\');
				                    $("#dialog-export #contactform_form_export #fieldExport").val($.toJSON(fieldExport));
				                    $("#dialog-export #contactform_form_export #exportType").val(exportType);
				                    $("#dialog-export #contactform_form_export #exportDate").val(exportDate);
				                    $("#dialog-export #contactform_form_export #form_title").val($("#dropdown_wr_form_id option:selected").text());
				                    $("#dialog-export #contactform_form_export").submit();

				                    //  $.post("?wr-cf-gadget=contactform-export&action=default", {\'form_id\':formID, \'task\':\'contactform.export\', \'fieldExport\':fieldExport, \'exportType\':exportType, \'form_title\':$("#dropdown_wr_form_id option:selected").text()});
				                },
				                Close:function () {
				                    $(this).dialog("close");
				                }
				            }
				        });
				        var selectForm = $("<select/>",{"id":"export_form_id","class":"input-medium"}).change(function(){
				           $("ul.container-export .field.jsn-item").remove();
				           var getItemForm = listForm[$(this).val()];
				           if(getItemForm){
				                $.each(getItemForm,function(i,val){
				                    $("ul.container-export").append(
				                       $("<li/>", {"class":"field jsn-item"}).append(
						                    $("<label/>", {"class":"checkbox"}).append(
						                        $("<input/>", {"type":"checkbox", "value":i})
						                    ).append(val)
						                )
				                    );
				                })
				           }
				        });

				        $("#dropdown_wr_form_id option").each(function(){
				            var idForm  = $(this).val();
				            var titleForm = $(this).text();
				            var selected = false;
				            if($(this).is(":selected")){
				                selected = true;
				            }
				           $(selectForm).append(
				            $("<option/>",{"value":idForm,"selected":selected}).append(titleForm)
				           );
				        });
				        $(".container-export").before(
				           $("<div/>",{"class":"row-fluid wr-contactform-export-option"}).append(
			                    $("<div/>",{"class":"span8"}).append(
									$("<div/>",{"class":"inline"}).append(selectForm)
					            ).append(
					                 $("<div/>",{"class":"inline"}).append( $("<input/>",{"type":"text","id":"filter_date_submission","title":"Search in submissions date","name":"filter_date_submission","placeholder":"- Select Date -","class":"input-medium"}))
					            ).append(
					                $("<div/>",{"class":"inline"}).append(
					                    $("<input/>",{"class":"btn","type":"button","value":"Clear"}).click(function(){
					                        $("#filter_date_submission").val("");
					                    })
					                )
					            )
				           ).append(
			                    $("<div/>",{"class":"span4"}).append(
			                             $("<div/>", {"class":"wr-contactform-filter-date pull-right"}).append(
				                         $("<span/>").append("Export to:")
						                ).append(
							                $("<select/>", {"name":"contactform_export_type", "class":"contactform-export-type input-small"}).append(
							                    $("<option/>", {"value":"excel", "text":"Excel"})
							                ).append(
							                    $("<option/>", {"value":"csv", "text":"CSV"})
							                )
						                )
						        )
				           )
				        ).sortable({
		                    items:"li:not(.field-disabled)"
		                });
				        $("#contactform_exp_end,#contactform_exp_start").keypress(function (e) {
				            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				                return false;
				            }
				        }).change(function () {
				                if ($(this).val() > total) {
				                    $(this).val(total);
				                }
				            })
				        $("#contactform-export-checkall").click(function () {
				            if ($(this).is(\':checked\') == true) {
				                $(this).prop("checked", true);
				                $("#dialog-export .container-export input[type=\"checkbox\"]").each(function () {
				                    if ($(this).is(\':checked\') == false) {
				                        $(this).prop("checked", true);
				                    }
				                });
				            } else {
				                $(this).prop("checked", false);
				                $("#dialog-export .container-export input[type=\"checkbox\"]").each(function () {
				                    $(this).prop("checked", false);
				                });
				            }
				        });
				        $("#btn-contactform-export").click(function () {
				        $("#dialog-export").dialog("open");
				            $("#filter_date_submission").daterangepicker({
	                        startDate:moment().subtract("days", 29),
	                        endDate:moment(),
	                        showDropdowns:true,
	                        showWeekNumbers:true,
	                        ranges:{
	                            "Today":[moment(), moment()],
	                            "Yesterday":[moment().subtract("days", 1), moment().subtract("days", 1)],
	                            "Last 7 Days":[moment().subtract("days", 6), moment()],
	                            "Last 30 Days":[moment().subtract("days", 29), moment()]
	                        },
	                        beforeShow:function(input) {
						        $(input).css({
						            "position": "relative",
						            "z-index": 999999
						        });
						    },
	                        opens:"right",
	                        buttonClasses:["btn btn-default"],
	                        applyClass:"btn-small btn-primary",
	                        cancelClass:"btn-small",
	                        format:"MM/DD/YYYY",
	                        separator:" - ",
	                        locale:{
	                            applyLabel:"Apply",
	                            fromLabel:"From",
	                            toLabel:"To",
	                            customRangeLabel:"Custom Range",
	                            daysOfWeek:["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
	                            monthNames:["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	                            firstDay:1
		                        }
		                    });
		                    $(".daterangepicker").addClass("jsn-bootstrap hide");
				        });
				    });
				    setTimeout(function () {
				        $("#adv-settings .metabox-prefs label input[type=checkbox]").change(function(){
				            var columns = [];
				           $("#adv-settings .metabox-prefs label input[type=checkbox]:checked").each(function(){
				                columns.push($(this).val());
				           });
							 $.ajax({
	                            type:"POST",
	                            dataType:"json",
	                            url:"admin-ajax.php?action=wr_contactform_hidden_columns",
	                            data:{
	                                columns:columns,
	                                form_id:$("#dropdown_wr_form_id").val(),
	                            }
	                        });
	                        $.checkColspan();
				        });
				        $.ajax({
                            type:"GET",
                            dataType:"json",
                            url:"admin-ajax.php?action=wr_contactform_hidden_columns",
                            data:{
                                form_id:$("#dropdown_wr_form_id").val(),
                            },
                            success:function (response) {
                                if(response){
                                    $("#adv-settings .metabox-prefs label input[type=checkbox]").each(function(){
                                        var value = $(this).val();
                                        var container = $(".wp-list-table").find("#"+value+","+"."+value+",.column-"+value);
						                if($.inArray($(this).val(),response)!=-1){
						                    $(this).attr("checked","checked");
						                     $(container).show();
						                }else{
						                    $(container).hide();
						                     $(this).removeAttr("checked");
						                }
						           });
                                }else{
                                    var defaultColumns = ["date_created","ip","browser","os"];
                                    $("#adv-settings .metabox-prefs label input[type=checkbox]").each(function(){
                                        var value = $(this).val();
                                        var container = $(".wp-list-table").find("#"+value+","+"."+value+",.column-"+value);
						                if($.inArray(value,defaultColumns) != -1){
						                    $(container).show();
						                    $(this).attr("checked","checked");
						                }else{
						                     $(this).removeAttr("checked");
						                   $(container).hide();
						                }
						           });
                                }
                               $("#wpbody-content").show();
				               $(".jsn-modal-overlay,.jsn-modal-indicator").remove();
				               $.checkColspan();
                            }
                        });
				    }, 500);
					$.checkColspan = function(){
						var count = 0;
						$(".wp-list-table thead tr th").each(function(){
							if($(this).width()>1){
								count += 1;
							}
						});
						$("#the-list>.no-items .colspanchange").attr("colspan",count);
					}
				})(jQuery);';
		echo '' . $javascript;
		exit();
	}


}
