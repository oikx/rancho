<?php
/**
 * @version		$Id: type.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License, see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

/**
 * Form Field Place class.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_installer
 * @since		1.6
 */
class JFormFieldType extends JFormField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Type';

	/**
	 * Method to get the field input.
	 *
	 * @return	string		The field input.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
		$options = array();
		foreach ($this->element->children() as $option) {
			$options[] = JHtml::_('select.option', $option->attributes('value'), JText::_(trim($option->data())));
		}

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('type')->from('#__extensions');
		$db->setQuery($query);
		$types = array_unique($db->loadResultArray());
		foreach($types as $type)
		{
			$options[] = JHtml::_('select.option', $type, JText::_('COM_INSTALLER_TYPE_'. strtoupper($type)));
		}

		$return = JHtml::_('select.genericlist', $options, $this->name, $onchange, 'value', 'text', $this->value, $this->id);

		return $return;
	}
}
