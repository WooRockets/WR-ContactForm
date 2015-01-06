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

class WR_CF_Gadget_Controls_Currency {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Currency element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'currency';
		$options = array(
			'caption' => 'Currency',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Currency',
				'instruction' => '',
				'required' => 0,
				'format' => 'Dollars',
				'value' => '',
				'showCurrencyTitle' => 'Yes'
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
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><required/><hideField/></div><div class="pull-right"></div><div class="clearbreak"></div></div>',
						'elements' => array(
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
					'extra' => array(
						'type' => 'horizontal',
						'decorator' => '<value/><span class="wr-field-prefix">.</span><cents/>',
						'title' => 'Predefined Value',
						'elements' => array(
							'value' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'currency',
								'attrs' => array(
									'class' => 'input-medium'
								)
							),
							'cents' => array(
								'type' => 'text',
								'group' => 'horizontal',
								'field' => 'currency',
								'attrs' => array(
									'class' => 'input-mini'
								)
							)
						)
					),
					'format' => array(
						'type' => 'select',
						'label' => 'Currency Format',
						'options' => array( 'Haht' => '฿ Baht', 'Dollars' => '$ Dollars', 'Euros' => '€ Euros', 'Forint' => 'Ft Forint', 'Francs' => 'CHF Francs', 'Koruna' => 'Kč Koruna', 'Krona' => 'kr Krona', 'Pesos' => '$ Pesos', 'Pounds' => '£ Pounds Sterling', 'Ringgit' => 'RM Ringgit', 'Shekel' => '₪ Shekel', 'Yen' => '¥ Yen', 'Zloty' => 'zł Złoty', 'Rupee' => '₹ Rupee' )
					),
					'extraShowTitle' => array(
						'type' => 'group',
						'decorator' => '<div class="form-inline"><showCurrencyTitle/><div>',
						'title' => 'Predefined Value',
						'elements' => array(
							'showCurrencyTitle' => array(
								'type' => 'radio',
								'label' => 'Show Currency Title',
								'options' => array(
									'Yes' => 'Yes',
									'No' => 'No'
								)
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><label class="control-label">${label}{{if required==1||required=="1"}}<span class="required">*</span>{{/if}}{{if instruction}}<i class="icon-question-sign"></i><p class="wr-help-text">${instruction}</p>{{/if}}</label><div class="controls clearfix"><div class="input-prepend wr-inline currency-value"><div class="controls-inner"><span class="add-on">{{if format=="Haht"}}฿{{else format=="Rupee"}}₹{{else format=="Dollars"}}&#36;{{else format=="Euros"}}€{{else format=="Forint"}}Ft{{else format=="Francs"}}CHF{{else format=="Koruna"}}Kč{{else format=="Krona"}}kr{{else format=="Pesos"}}&#36;{{else format=="Pounds"}}£{{else format=="Ringgit"}}RM{{else format=="Shekel"}}₪{{else format=="Yen"}}¥{{else format=="Zloty"}}zł{{/if}}</span><input class="input-medium" type="text" placeholder="${value}" /></div>{{if showCurrencyTitle=="Yes"}}<span class="wr-help-block-inline">${format}</span>{{/if}}</div>{{if format!="Yen" && format!="Rupee"}}<div class="wr-inline currency-cents"><div class="controls-inner"><input class="input-mini" type="text" placeholder="${cents}" /></div>{{if showCurrencyTitle=="Yes"}}<span class="wr-help-block-inline">{{if format=="Haht"}}Satang{{else format=="Dollars"}}Cents{{else format=="Euros"}}Cents{{else format=="Forint"}}Filler{{else format=="Francs"}}Rappen{{else format=="Koruna"}}Haléřů{{else format=="Krona"}}Ore{{else format=="Pesos"}}Cents{{else format=="Pounds"}}Pence{{else format=="Ringgit"}}Sen{{else format=="Shekel"}}Agora{{else format=="Zloty"}}Grosz{{/if}}</span>{{/if}}</div>{{/if}}</div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}