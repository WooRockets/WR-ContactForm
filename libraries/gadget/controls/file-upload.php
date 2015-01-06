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

class WR_CF_Gadget_Controls_File_Upload {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register File Upload element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'file-upload';
		$options = array(
			'caption' => 'File Upload',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'File Upload',
				'instruction' => '',
				'required' => 0,
				'allowedExtensions' => 'png,jpg,gif,zip,rar,txt,doc,pdf',
				'maxSize' => 2,
				'maxSizeUnit' => 'MB'
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"><multiple/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'multiple' => array(
								'type' => 'checkbox',
								'label' => 'Multiple Upload'
							)
						)
					),
					'limit' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><allowedExtensions/></div><div class="jsn-form-bar"><maxSize/><maxSizeUnit/></div>',
						'elements' => array(
							'allowedExtensions' => array(
								'type' => 'text',
								'label' => 'Limit file extensions',
								'attrs' => array(
									'class' => 'input-large'
								)
							),
							'maxSize' => array(
								'type' => 'number',
								'label' => 'Limit file size',
								'attrs' => array(
									'class' => 'input-medium'
								)
							),
							'maxSizeUnit' => array(
								'type' => 'select',
								'options' => array(
									'KB' => 'KB',
									'MB' => 'MB'
								),
								'attrs' => array(
									'class' => 'input-small'
								)
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><input type="file" placeholder="${value}" /></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}