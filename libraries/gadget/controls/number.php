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

class WR_CF_Gadget_Controls_Number {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Number element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'number';
		$options = array(
			'caption' => 'Number',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Number',
				'instruction' => '',
				'required' => 0,
				'limitation' => 0,
				'limitMin' => 0,
				'limitMax' => 0,
				'size' => 'jsn-input-mini-fluid',
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
									'jsn-input-large-fluid' => 'Large'
								),
								'attrs' => array(
									'class' => 'input-medium'
								)
							)
						)
					)
				),
				'values' => array(
					'extra' => array(
						'type' => 'horizontal',
						'decorator' => '<value/><span class="wr-field-prefix">.</span><decimal/>',
						'title' => 'Predefined Value',
						'elements' => array(
							'value' => array(
								'type' => 'number',
								'group' => 'horizontal',
								'field' => 'number',
								'attrs' => array(
									'class' => 'jsn-input-small-fluid'
								)
							),
							'decimal' => array(
								'type' => 'number',
								'group' => 'horizontal',
								'field' => 'number',
								'attrs' => array(
									'class' => 'input-mini'
								)
							)
						)
					),
					'allowUser' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><showDecimal/></div>',
						'elements' => array(
							'showDecimal' => array(
								'type' => 'checkbox',
								'label' => 'Show decimal'
							)
						)
					),
					'limit' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><limitation/><limitMin/><limitMax/></div>',
						'elements' => array(
							'limitation' => array(
								'type' => 'checkbox',
								'label' => 'Limit number'
							),
							'limitMin' => array(
								'type' => 'number',
								'label' => 'within',
								'validate' => array( 'number' )
							),
							'limitMax' => array(
								'type' => 'number',
								'label' => 'and',
								'validate' => array( 'number' )
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls clearfix"><input type="text" class="${size}" placeholder="${value}" />{{if showDecimal}}<span class="wr-field-prefix">.</span><input type="text" class="input-mini" placeholder="${decimal}" />{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}