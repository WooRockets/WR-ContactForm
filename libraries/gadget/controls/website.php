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

class WR_CF_Gadget_Controls_Website {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Website element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'website';
		$options = array(
			'caption' => 'Website',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Website',
				'instruction' => '',
				'required' => 0,
				'noDuplicates' => 0,
				'size' => 'jsn-input-medium-fluid',
				'value' => 'http://'
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
								'title' => "WR_CONTACTFORM_IF_CHECKED_VALUE_DUPLICATION"
							)
						)
					)
				),
				'values' => array(
					'value' => array(
						'type' => 'text',
						'label' => 'Predefined Value'
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><input class="${size}" type="text" placeholder="${value}" /></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}