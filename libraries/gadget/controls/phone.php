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

class WR_CF_Gadget_Controls_Phone {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Phone element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'phone';
		$options = array(
			'caption' => 'Phone',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Phone',
				'instruction' => '',
				'required' => 0,
				'format' => '1-text',
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
					'inputsize' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"></div><div class="clearbreak"></div></div>',
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
							)
						)
					)
				),
				'values' => array(
					'value' => array(
						'type' => 'text',
						'label' => 'Predefined Value'
					),
					'extra' => array(
						'type' => 'horizontal',
						'decorator' => '<oneField/><span class="wr-field-prefix">-</span><twoField/><span class="wr-field-prefix">-</span><threeField/>',
						'title' => 'Predefined Value',
						'elements' => array(
							'oneField' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'attrs' => array(
									'class' => 'input-small'
								)
							),
							'twoField' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'attrs' => array(
									'class' => 'input-small'
								)
							),
							'threeField' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'attrs' => array(
									'class' => 'input-small'
								)
							)
						)
					),
					'format' => array(
						'type' => 'select',
						'label' => 'Phone Format',
						'options' => array(
							'1-field' => '1 field',
							'3-field' => '3 field'
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls">{{if format=="1-field"}}<input class="jsn-input-medium-fluid" type="text" placeholder="${value}" />{{else}}<div class="wr-inline"><input type="text" class="jsn-input-mini-fluid" placeholder="${oneField}"></div><span class="wr-field-prefix">-</span><div class="wr-inline"><input type="text" class="jsn-input-mini-fluid" placeholder="${twoField}"></div><span class="wr-field-prefix">-</span><div class="wr-inline"><input type="text" class="jsn-input-mini-fluid" placeholder="${threeField}"></div>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}