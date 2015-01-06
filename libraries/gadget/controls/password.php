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

class WR_CF_Gadget_Controls_Password {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Password element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'password';
		$options = array(
			'caption' => 'Password',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Password',
				'instruction' => '',
				'required' => 0,
				'limitMin' => 0,
				'limitMax' => 0,
				'confirmation' => false,
				'encrypt' => 'text',
				'hideField' => false,
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
					'valueConfirmation' => array(
						'type' => 'text'
					),
					'optionsPassword' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><confirmation/></div><div class="pull-right"><encrypt/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'confirmation' => array(
								'type' => 'checkbox',
								'label' => 'Require Confirmation'
							),
							'encrypt' => array(
								'type' => 'select',
								'label' => 'Encryption',
								'options' => array(
									'text' => 'No encryption',
									'md5' => 'MD5',
									'sha1' => 'SHA-1'
								),
								'attrs' => array(
									'class' => 'input-medium'
								)
							)
						)
					),
					'limit' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><limitation/><limitMin/><limitMax/> characters</div>',
						'elements' => array(
							'limitation' => array(
								'type' => 'checkbox',
								'label' => 'Require length'
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
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}} wr-group-field"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><input type="password" placeholder="${value}"  class="${size}"/>{{if confirmation}}<br/><input type="password" placeholder="${valueConfirmation}"  class="${size}"/>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}