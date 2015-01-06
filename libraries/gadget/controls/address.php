<?php
/**
 * @version    $Id$
 * @package    WR ContactForm
 * @author     WooRockets Team <support@www.woorockets.com>
 * @copyright  Copyright (C) 2012 www.woorockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.www.woorockets.com
 * Technical Support:  Feedback - http://www.www.woorockets.com
 */

class WR_CF_Gadget_Controls_Address {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Address element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'address';
		$options = array(
			'caption' => 'Address',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Address',
				'instruction' => '',
				'required' => 0,
				'vstreetAddress' => 0,
				'vstreetAddress' => 0,
				'vcity' => 0,
				'vstate' => 0,
				'vcode' => 0,
				'vcountry' => 0,
				'country' => WR_CF_Gadget_Controls_Country_List::get_list(),
			),
			'params' => array(
				'general' => array(
					'label' => array(
						'type' => 'text',
						'label' => 'Title'
					),
					'customClass' => array(
						'type' => 'text',
						'label' => 'Class'
					),
					'instruction' => array(
						'type' => 'textarea',
						'label' => 'Help Text'
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							)
						)
					)
				),
				'values' => array(
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="row-fluid"><div class="span6 jsn-items-list-container" id="wr-field-address"><label for="option-country-itemlist" class="control-label">Fields</label><ul class="jsn-items-list ui-sortable"><vstreetAddress/><vstreetAddress2/><vcity/><vstate/><vcode/><vcountry/></ul><sortableField/></div><div id="wr-address-default-country" class="span6"><country/></div></div>',
						'title' => 'Predefined Value',
						'elements' => array(
							'country' => array(
								'type' => 'itemlist',
								'label' => 'Countries',
								'multipleCheck' => false
							),
							'vstreetAddress' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'STREET_ADDRESS', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vstreetAddress2' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'ADDRESS_LINE_2', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vcity' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'CITY', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vstate' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'STATE_PROVINCE_REGION', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vcode' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'POSTAL_ZIP_CODE', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vcountry' => array(
								'field' => 'address',
								'type' => 'checkbox',
								'label' => __( 'COUNTRY', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'sortableField' => array(
								'type' => 'hidden'
							)
						),
					),
				),
			),
			'tmpl' => '<div class="control-group {{if hideField}}wr-hidden-field{{/if}} wr-group-field"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls">{{if vstreetAddress}}<div class="row-fluid"><input type="text" placeholder="' . __( 'STREET_ADDRESS', WR_CONTACTFORM_TEXTDOMAIN ) . '" class="jsn-input-xxlarge-fluid" /></div>{{/if}}{{if vstreetAddress2}}<div class="row-fluid"><input type="text" placeholder="' . __( 'ADDRESS_LINE_2', WR_CONTACTFORM_TEXTDOMAIN ) . '" class="jsn-input-xxlarge-fluid" /></div>{{/if}}{{if vcity || vstate}}<div class="row-fluid">{{if vcity}}<div class="span6"><input type="text" class="jsn-input-xlarge-fluid" placeholder="' . __( 'CITY', WR_CONTACTFORM_TEXTDOMAIN ) . '" /></div>{{/if}}{{if vstate}}<div class="span6"><input type="text" class="jsn-input-xlarge-fluid" placeholder="' . __( 'STATE_PROVINCE_REGION', WR_CONTACTFORM_TEXTDOMAIN ) . '" /></div>{{/if}}</div>{{/if}} {{if vcode || vcountry}}<div class="row-fluid">{{if vcode}}<div class="span6"><input type="text" class="jsn-input-xlarge-fluid" placeholder="' . __( 'POSTAL_ZIP_CODE', WR_CONTACTFORM_TEXTDOMAIN ) . '" /></div>{{/if}}{{if vcountry}}<div class="span6"><select class="jsn-input-xlarge-fluid">{{each(i, val) country}}<option value="${val.text}" {{if val.checked == true || val.checked=="true"}}selected{{/if}}>${val.text}</option>{{/each}}</select></div>{{/if}}</div>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}