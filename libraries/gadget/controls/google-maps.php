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

class WR_CF_Gadget_Controls_Google_Maps {
	
	/**
	 * Constructor.
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Prepare script to register Google Maps element.
	 * 
	 * @return string
	 */
	public static function register() {
		$identify = 'google-maps';
		$options = array(
			'caption' => 'Google Maps',
			'group' => 'extra',
			'defaults' => array(
				'label' => 'Google Maps',
				'width' => 100,
				'formatWidth' => '%',
				'height' => 300,
				'googleMaps' => '{"center":{"lb":12.372121848436315,"mb":-0.6382415506872352},"zoom":1}'
			),
			'params' => array(
				'general' => array(
					'customClass' => array(
						'type' => 'text',
						'label' => 'Class'
					),
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="row-fluid"><div class="pull-left"><div class="control-group"><label for="option-width-number" class="control-label">Width</label><div class="controls input-append"><width/><formatWidth/></div></div></div><div class="pull-right"><div class="control-group"><label for="option-width-number" class="control-label">Height</label><div class="controls input-append"><height/><span class="add-on">px</span></div></div></div></div><div class="jsn-form-bar"><div class="pull-left"><hideField/></div><div class="clearbreak"></div></div>',
						'elements' => array(
							'hideField' => array(
								'type' => 'checkbox',
								'label' => 'Hidden'
							),
							'width' => array(
								'type' => 'number',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'attrs' => array(
									'class' => 'number input-small'
								)
							),
							'formatWidth' => array(
								'type' => 'select',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'options' => array(
									'%' => '%',
									'px' => 'px'
								),
								'attrs' => array(
									'class' => 'add-on input-mini'
								)
							),
							'height' => array(
								'type' => 'number',
								'group' => 'horizontal',
								'field' => 'input-inline',
								'attrs' => array(
									'class' => 'number input-small'
								)
							)
						)
					)
				),
				'values' => array(
					'extra' => array(
						'type' => 'group',
						'decorator' => '<div class="jsn-form-bar"><div class="pull-left"><div id="google-maps-search"><div class="wr-search-google-maps"><input id="places-search" placeholder="Search…" class="input search-query btn-icon input-xlarge" type="text"/><a href="javascript:void(0);" title="Clear Search" class="jsn-reset-search"><i class="icon-remove"></i></a></div></div></div><div class="pull-right"><div class="btn-group"><button type="button" class="btn btn-google-location btn-icon"><i class="icon-location"></i></button></div></div><div class="clearbreak"></div></div><div class="row-fluid"><div class="google_maps map rounded"></div><div id="marker-google-maps" class="hide"><googleMaps/><googleMapsMarKer/></div></div>',
						'title' => 'Predefined Value',
						'elements' => array(
							'googleMaps' => array(
								'type' => 'hidden'
							),
							'googleMapsMarKer' => array(
								'type' => 'hidden'
							)
						)
					)
				)
			),
			'tmpl' => '<div class="control-group ${customClass} {{if hideField}}wr-hidden-field{{/if}}"><div class="content-google-maps clearfix" data-width="${width}${formatWidth}" data-height="${height}" data-value="${googleMaps}" data-marker="${googleMapsMarKer}"><div class="google_maps map rounded"></div></div></div>'
		);
		
		return 'JSNVisualDesign.register("' . $identify . '", ' . json_encode($options) . ');';
	}
}