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

class WR_CF_Gadget_Controls_Likert {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Likert element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'likert';
		$options = array(
			'caption' => 'Likert',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Likert',
				'instruction' => '',
				'required' => 0,
				'size' => 'jsn-input-mini-fluid',
				'rows' => array(
					array(
						'text' => 'Statement 1',
						'checked' => false
					),
					array(
						'text' => 'Statement 2',
						'checked' => false
					),
					array(
						'text' => 'Statement 3',
						'checked' => false
					)
				),
				'columns' => array(
					array(
						'text' => 'Good',
						'checked' => false
					),
					array(
						'text' => 'Average',
						'checked' => false
					),
					array(
						'text' => 'Poor',
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'required' => array(
								'type' => 'checkbox',
								'label' => 'Required'
							),
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							)
						)
					)
				),
				'values' => array(
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="row-fluid"><div class="span6 jsn-items-list-container" id="wr-rows-likert"><rows/></div><div id="jsn-columns-likert" class="span6"><columns/></div></div>',
						'title' => 'Predefined Value',
						'elements' => array(
							'rows' => array(
								'type' => 'itemlist',
								'label' => 'Rows',
								'classHidden' => 'hide'
							),
							'columns' => array(
								'type' => 'itemlist',
								'label' => 'Columns',
								'classHidden' => 'hide'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls"><table class="table table-bordered table-striped"><thead><th></th>{{each(i, column) columns}}<th class="center">${column.text}</th>{{/each}}</thead><tbody>{{each(j, row) rows}}<tr><td>${row.text}</td>{{each(i, column) columns}}<td class="center"><input type="radio"/></td>{{/each}}</tr>{{/each}}</tbody></table></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}