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

class modJAntLightGalleryHelper
{
	function render(&$params)
	{
		global $mainframe;

		$object 					= new stdClass();
		$objJANTLighGalleryMedia 	= new JANTLightGalleryMedia();
		$objJANTLighGalleryDisplay 	= new JANTLightGalleryDisplay();
		$objJANTLighGalleryUtils 	= new JANTLightGalleryUtils();

		//======== REQUIRED PARAMETERS ========

		$folder 	= $params->get('folder_path', '');

		//======== APPEARANCE PARAMETERS ========

		$overWidth 			= $params->get('width', '100%');
		$overHeight 		= $params->get('height', '250');
		$galleryBorderColor = $params->get('gallery_border_color', '#000000');
		$galleryBorder		= $params->get('gallery_border', '2');

		//======== SLIDESHOW PARAMETERS ========

		$autoPlay 		= $params->get('auto_play', '1');
		$slidingTime 	= $params->get('sliding_time', '5000');

		//======== THUMB PANEL PARAMETERS ========

		$showThumbPanel 		= $params->get('show_thumb_panel', '1');
		$thumbPanelBackground 	= $params->get('thumb_panel_background', '#000000');
		$normalState 			= $params->get('thumnail_normal_state_color', '#ffffff');
		$activeState 			= $params->get('thumnail_active_state_color', '#ff6200');
		$thumbWith 				= $params->get('thumb_width', '60');
		$thumbHeight 			= $params->get('thumb_height', '50');
		$thumbBorder 			= $params->get('thumb_border', '2');

		//======== TOOLBAR PANEL PARAMETERS ========

		$showImageNavigation = $params->get('show_image_navigation', '1');

		//======== IMAGE PANEL PARAMETERS ========
		$presentationMode		= $params->get('img_presentation_mode', 'fit-in');
		$imageTransitionType 	= $params->get('img_transition_type', 'slide');
		$imageTransitionTiming 	= $params->get('img_transition_time', '400');
		$backgroundColor 		= $params->get('img_panel_background', '#595959');

		$images = $objJANTLighGalleryMedia->getImages($folder);

		$object->width							= $overWidth;
		$object->height							= $overHeight;
		$object->gallery_boder_color			= $galleryBorderColor;
		$object->gallery_boder					= (int) $galleryBorder;
		$object->auto_play						= (int) $autoPlay;
		$object->sliding_time					= (int) $slidingTime;
		$object->show_thumb_panel				= $objJANTLighGalleryUtils->convertFromBoolToString($showThumbPanel);
		$object->thumb_panel_background			= $thumbPanelBackground;
		$object->thumnail_normal_state_color	= $normalState;
		$object->thumnail_active_state_color	= $activeState;
		$object->thumb_width					= (int) $thumbWith;
		$object->thumb_height					= (int) $thumbHeight;
		$object->thumb_border					= (int) $thumbBorder;
		$object->show_image_navigation			= $objJANTLighGalleryUtils->convertFromBoolToString($showImageNavigation);
		$object->presentation_mode				= $presentationMode;
		$object->img_transition_type			= $imageTransitionType;
		$object->img_transition_time			= (int) $imageTransitionTiming;
		$object->img_panel_background			= $backgroundColor;
		$object->random_string					= $objJANTLighGalleryUtils->randString(5);
		$object->path							= 'images/'.str_replace(DS, '/', $folder.'/');
		$object->images							= $images;

		echo $objJANTLighGalleryDisplay->render($object);
	}
}