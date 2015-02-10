/**
 * @version    $Id$
 * @package    WR_ContactForm
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

( function( $ ) {
	WRContactformMailchimp = {
		initialize: function() {
			var self = this;
			self.checkUse();
			self.verifyKey();
			$( '#wr_contactform_master .jsn-tabs a[href="#form-action"]' ).click( function() {
				self.loadFormFields();
			} );
		},

		checkUse: function() {
			var self = this;
			$( '#wr-cf-mailchimp-use-yes' ).click( function() {
				$( '#wr-cf-mailchimp-control-group-api-key' ).fadeIn();
				if ( $( '#wr-cf-mailchimp-api-key' ).val() != '' ) {
					self.loadLists( $( '#wr-cf-mailchimp-api-key' ).val() );
				}
			} );
			$( '#wr-cf-mailchimp-use-no' ).click( function() {
				$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
				$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
				$( '#wr-cf-mailchimp-api-key-cancel' ).hide();
				$( '#wr-cf-mailchimp-api-key-verify' ).hide();
				$( '#wr-cf-mailchimp-api-key' ).val( $( '#wr-cf-mailchimp-api-key-lastest' ).val() );
				$( '#wr-cf-mailchimp-control-group-api-key' ).fadeOut();
				$( '#wr-cf-mailchimp-control-group-lists' ).fadeOut();
			} );
		},

		verifyKey: function() {
			var self = this;
			//$( '#wr-cf-mailchimp-api-key' ).change( function() {
			$( '#wr-cf-mailchimp-api-key-verify' ).click( function() {
				//$( '#wr-cf-mailchimp-lists' ).val( '[]' );
				$( '#wr-cf-mailchimp-api-key-lastest' ).val( $( '#wr-cf-mailchimp-api-key' ).val() );
				if ( $( '#wr-cf-mailchimp-api-key' ).val() != '' ) {
					self.loadLists( $( '#wr-cf-mailchimp-api-key' ).val() );
				}
			} );
			$( '#wr-cf-mailchimp-api-key-cancel' ).click( function() {
				$( '#wr-cf-mailchimp-api-key' ).val( $( '#wr-cf-mailchimp-api-key-lastest' ).val() );
				$( '#wr-cf-mailchimp-api-key ~ .under-line' ).html( $( '#wr-cf-mailchimp-api-key' ).val() );
				if ( $( '#wr-cf-mailchimp-api-key' ).val() == '' ) {
					$( '#wr-cf-mailchimp-api-key ~ .under-line' ).html( 'Please insert API key' );
				}
				$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
				$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
				$( '#wr-cf-mailchimp-api-key-cancel' ).hide();
				$( '#wr-cf-mailchimp-api-key-verify' ).hide();
			} );
			$( '#wr-cf-mailchimp-api-key' ).change( function() {
				$( '#wr-cf-mailchimp-api-key ~ .under-line' ).html( $( '#wr-cf-mailchimp-api-key' ).val() );
				$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).hide();
				//$( '#wr-cf-mailchimp-control-group-api-key .error-alert' ).hide();
				$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
			} );
			$( '#wr-cf-mailchimp-api-key' ).focus( function() {
				$( '#wr-cf-mailchimp-api-key ~ .under-line' ).hide();
				$( '#wr-cf-mailchimp-api-key' ).removeClass( 'borderless' );
				$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).hide();
				$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
				$( '#wr-cf-mailchimp-api-key-verify' ).fadeIn();
				$( '#wr-cf-mailchimp-api-key-cancel' ).fadeIn();
			} );
			if ( ( $( '#wr-cf-mailchimp-use-yes' ).is( ':checked' ) ) && ( $( '#wr-cf-mailchimp-api-key' ).val() != '' ) ) {
				self.loadLists( $( '#wr-cf-mailchimp-api-key' ).val() );
			}
		},

		loadLists: function( apiKey ) {
			var self = this;
			$( '#wr-cf-mailchimp-control-group-lists .controls' ).html( '' );
			$.ajax( {
				type: 'POST',
				url: 'admin-ajax.php?action=wr_contactform_addon_mailchimp_get_lists',
				data: {
					apikey: apiKey
				},
				beforeSend: function() {
					$( '#wr-cf-mailchimp-api-key-cancel' ).hide();
					$( '#wr-cf-mailchimp-api-key-verify' ).hide();
					$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).hide();
					$( '#wr-cf-mailchimp-control-group-api-key .error-alert' ).hide();
					$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).fadeIn();
				},
				success: function( response ) {
					//console.log( response );
					var responseData = $.parseJSON( response );
					//if ( typeof (responseData.total) != 'undefined' ) {
					if ( responseData.hasOwnProperty( 'total' ) ) {
						if ( responseData.total > 0 ) {
							var listIds = [];
							var currentListBlock;
							for ( var i = 0; i < responseData.data.length; i++ ) {
								listIds[i] = responseData.data[i].id;
								$( '#wr-cf-mailchimp-control-group-lists .controls' ).append( '<div id="wr-cf-mailchimp-list-id-' + responseData.data[i].id + '" class="wr-cf-mailchimp-list"></div>' );
								currentListBlock = $( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id );
								currentListBlock.append( '<div class="wr-cf-mailchimp-list-title"><input type="checkbox" class="wr-cf-mailchimp-list-enable" title="Enable this list"><div>' + responseData.data[i].name + '</div></div>' );
								currentListBlock.append( '<div class="wr-cf-mailchimp-list-inside" style="display: none;"><table class="table table-bordered table-hover"><tr><th>Form Field</th><th>MailChimp Field</th></tr></table></div>' );
								currentListBlock.find( '.wr-cf-mailchimp-list-inside' ).append( '<input type="button" class="wr-cf-mailchimp-add-merge-field btn btn-primary" value="Add More Field Mapping"><div class="clear"></div>' );
								currentListBlock.append( '<table class="wr-cf-mailchimp-merge-clone"></table>' );
							}
							self.effectToggleList();
							self.addMergeField();
							$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list-enable' ).change( function() {
								self.storeMergeFieldConfigs();
							} );

							$.ajax( {
								type: 'POST',
								url: 'admin-ajax.php?action=wr_contactform_addon_mailchimp_get_lists_merge_vars',
								data: {
									apikey: apiKey,
									listids: listIds
								},
								success: function( response ) {
									//console.log( response );
									var responseData = $.parseJSON( response );
									var mergeListsData = $.parseJSON( $( '#wr-cf-mailchimp-lists' ).val() );
									for ( var i = 0; i < responseData.data.length; i++ ) {
										$( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-merge-clone' ).append( '<tr class="wr-cf-mailchimp-merge-field"></tr>' );
										var mergeFieldRow = $( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-merge-clone tr.wr-cf-mailchimp-merge-field' );
										mergeFieldRow.append( '<td><select class="wr-cf-mailchimp-select-form-fields" data-value=""></select></td>' );
										var htmlTpl = '';
										htmlTpl += '<td>';
										htmlTpl += '<select class="wr-cf-mailchimp-select-fields" data-value=""></select>';
										htmlTpl += '<a class="wr-cf-mailchimp-merge-field-remove" title="Remove"><i class="icon-trash"></i></a>';
										htmlTpl += '<div class="clear"></div><input type="checkbox" class="wr-cf-mailchimp-check-other"><span>Custom field</span>';
										htmlTpl += '<input type="text" class="wr-cf-mailchimp-text-other" data-tag="" style="display: none;">';
										htmlTpl += '<div class="clear"></div><span class="error-alert wr-cf-mailchimp-duplicate-field-alert">Duplicated field name, please check again</span></td>';
										mergeFieldRow.append( htmlTpl );
										var fieldsSelectOptions = '<option value="">--Select Field--</option>';
										for ( var j = 0; j < responseData.data[i].merge_vars.length; j++ ) {
											fieldsSelectOptions += '<option value="' + responseData.data[i].merge_vars[j].tag + '">' + responseData.data[i].merge_vars[j].name + '</option>';
										}
										mergeFieldRow.find( '.wr-cf-mailchimp-select-fields' ).html( fieldsSelectOptions );

										var isEstablishedList = false;
										for ( var m = 0; m < mergeListsData.length; m++ ) {
											if ( mergeListsData[m].listid == responseData.data[i].id ) {
												isEstablishedList = true;
												if ( mergeListsData[m].enable == 'yes' ) {
													$( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-list-enable' ).attr( 'checked', 'checked' );
												}
												if ( mergeListsData[m].merge.length > 0 ) {
													var mergeFieldRowClone;
													for ( var n = 0; n < mergeListsData[m].merge.length; n++ ) {
														mergeFieldRowClone = $( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-merge-clone .wr-cf-mailchimp-merge-field' ).clone();
														mergeFieldRowClone.appendTo( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-list-inside table' );
														mergeFieldRowClone.find( '.wr-cf-mailchimp-select-form-fields' ).attr( 'data-value', mergeListsData[m].merge[n].src );
														mergeFieldRowClone.find( '.wr-cf-mailchimp-select-form-fields' ).val( mergeListsData[m].merge[n].src );
														mergeFieldRowClone.find( '.wr-cf-mailchimp-select-fields' ).attr( 'data-value', mergeListsData[m].merge[n].dest );
														mergeFieldRowClone.find( '.wr-cf-mailchimp-select-fields' ).val( mergeListsData[m].merge[n].dest );
														if ( mergeListsData[m].merge[n].other != '' ) {
															mergeFieldRowClone.find( '.wr-cf-mailchimp-select-fields' ).attr( 'disabled', 'disabled' );
															mergeFieldRowClone.find( '.wr-cf-mailchimp-select-fields' ).val( '' );
															mergeFieldRowClone.find( '.wr-cf-mailchimp-check-other' ).attr( 'checked', 'checked' );
															mergeFieldRowClone.find( '.wr-cf-mailchimp-text-other' ).attr( 'data-tag', mergeListsData[m].merge[n].dest );
															mergeFieldRowClone.find( '.wr-cf-mailchimp-text-other' ).val( mergeListsData[m].merge[n].other );
															mergeFieldRowClone.find( '.wr-cf-mailchimp-text-other' ).show();
														}
														self.handleMergeFieldEvents( mergeFieldRowClone );
													}
												} else {
													var mergeFieldRowClone = $( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-merge-clone .wr-cf-mailchimp-merge-field' ).clone();
													mergeFieldRowClone.appendTo( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-list-inside table' );
													self.handleMergeFieldEvents( mergeFieldRowClone );
												}
											}
										}
										if ( ! isEstablishedList ) {
											var mergeFieldRowClone = $( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-merge-clone .wr-cf-mailchimp-merge-field' ).clone();
											mergeFieldRowClone.appendTo( '#wr-cf-mailchimp-list-id-' + responseData.data[i].id + ' .wr-cf-mailchimp-list-inside table' );
											self.handleMergeFieldEvents( mergeFieldRowClone );
										}
										
									}

									self.generateFormFieldsSelectOptions();

									$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
									$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
									$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
									$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).fadeIn();
									$( '#wr-cf-mailchimp-control-group-lists' ).fadeIn();
								}
							} );
						} else {
							$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
							$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
							$( '#wr-cf-mailchimp-control-group-lists .controls' ).html( '<p class="not-found-notice">Your MailChimp currently has no list.</p>' );
							$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
							$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).fadeIn();
							$( '#wr-cf-mailchimp-control-group-lists' ).fadeIn();
						}
					} else {
						$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
						$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
						$( '#wr-cf-mailchimp-control-group-lists' ).fadeOut();
						$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
						$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).hide();
						$( '#wr-cf-mailchimp-control-group-api-key .error-alert' ).fadeIn();
					}
				},
				error: function() {
					$( '#wr-cf-mailchimp-api-key' ).addClass( 'borderless' );
					$( '#wr-cf-mailchimp-api-key ~ .under-line' ).show();
					$( '#wr-cf-mailchimp-control-group-lists' ).fadeOut();
					$( '#wr-cf-mailchimp-control-group-api-key .spinner' ).hide();
					$( '#wr-cf-mailchimp-control-group-api-key .icon-ok' ).hide();
					$( '#wr-cf-mailchimp-control-group-api-key .error-alert' ).fadeIn();
				}
			} );
		},

		loadFormFields: function() {
			var self = this;
			var listOptionPage = [];
			$( 'ul.jsn-page-list li.page-items' ).each( function() {
				listOptionPage.push( [$( this ).find( 'input' ).attr( 'data-id' ), $( this ).find( 'input' ).attr( 'value' )] );
			} );
			$.ajax( {
				type: 'POST',
				//dataType: 'json',
				url: 'admin-ajax.php?action=wr_contactform_load_session_field',
				data: {
					form_id: $( '#jform_form_id' ).val(),
					form_page_name: $( '#form-design-header' ).attr( 'data-value' ),
					form_list_page: listOptionPage
				},
				success: function( response ) {
					//console.log( response );
					//$( '#wr-cf-mailchimp-form-fields-data' ).val( JSON.stringify( response ) );
					if ( response == '' ) {
						response = '[]';
					}
					$( '#wr-cf-mailchimp-form-fields-data' ).val( response );
					self.generateFormFieldsSelectOptions();

					// Load one more time to get exact data
					$.ajax( {
						type: 'POST',
						//dataType: 'json',
						url: 'admin-ajax.php?action=wr_contactform_load_session_field',
						data: {
							form_id: $( '#jform_form_id' ).val(),
							form_page_name: $( '#form-design-header' ).attr( 'data-value' ),
							form_list_page: listOptionPage
						},
						success: function( response ) {
							//console.log( response );
							//$( '#wr-cf-mailchimp-form-fields-data' ).val( JSON.stringify( response ) );
							if ( response == '' ) {
								response = '[]';
							}
							$( '#wr-cf-mailchimp-form-fields-data' ).val( response );
							self.generateFormFieldsSelectOptions();
						}
					} );
				}
			} );
		},

		generateFormFieldsSelectOptions: function() {
			var self = this;
			formFieldsData = $.parseJSON( $( '#wr-cf-mailchimp-form-fields-data' ).val() );
			var formFieldsSelectOptions = '<option value="">--Select Field--</option>';
			var notSupportedFields = ['static-content', 'google-maps', 'file-upload'];
			for ( var i = 0; i < formFieldsData.length; i++ ) {
				if ( $.inArray( formFieldsData[i].type, notSupportedFields ) == -1 ) {
					formFieldsSelectOptions += '<option value="' + formFieldsData[i].identify + '">' + formFieldsData[i].options.label + '</option>';
				}
			}
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-select-form-fields' ).each( function () {
				$( this ).html( formFieldsSelectOptions );
				$( this ).val( $( this ).attr( 'data-value' ) );
			} );
			self.disableDuplicatedOption();
		},

		storeMergeFieldConfigs: function() {
			var lists = [];
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list' ).each( function() {
				var list = {
					listid: '',
					enable: '',
					merge: []
				};
				list.listid = $( this ).attr( 'id' ).replace( /^wr-cf-mailchimp-list-id-/, '' );
				if ( $( this ).find( '.wr-cf-mailchimp-list-enable' ).is( ':checked' ) ) {
					list.enable = 'yes';
				} else {
					list.enable = 'no';
				}
				$( '#' + $( this ).attr( 'id' ) + ' .wr-cf-mailchimp-list-inside table .wr-cf-mailchimp-merge-field' ).each( function() {
					var mergeField = {
						src: $( this ).find( '.wr-cf-mailchimp-select-form-fields' ).val(),
						dest: $( this ).find( '.wr-cf-mailchimp-select-fields' ).val(),
						other: ''
					};
					if ( $( this ).find( '.wr-cf-mailchimp-check-other' ).is( ':checked' ) ) {
						mergeField.dest = $( this ).find( '.wr-cf-mailchimp-text-other' ).attr( 'data-tag' );
						mergeField.other = $( this ).find( '.wr-cf-mailchimp-text-other' ).val();
					}
					if ( ( mergeField.src != '' ) || ( mergeField.dest != '' ) || ( mergeField.other != '' ) ) {
						list.merge.push( mergeField );
					}
				} );
				lists.push( list );
			} );
			$( '#wr-cf-mailchimp-lists' ).val( JSON.stringify( lists ) );
		},

		handleMergeFieldEvents: function( element ) {
			var self = this;
			element.find( 'select' ).change( function() {
				$( this ).attr( 'data-value', $( this ).val() );
				self.storeMergeFieldConfigs();
				self.disableDuplicatedOption();
			} );
			element.find( '.wr-cf-mailchimp-check-other' ).change( function() {
				if ( $( this ).is( ':checked' ) ) {
					element.find( '.wr-cf-mailchimp-select-fields' ).attr( 'disabled', 'disabled' );
					element.find( '.wr-cf-mailchimp-select-fields' ).val( '' );
					element.find( '.wr-cf-mailchimp-text-other' ).show();
				} else {
					element.find( '.wr-cf-mailchimp-select-fields' ).removeAttr( 'disabled' );
					element.find( '.wr-cf-mailchimp-text-other' ).hide();
				}
				self.storeMergeFieldConfigs();
				self.disableDuplicatedOption();
			} );
			element.find( '.wr-cf-mailchimp-text-other' ).change( function() {
				var thisOther = this;
				self.storeMergeFieldConfigs();
				element.find( '.wr-cf-mailchimp-duplicate-field-alert' ).hide();
				element.find( '.wr-cf-mailchimp-select-fields option' ).each( function() {
					if ( $( thisOther ).val() == $( this ).html() ) {
						element.find( '.wr-cf-mailchimp-duplicate-field-alert' ).show();
					}
				} );
			} );
			element.find( '.wr-cf-mailchimp-merge-field-remove' ).click( function() {
				element.remove();
				self.storeMergeFieldConfigs();
				self.disableDuplicatedOption();
			} );
		},

		disableDuplicatedOption: function() {
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list' ).each( function() {
				var thisList = this;
				$( thisList ).find( '.wr-cf-mailchimp-list-inside table .wr-cf-mailchimp-merge-field' ).each( function() {
					var thisSelectFields = $( this ).find( '.wr-cf-mailchimp-select-fields' );
					var thisSelectFormFields = $( this ).find( '.wr-cf-mailchimp-select-form-fields' );
					thisSelectFields.find( 'option' ).removeAttr( 'disabled' );
					thisSelectFormFields.find( 'option' ).removeAttr( 'disabled' );
					$( thisList ).find( '.wr-cf-mailchimp-list-inside table .wr-cf-mailchimp-merge-field' ).each( function() {
						if ( ( ! $( this ).find( '.wr-cf-mailchimp-select-fields' ).is( '[disabled="disabled"]' ) ) && ( $( this ).find( '.wr-cf-mailchimp-select-fields' ).val() != '' ) && ( thisSelectFields.val() != $( this ).find( '.wr-cf-mailchimp-select-fields' ).val() ) ) {
							thisSelectFields.find( 'option[value="' + $( this ).find( '.wr-cf-mailchimp-select-fields' ).val() + '"]' ).attr( 'disabled', 'disabled' );
							thisSelectFields.find( 'option[value="' + $( this ).find( '.wr-cf-mailchimp-select-fields' ).val() + '"]' ).appendTo( thisSelectFields );
						}
						if ( ( $( this ).find( '.wr-cf-mailchimp-check-other' ).is( ':checked' ) ) && ( $( this ).find( '.wr-cf-mailchimp-text-other' ).attr( 'data-tag' ) != '' ) ) {
							thisSelectFields.find( 'option[value="' + $( this ).find( '.wr-cf-mailchimp-text-other' ).attr( 'data-tag' ) + '"]' ).remove();
						}
						if ( ( $( this ).find( '.wr-cf-mailchimp-select-form-fields' ).val() != '' ) && ( thisSelectFormFields.val() != $( this ).find( '.wr-cf-mailchimp-select-form-fields' ).val() ) ) {
							thisSelectFormFields.find( 'option[value="' + $( this ).find( '.wr-cf-mailchimp-select-form-fields' ).val() + '"]' ).attr( 'disabled', 'disabled' );
							thisSelectFormFields.find( 'option[value="' + $( this ).find( '.wr-cf-mailchimp-select-form-fields' ).val() + '"]' ).appendTo( thisSelectFormFields );
						}
					} );
				} );
			} );
		},

		addMergeField: function() {
			var self = this;
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-add-merge-field' ).click( function() {
				var currentList = $( this ).parents( '.wr-cf-mailchimp-list' );
				var currentListId = currentList.attr( 'id' );
				var mergeFieldRowClone = currentList.find( '.wr-cf-mailchimp-merge-clone .wr-cf-mailchimp-merge-field' ).clone();
				mergeFieldRowClone.appendTo( '#' + currentListId + ' .wr-cf-mailchimp-list-inside table' );
				self.handleMergeFieldEvents( mergeFieldRowClone );
				self.disableDuplicatedOption();
			} );
		},

		effectToggleList: function() {
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list' ).each( function() {
				var thisList = this;
				$( thisList ).find( '.wr-cf-mailchimp-list-title>div' ).click( function() {
					if ( $( thisList ).hasClass( 'active' ) ) {
						$( thisList ).removeClass( 'active' );
						$( thisList ).find( '.wr-cf-mailchimp-list-inside' ).slideUp();
					} else {
						$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list' ).removeClass( 'active' );
						$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list .wr-cf-mailchimp-list-inside' ).slideUp();
						$( thisList ).addClass( 'active' );
						$( thisList ).find( '.wr-cf-mailchimp-list-inside' ).slideDown();
					}
				} );
			} );
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list:first-child' ).addClass( 'active' );
			$( '#wr-cf-mailchimp-control-group-lists .wr-cf-mailchimp-list:first-child' ).find( '.wr-cf-mailchimp-list-inside' ).show();
		}
	};

	$( function() {
		WRContactformMailchimp.initialize();
	} );
} )( jQuery );