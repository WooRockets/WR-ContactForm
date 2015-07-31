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

class WR_CF_Gadget_Controls_Name {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Name element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'name';
		$options = array(
			'caption' => 'Name',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Name',
				'instruction' => '',
				'required' => 0,
				'size' => 'jsn-input-mini-fluid',
				'items' => array(
					array(
						'text' => 'Mrs',
						'checked' => false
					),
					array(
						'text' => 'Mr',
						'checked' => true
					),
					array(
						'text' => 'Ms',
						'checked' => false
					),
					array(
						'text' => 'Baby',
						'checked' => false
					),
					array(
						'text' => 'Master',
						'checked' => false
					),
					array(
						'text' => 'Prof',
						'checked' => false
					),
					array(
						'text' => 'Dr',
						'checked' => false
					),
					array(
						'text' => 'Gen',
						'checked' => false
					),
					array(
						'text' => 'Rep',
						'checked' => false
					),
					array(
						'text' => 'Sen',
						'checked' => false
					),
					array(
						'text' => 'St',
						'checked' => false
					)
				)
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
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="row-fluid"><div class="span6 jsn-items-list-container" id="wr-field-name"><label for="option-name-itemlist" class="control-label">Fields</label><ul class="jsn-items-list ui-sortable"><vtitle/><vfirst/><vmiddle/><vlast/></ul><sortableField/></div><div id="wr-name-default-titles" class="span6"><items/></div></div>',
						'title' => 'Predefined Value',
						'elements' => array(
							'items' => array(
								'type' => 'itemlist',
								'label' => 'Titles'
							),
							'vtitle' => array(
								'field' => 'name',
								'type' => 'checkbox',
								'label' => __( 'Titles', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vfirst' => array(
								'field' => 'name',
								'type' => 'checkbox',
								'label' => __( 'First', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vmiddle' => array(
								'field' => 'name',
								'type' => 'checkbox',
								'label' => __( 'Middle', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'vlast' => array(
								'field' => 'name',
								'type' => 'checkbox',
								'label' => __( 'Last', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'sortableField' => array(
								'type' => 'hidden'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls">{{if vtitle}}<select class="input-small" >{{each(i, val) items}}<option value="${val.text}" {{if val.checked == true || val.checked=="true"}}selected{{/if}}>${val.text}</option>{{/each}}</select>&nbsp;{{/if}}{{if vfirst}}<input type="text" class="${size}" placeholder="' . __( 'First', WR_CONTACTFORM_TEXTDOMAIN ) . '" />&nbsp;{{/if}}{{if vmiddle}}<input type="text" class="${size}" placeholder="' . __( 'Middle', WR_CONTACTFORM_TEXTDOMAIN ) . '" />&nbsp;{{/if}}{{if vlast}}<input type="text" class="${size}" placeholder="' . __( 'Last', WR_CONTACTFORM_TEXTDOMAIN ) . '" />{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}