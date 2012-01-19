<?php
/**
 * @author JoomAnt Team
 * @copyright joomant.com
 * @link joomant.com
 * @package JAnt LightGallery
 * @version 1.0.0
 * @license GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
class JANTLightGalleryMedia
{
	function getImages($path)
	{
		$rootPath 	= JPATH_ROOT.DS.'images';
		if ($path != '')
		{
			$rootPath 	= $rootPath.DS.$path;
		}
		$rootPath 	= str_replace('/', DS,JPATH_ROOT.DS.'images'.DS.$path);
		$mediaPath 	= str_replace(DS, '/', $rootPath.'/');
		$images 	= array ();
		$fileList 	= JFolder::files($rootPath);
		$folderList = JFolder::folders($rootPath);
		if ($fileList !== false)
		{

			foreach ($fileList as $file)
			{
				if (@is_file($rootPath.DS.$file))
				{
					$ext = strtolower(JFile::getExt($file));
					switch ($ext)
					{
						case 'jpg':
						case 'png':
						case 'gif':
						case 'xcf':
						case 'odg':
						case 'bmp':
						case 'jpeg':
							$images [] = $file;
						break;
						default:
						break;
					}
				}
			}
		}
		return $images;
	}
}