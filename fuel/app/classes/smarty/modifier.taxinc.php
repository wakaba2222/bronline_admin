<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     nl2br_html<br>
 * Date:     Sep 20, 2008
 * Purpose:  convert \r\n, \r or \n to <<br />>. However, the HTML tag is considered.
 * Example:  {$text|nl2br_html}
 * @author   Seasoft 塚田将久
 * @param string
 * @return string
 */
function smarty_modifier_taxinc($price, $tax, $tax_rule) {
	return $price + SC_Utils_Ex::sfTax($price, $tax, $tax_rule);
}
