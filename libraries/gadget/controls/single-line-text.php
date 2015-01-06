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

class WR_CF_Gadget_Controls_Single_Line_Text {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Single-line Text element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'single-line-text';
		$options = array(
			'caption' => 'Single-line Input',
			'group' => 'standard',
			'defaults' => array(
				'label' => 'Single-line Input',
				'instruction' => '',
				'required' => 0,
				'limitation' => 0,
				'limitMin' => 0,
				'limitMax' => 0,
				'limitType' => 'Words',
				'size' => 'jsn-input-medium-fluid',
				'value' => ''
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
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'size' => array(
								'type' => 'select',
								'label' => 'Size',
								'options' => array(
									'jsn-input-mini-fluid' => 'Mini',
									'jsn-input-small-fluid' => 'Small',
									'jsn-input-medium-fluid' => 'Medium',
									'jsn-input-xlarge-fluid' => 'Large'
								),
								'attrs' => array(
									'class' => 'input-medium'
								)
							)
						)
					)
				),
				'values' => array(
					'value' => array(
						'type' => 'text',
						'label' => 'Predefined Value'
					),
					'limit' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><limitation/><limitMin/><limitMax/><limitType/></div>',
						'elements' => array(
							'limitation' => array(
								'type' => 'checkbox',
								'label' => 'Limit text'
							),
							'limitMin' => array(
								'type' => 'number',
								'label' => 'within',
								'validate' => array(
									'number'
								)
							),
							'limitMax' => array(
								'type' => 'number',
								'label' => 'and',
								'validate' => array(
									'number'
								)
							),
							'limitType' => array(
								'type' => 'select',
								'options' => array(
									'Words' => 'Words',
									'Characters' => 'Characters'
								),
								'attrs' => array(
									'class' => 'input-small'
								)
							)
						)
					)
				),
				'quickeditstyle' => array(
					'tab' => 'Field'
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><input type="text" placeholder="${value}" class="${size}"/></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}