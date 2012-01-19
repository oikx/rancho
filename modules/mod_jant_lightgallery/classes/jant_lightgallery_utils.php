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

class JANTLightGalleryUtils
{
	function JANTLightGalleryUtils() {}

    function convertFromBoolToString($bool)
	{
        $bool = (boolean) $bool;
		if ($bool)
		{
            return 'true';
        }
        return 'false';
    }

	function randString($length)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen($chars);
		$str   = '';
		for ($i = 0; $i < $length; $i++ )
		{
			$str .= $chars[rand(0, $size - 1)];
		}
		return $str;
	}

	function getURI()
	{
		$pathURL 			= array();
		$uri				=& JURI::getInstance();
		$pathURL['prefix'] 	= $uri->toString( array('scheme', 'host', 'port'));

		if (strpos(php_sapi_name(), 'cgi') !== false && !ini_get('cgi.fix_pathinfo') && !empty($_SERVER['REQUEST_URI']))
		{
			$pathURL['path'] =  rtrim(dirname(str_replace(array('"', '<', '>', "'"), '', $_SERVER["PHP_SELF"])), '/\\');
		}
		else
		{
			$pathURL['path'] =  rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
		}
		return $pathURL['prefix'].$pathURL['path'].'/';
	}
}