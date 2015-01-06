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

class WR_CF_Gadget_Controls_Form_Captcha {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Captcha element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'form-captcha';
		$options = array(
			'caption' => 'Form Captcha',
			'group' => 'extra',
			'defaults' => new stdClass,
			'params' => array(
				'general' => array(
					'formCaptcha' => array(
						'type' => 'select',
						'options' => array(
							'0' => 'No Captcha',
							'1' => 'ReCaptcha',
							'2' => 'Securimage'
						),
						'label' => 'Captcha Integration'
					)
				)
			),
			'tmpl' => 'Form Captcha'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}