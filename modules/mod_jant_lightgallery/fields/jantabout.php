<?php
 /**
 * @author JoomAnt Team
 * @copyright joomant.com
 * @link joomant.com
 * @package JAnt LightGallery
 * @version 1.0.0
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('_JEXEC') or die('Restricted index access');

jimport('joomla.form.formfield');
class JFormFieldJANTAbout extends JFormField
{
	public $type = 'JANTAbout';

	protected function getInput()
	{
		JHTML::stylesheet('jant_admin.css','modules/mod_jant_lightgallery/assets/css/admin/');
		$html = '';
		$html  .= '<table width="100%">';
		$html  .= '<tr><td width="150" valign="top">';
		$html  .= '<img src ="../modules/mod_jant_lightgallery/thumbnail.png" />';
		$html  .= '</td><td valign="top">';
		$html  .= '<h2><a href="http://www.joomant.com" target="_blank">JANT LightGallery</a></h2><hr />';
		$html  .= '<p>'.JText::_('JANT_VERSION').': <strong class="jsn-current-version">1.0.0</strong></p>';
		$html  .= '<p>'.JText::_('JANT_AUTHOR').': <a target="_blank" title="http://www.joomant.com" href="http://www.joomant.com">http://www.joomant.com</a></p>';
		$html  .= '<p>'.JText::_('JANT_COPYRIGHT').': Copyright (C) 2011 - 2012 JoomAnt. All rights reserved.</p>';
		$html  .= '<p>'.JText::_('JANT_EMAIL').': <a title="joomant@gmail.com" href="mailto:joomant@gmail.com">joomant@gmail.com</a></p>';
		$html  .= '</td></tr></table>';
		return $html;
	}
}