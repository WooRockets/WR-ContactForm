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

class WR_CF_Gadget_Controls_Email {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Email element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'email';
		$options = array(
			'caption' => 'Email',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Email',
				'instruction' => '',
				'required' => 0,
				'noDuplicates' => 0,
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><noDuplicates/></div><div class="pull-right"><size/></div><div class="clearbreak"></div></div><div class="jsn-form-bar"><div class="pull-left"><hideField/></div><div class="clearbreak"></div></div>',
						'elements' => array(
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
							),
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'noDuplicates' => array(
								'type' => 'checkbox',
								'label' => 'No Duplicates',
								'title' => 'If checked no value duplication will be allowed for this field.'
							)
						)
					)
				),
				'values' => array(
					'value' => array(
						'type' => 'text',
						'label' => 'Predefined Value'
					),
					'valueConfirm' => array(
						'type' => 'text'
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><requiredConfirm/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'requiredConfirm' => array(
								'type' => 'checkbox',
								'label' => 'Required Confirmation'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><div class="row-fluid"><input class="${size}" type="text" placeholder="${value}" /></div>{{if requiredConfirm}}<div class="row-fluid"><input class="${size}" type="text" placeholder="${valueConfirm}" /></div>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}