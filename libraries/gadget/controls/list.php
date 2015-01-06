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

class WR_CF_Gadget_Controls_List {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register List element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'list';
		$options = array(
			'caption' => 'List',
			'group' => 'standard',
			'defaults' => array(
				'label' => 'List',
				'instruction' => '',
				'required' => 0,
				'size' => 'jsn-input-fluid',
				'items' => array(
					array(
						'text' => 'Value 1',
						'checked' => false
					),
					array(
						'text' => 'Value 2',
						'checked' => false
					),
					array(
						'text' => 'Value 3',
						'checked' => false
					)
				),
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
									'jsn-input-fluid' => 'Auto',
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
					'items' => array(
						'type' => 'itemlist',
						'label' => 'Items',
						'actionField' => false,
						'multipleCheck' => true
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><multiple/></div><div class="pull-right"><randomize/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'multiple' => array(
								'type' => 'checkbox',
								'label' => 'Allow multiple selection'
							),
							'randomize' => array(
								'type' => 'checkbox',
								'label' => 'Randomize Items'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><select multiple class="${size}" >{{each(i, val) items}}<option value="${val.text}" {{if val.checked == true || val.checked=="true"}}selected{{/if}}>${val.text}</option>{{/each}}</select></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}