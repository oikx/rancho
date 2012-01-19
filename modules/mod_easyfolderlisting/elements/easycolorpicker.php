<?php
/**
* @version		1.1 (J16)
* @author		Michael A. Gilkes (jaido7@yahoo.com)
* @copyright	Michael Albert Gilkes
* @license		GNU/GPLv2
*/

/*

Easy Folder Listing Module for Joomla! 1.6+
Copyright (C) 2010-2011  Michael Albert Gilkes

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

/**
* I m using a jQuery color picker instead of Mootools alternatives. To be honest, I 
* have used this one before, and I like the way it works. (Michael Gilkes)
*
* Official Name:	Color Picker - jQuery Plugin
* Author:			Stefan Petre
* Website:			http://www.eyecon.ro/colorpicker/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

//get joomla form related functions
jimport('joomla.form.formfield');

class JFormFieldEasyColorPicker extends JFormField
{
	//define location of files
	const SEGMENT = 'modules/mod_easyfolderlisting/';
	
	//specify the custom field type
	protected $type = 'easycolorpicker';
	
	//setup the custom field's details
	protected function getInput()
	{
		//get the hosts name
		$host = JURI::root();
		
		//get the JDocument instance
		$document =& JFactory::getDocument();
		
		//add link to jQuery
		$document->addScript($host.self::SEGMENT.'scripts/jquery-1.6.1.min.js');
		
		//add reference to javascript and css specific to the color picker
		$document->addScript($host.self::SEGMENT.'scripts/colorpicker.js');
		$document->addStyleSheet($host.self::SEGMENT.'css/colorpicker.css');
		
		//get the custom javascript
		$javascript = $this->setupScript();
		
		//add the javascript to the head of the html document
		$document->addScriptDeclaration($javascript);
		
		// Initialize some field attributes.
		$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$maxLength	= $this->element['maxlength'] ? ' maxlength="'.(int) $this->element['maxlength'].'"' : '';
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		// Initialize JavaScript field attributes.
		$onchange	= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		$html = '<input type="text" name="'.$this->name.'" id="'.$this->id.'"' .
				' value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"' .
				$class.$size.$disabled.$readonly.$onchange.$maxLength.'/>';
		
		return $html;
	}
	
	protected function setupScript()
	{
		$js = '/* -- Start Easy Color Picker Javascript -- */'."\n\n";
		$js.= "jQuery.noConflict()(function(){\n\n";
		$js.= 'jQuery(document).ready(function(){'."\n";
		$js.= "\njQuery('#".$this->id."').css('backgroundColor', jQuery('#".$this->id."').val());\n";
		$js.= "\tjQuery('#".$this->id."').ColorPicker({\n";
		$js.= "\t\tonSubmit: function(hsb, hex, rgb, el) {\n";
		$js.= "\t\t\t".'jQuery(el).val("#"+hex);'."\n";
		$js.= "\t\t\t".'jQuery(el).ColorPickerHide();'."\n";
		$js.= "\t\t\tjQuery(el).css('backgroundColor', '#' + hex);\n";
		$js.= "\t\t},\n";
		$js.= "\t\tonBeforeShow: function () {\n";
		$js.= "\t\t\t".'jQuery(this).ColorPickerSetColor(this.value);'."\n";
		$js.= "\t\t".'}'."\n";
		$js.= "\t".'})'."\n";
		$js.= "\t".'.bind(\'keyup\', function(){'."\n";
		$js.= "\t\t".'jQuery(this).ColorPickerSetColor(this.value);'."\n";
		$js.= "\t".'});'."\n";
		$js.= '});'."\n\n";
		$js.= "});\n";
		$js.= '/*  -- End  Easy Color Picker Javascript --  */'."\n";
		
		return $js;
	}
}