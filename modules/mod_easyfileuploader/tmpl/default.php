<?php
/**
* @version		1.0 (J16)
* @author		Michael A. Gilkes (jaido7@yahoo.com)
* @copyright	Michael Albert Gilkes
* @license		GNU/GPLv2
*/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<!-- Input form for the File Upload -->
<form enctype="multipart/form-data" action="" method="post">
	<?php if ($params->get('efu_multiple') == "1"): ?>
	<label for=<?php echo '"'.$params->get('efu_variable').'[]"'; ?>><?php echo $params->get('efu_label'); ?></label>
	<?php else: ?>
	<?php echo $params->get('efu_label'); ?><br />
	<?php endif; ?>
	<?php 
	$max = intval($params->get('efu_multiple'));
	for ($i = 0; $i < $max; $i++): ?>
	<input type="file" name=<?php echo '"'.$params->get('efu_variable').'[]"'; ?> id=<?php echo '"'.$params->get('efu_variable').'[]"'; ?> style="margin-top:1px; margin-bottom:1px;" /> 
	<br />
	<?php endfor; ?>
	<?php if ($params->get('efu_replace') == "0"): /* 0 means Yes. 1 means No. */ ?>
	<div><?php echo $params->get('efu_question'); ?></div>
	<input type="radio" name="answer" value="0" /><?php echo $params->get('efu_yes'); ?><br />
	<input type="radio" name="answer" value="1" checked /><?php echo $params->get('efu_no'); ?><br />
	<br />
	<?php endif; ?>
	<input type="submit" name="submit" value=<?php echo '"'.$params->get('efu_button').'"'; ?> />
</form>
<!-- Display the Results of the file upload if uploading was attempted -->
<?php if (isset($_FILES[$params->get('efu_variable')])) : ?>
<div style="display:inline-block; position:relative; margin:1em; padding:1em; width:auto; background:<?php echo $params->get('results_bgcolor'); ?>; border: 1px solid grey;">
	<?php echo $result; ?>
</div>
<?php endif; ?>