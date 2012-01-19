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
class JFormFieldJANTColorPicker extends JFormField{

	public $type = 'JANTColorPicker';

	protected function getInput()
	{
		JHTML::stylesheet('colorpicker.css','modules/mod_jant_lightgallery/assets/css/admin/colorpicker/');
		JHTML::script('jquery.min.js','https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/');
		JHTML::script('colorpicker.js','modules/mod_jant_lightgallery/assets/js/admin/colorpicker/');

		$doc		= JFactory::getDocument();

		$html		= '';
		$size		= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$maxLength	= $this->element['maxlength'] ? ' maxlength="'.(int) $this->element['maxlength'].'"' : '';
		$class		= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';
		$readonly	= ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
		$disabled	= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		$script			 = 'jQuery.noConflict();'."\n";
		$script			.= '(function($){'."\n";
		$script		 	.= '$(document).ready(function () {'."\n";
		$script		 	.= '$("#'.$this->id.'").ColorPicker({'."\n";
		$script		 	.= 'onSubmit: function(hsb, hex, rgb, el) {'."\n";
		$script		 	.= '$(el).val(hex);'."\n";
		$script		 	.= '$(el).ColorPickerHide();'."\n";
		$script		 	.= '},'."\n";
		$script		 	.= 'onBeforeShow: function () {'."\n";
		$script		 	.= '$(this).ColorPickerSetColor(this.value);'."\n";
		$script		 	.= '},'."\n";
		$script		 	.= 'onChange: function (hsb, hex, rgb) {'."\n";
		$script		 	.= '$("#'.$this->id.'").val("#" + hex);'."\n";
		$script		 	.= '}'."\n";
		$script		 	.= '})'."\n";
		$script		 	.= '.bind("keyup", function(){'."\n";
		$script		 	.= '$(this).ColorPickerSetColor(this.value);'."\n";
		$script		 	.= '});'."\n";
		$script		 	.= '});'."\n";
		$script		 	.= '})(jQuery)'."\n";

		$doc->addScriptDeclaration($script);
		$html		= '<input type="text" name="'.$this->name.'" id="'.$this->id.'" value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"'.$size.$maxLength.$class.$readonly.$disabled.' />';
		return	$html;
	}
}
