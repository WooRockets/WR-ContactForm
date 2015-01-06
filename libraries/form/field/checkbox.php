<?php
/**
 * @version    $Id$
* @package    WR_Plugin_Framework
* @author     InnoThemes Team <support@innothemes.com>
* @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
* @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*
* Websites: http://www.innothemes.com
* Technical Support:  Feedback - http://www.innothemes.com/contact-us/get-support.html
*/

/**
 * Check box field renderer.
*
* @package  WR_Plugin_Framework
* @since    1.0.0
*/
class WR_CF_Form_Field_Checkbox extends WR_CF_Form_Field {
	/**
	 * Field type.
	 *
	 * @var  string
	 */
	protected $type = 'checkbox';

	/**
	 * Default HTML attributes for input field element.
	 *
	 * @var  array
	 */
	protected $attributes = array(
		'autocomplete' => 'off',
		'class'        => '',
		'type'         => 'checkbox',
	);

	/**
	 * Indicate whether checkbox(es) should be rendered inline or not?
	 *
	 * @var  boolean
	 */
	protected $inline = true;

	/**
	 * Check box options.
	 *
	 * @var  array
	 */
	protected $choices = array();
}
