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

class WR_CF_Gadget_Controls_Paragraph_Text {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Multi-line Input element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'paragraph-text';
		$options = array(
			'caption' => 'Multi-line Input',
			'group' => 'standard',
			'defaults' => array(
				'label' => 'Multi-line Input',
				'instruction' => '',
				'required' => 0,
				'limitation' => 0,
				'limitMin' => 0,
				'limitMax' => 0,
				'rows' => 8,
				'size' => 'jsn-input-xlarge-fluid',
				'limitType' => 'Words',
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"><rows/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'rows' => array(
								'type' => 'number',
								'label' => 'Rows',
								'validate' => array(
									'number'
								)
							)
						)
					)
				),
				'values' => array(
					'value' => array(
						'type' => 'textarea',
						'label' => 'Predefined Value',
						'attrs' => array(
							'rows' => '10'
						)
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
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><textarea class="${size}" rows="${rows}" placeholder="${value}"></textarea></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}