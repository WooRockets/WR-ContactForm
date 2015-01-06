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

class WR_CF_Gadget_Controls_Choices {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Radio Buttons element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'choices';
		$options = array(
			'caption' => 'Radio Buttons',
			'group' => 'standard',
			'defaults' => array(
				'label' => 'Radio Buttons',
				'instruction' => '',
				'required' => 0,
				'randomize' => 0,
				'labelOthers' => 'Others',
				'layout' => 'columns-count-one',
				'items' => array(
					array(
						'text' => 'Choice 1',
						'checked' => true
					),
					array(
						'text' => 'Choice 2',
						'checked' => false
					),
					array(
						'text' => 'Choice 3',
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
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"><layout/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'layout' => array(
								'type' => 'select',
								'label' => 'Layout',
								'options' => array(
									'jsn-columns-count-one' => 'One Column',
									'jsn-columns-count-two' => 'Two Columns',
									'jsn-columns-count-three' => 'Three Columns',
									'jsn-columns-count-no' => 'Side by Side'
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
						'actionField' => true,
						'multipleCheck' => false
					),
					'itemAction' => array(
						'type' => 'hidden'
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><div class="control-group {{if hideField}}wr-hidden-field{{/if}}"><div class="controls wr-allow-other"><allowOther/><labelOthers/></div></div></div><div class="pull-right"><randomize/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'allowOther' => array(
								'type' => 'checkbox',
								'field' => 'allowOther',
								'label' => __( 'WR_CONTACTFORM_ALLOW_USER_CHOICE', WR_CONTACTFORM_TEXTDOMAIN )
							),
							'labelOthers' => array(
								'type' => '_text',
								'field' => 'allowOther',
								'attrs' => array(
									'class' => 'text jsn-input-small-fluid'
								)
							),
							'randomize' => array(
								'type' => 'checkbox',
								'label' => 'Randomize Items'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><div class="jsn-columns-container ${layout}">{{each(i, val) items}}<div class="jsn-column-item"><label class="radio"><input name="${identify}" type="radio" {{if val.checked == true || val.checked=="true"}}checked{{/if}} />${val.text}</label></div>{{/each}}{{if allowOther}}<div class="jsn-column-item"><label class="radio lbl-allowOther"><input class="allowOther" value="Others" type="radio" />${labelOthers}</label><textarea rows="3"></textarea></div>{{/if}}<div class="clearbreak"></div></div></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}