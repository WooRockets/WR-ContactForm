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

class WR_CF_Gadget_Controls_Form_Actions {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Buttons element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'form-actions';
		$options = array(
			'caption' => 'Form Action',
			'group' => 'extra',
			'defaults' => array(
				'btnSubmit' => 'Submit',
				'btnReset' => 'Reset',
				'btnNext' => 'Next',
				'btnPrev' => 'Prev'
			),
			'params' => array(
				'general' => array(
					'btnSubmit' => array(
						'type' => 'text',
						'label' => 'Submit Button Text'
					),
					'stateBtnReset' => array(
						'type' => 'radio',
						'options' => array(
							'No' => 'No',
							'Yes' => 'Yes'
						),
						'class' => 'radio inline',
						'label' => 'Show Button Reset'
					),
					'btnReset' => array(
						'type' => 'text',
						'label' => 'Reset Button Text',
						'attrs' => array(
							'class' => 'hide'
						)
					),
					'btnNext' => array(
						'type' => 'text',
						'label' => 'Next Button Text'
					),
					'btnPrev' => array(
						'type' => 'text',
						'label' => 'Prev Button Text'
					)
				),
				'quickeditstyle' => array(
					'tab' => 'Buttons'
				)
			),
			'tmpl' => 'Form Action'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}