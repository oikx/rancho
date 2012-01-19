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
jimport('joomla.filesystem.folder');
class JFormFieldJANTDropBoxImageFolder extends JFormField
{
	public $type = 'JANTDropBoxImageFolder';

	protected function getInput()
	{
		$html 		= '';
		$options 	= array();
		$base 		= JPATH_ROOT.DS.'images';

		$attr 		= '';
		$attr 		.= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		$options[] 	= JHTML::_('select.option', '', JText::_('JANT_SELECT_FOLDER'));
		$folders   	= JFolder::folders($base, '.', true, true);
		foreach ($folders as $folder)
		{
			$folder 	= str_replace($base, '', $folder);
			$value		= str_replace(DS, '/', substr($folder, 1));
			$text	 	= str_replace(DS, '/', $folder);
			$options[] 	= JHTML::_('select.option', $value, $text);
		}
		if (is_array($options))
		{
			sort($options);
		}

		$html = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);

		return $html;
	}

}