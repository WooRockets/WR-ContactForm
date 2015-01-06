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

class WR_CF_Gadget_Controls_Date {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Date element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'date';
		$options = array(
			'caption' => 'Date/Time',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Date/Time',
				'instruction' => '',
				'required' => 0,
				'enableRageSelection' => 0,
				'size' => 'jsn-input-small-fluid',
				'timeFormat' => 0,
				'dateFormat' => 0,
				'yearRangeMin' => '1930',
				'yearRangeMax' => date( "Y" ) + 10
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"><size/></div><div class="clearbreak"></div></div>',
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
						'type' => 'horizontal',
						'decorator' => '<dateValue/> <dateValueRange/>',
						'title' => 'Predefined Value',
						'elements' => array(
							'dateValue' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'attrs' => array(
									'class' => 'input-date-time'
								)
							),
							'dateValueRange' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'attrs' => array(
									'class' => 'input-date-time'
								)
							)
						)
					),
					'selection' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><enableRageSelection/></div><div class="jsn-form-bar"><dateFormat/><dateOptionFormat/></div><div id="wr-custom-date" class="jsn-form-bar hide"><customFormatDate/></div><div class="jsn-form-bar"><timeFormat/><timeOptionFormat/></div>',
						'elements' => array(
							'dateFormat' => array(
								'type' => 'checkbox',
								'label' => __( 'WR_CONTACTFORM_SHOW_DATE_FORMAT', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'timeFormat' => array(
								'type' => 'checkbox',
								'label' => __( 'WR_CONTACTFORM_SHOW_TIME_FORMAT', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'enableRageSelection' => array(
								'type' => 'checkbox',
								'label' => __( 'WR_CONTACTFORM_ENABLE_RANGE_SELECTION', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'dateOptionFormat' => array(
								'type' => 'select',
								'options' => array(
									'mm/dd/yy' => 'Default - mm/dd/yy',
									'yy-mm-dd' => 'ISO 8601 - yy-mm-dd',
									'd M, y' => 'Short - d M, y',
									'd MM, y' => 'Medium - d MM, y',
									'DD, d MM, yy' => 'Full - DD, d MM, yy',
									'custom' => 'Custom format'
								)
							),
							'customFormatDate' => array(
								'type' => 'text',
								'attrs' => array(
									'id' => 'wr-custom-date-field',
									'placeholder' => __( 'WR_CONTACTFORM_CUSTOM_DATE_FORMAT', WR_CONTACTFORM_TEXTDOMAIN )
								)
							),
							'timeOptionFormat' => array(
								'type' => 'select',
								'options' => array(
									'hh:mm tt' => 'AM/PM',
									'HH:mm' => '12/24'
								)
							)
						)
					),
					'dateRange' => array(
						'type' => 'horizontal',
						'decorator' => '<div class="jsn-form-bar"><yearRangeMin/><span class="wr-field-prefix">To</span><yearRangeMax/></div>',
						'title' => 'Year Range Selection',
						'elements' => array(
							'yearRangeMin' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'validate' => array( 'number' ),
								'attrs' => array(
									'class' => 'input-small'
								)
							),
							'yearRangeMax' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'validate' => array( 'number' ),
								'attrs' => array(
									'class'=> 'input-small'
								)
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><div class="input-append wr-inline"><input placeholder="${dateValue}" class="{{if (timeFormat==1 || timeFormat =="1")&&(dateFormat==1 || dateFormat =="1")  }} input-medium {{else}} input-small {{/if}} contactform-date-time" dateFormat="{{if dateFormat==1||dateFormat=="1"}}${dateOptionFormat}{{/if}}" timeFormat="{{if timeFormat==1||timeFormat=="1"}}${timeOptionFormat}{{/if}}"  type="text" /></div> {{if enableRageSelection==1||enableRageSelection=="1"}}<div class="input-append wr-inline"><input placeholder="${dateValueRange}" class="{{if  (timeFormat==1 || timeFormat =="1")&&(dateFormat==1 || dateFormat =="1") }} input-medium {{else}} input-small {{/if}} contactform-date-time" dateFormat="{{if dateFormat==1||dateFormat=="1"}}${dateOptionFormat}{{/if}}" timeFormat="{{if timeFormat==1||timeFormat=="1"}}${timeOptionFormat}{{/if}}" type="text" /></div>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}