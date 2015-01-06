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

class WR_CF_Gadget_Controls_Static_Content {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Text element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'static-content';
		$options = array(
			'caption' => 'Text',
			'group' => 'standard',
			'defaults' => array(
				'label' => 'Text',
				'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris fermentum odio sed ipsum fringilla ut tempor magna accumsan. Aliquam erat volutpat. Vestibulum euismod ipsum non risus dignissim hendrerit. Nam metus arcu, blandit in cursus nec, placerat vitae arcu. Maecenas ornare porta mi, et tincidunt nulla luctus non.”'
			),
			'params' => array(
				'general' => array(
					'value' => array(
						'type' => 'textarea',
						'label' => 'Text',
						'attrs' => array(
							'rows' => '6'
						)
					),
					'customClass' => array(
						'type' => 'text',
						'label' => 'Class'
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><hideField/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><div class="controls clearfix">{{html value}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}