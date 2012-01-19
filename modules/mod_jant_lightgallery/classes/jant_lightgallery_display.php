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

class JANTLightGalleryDisplay
{
	function JANTLightGalleryDisplay() {}

	function build($datas)
	{
		$images				= $datas->images;

		if (!count($images)) return '';

		JHTML::script('jquery.min.js','https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/');
		JHTML::script('galleria-1.2.5.js', 'modules/mod_jant_lightgallery/assets/js/galleria/');
		JHTML::script('galleria.classic.js', 'modules/mod_jant_lightgallery/assets/js/galleria/themes/classic/');

		$objJANTLighGalleryUtils 	= new JANTLightGalleryUtils();
		$doc   						=& JFactory::getDocument();

		$javascriptWidth 			= '';
		$javascriptAutoPlay 		= '';
		$javascriptPresentationMode = '';

		$css 				= $this->buildCSS($datas);
		$percent  			= strpos($datas->width, '%');
		$uri				= $objJANTLighGalleryUtils->getURI();

		if (!$percent)
		{
			$javascriptWidth = 'width:'.$datas->width.', ';
		}
		if ($datas->auto_play)
		{
			$javascriptAutoPlay = 'autoplay:'.(int) $datas->sliding_time.'000, ';
		}
		else
		{
			$javascriptAutoPlay = 'autoplay:false,';
		}
		if ($datas->presentation_mode == 'fit-in')
		{
			$javascriptPresentationMode = 'imageCrop: false,';
		}
		elseif ($datas->presentation_mode == 'expand-out')
		{
			$javascriptPresentationMode = 'imageCrop: true,';
		}

		$javascriptThumbnailHeight		= 'thumbHeight:'.$datas->thumb_height.', ';
		$javascriptShowThumbnail 		= 'thumbnails: '.$datas->show_thumb_panel.', ';
		$javascriptShowImageNavigation	= 'showImagenav: '.$datas->show_image_navigation.', ';
		$javascriptTransitionTiming		= 'transitionSpeed: '.$datas->img_transition_time.', ';
		$javascriptTransitiontype		= 'transition: "'.$datas->img_transition_type.'", ';
		$javascriptQueue				= 'queue: false, ';
		$html  					= '<div id="jant-lightgallery-'.$datas->random_string.'"><div id="jant-lightgallery-'.$datas->random_string.'-container">'."\n";

		for($i = 0, $counti = count($images); $i < $counti; $i++)
		{
			$image = $images[$i];
			$html .= '<a href="'.$uri.$datas->path.$image.'"><img title="'.$image.'" alt="'.$image.'" src="'.$uri.$datas->path.$image.'" /></a>'."\n";
		}

		$doc->addStyleDeclaration($css);
		$html .= '</div></div>'."\n";
		$html .= '<div style="text-align:center;"><a href="http://localhost/rancho" title="rancho13prudentino" target="_blank">http://localhost/rancho</a></div>'."\n"; 

/*		$html .= '<div style="text-align:center;"><a href="http://www.joomant.com" title="Joomla Templates and Joomla Extensions - JoomAnt" target="_blank">http://www.joomant.com</a></div>'."\n"; */

		$html .= '<script>jQuery.noConflict();  (function($) {$("#jant-lightgallery-'.$datas->random_string.'-container").galleria({'.$javascriptWidth.$javascriptAutoPlay.$javascriptShowThumbnail.$javascriptShowImageNavigation.$javascriptThumbnailHeight.$javascriptTransitionTiming.$javascriptPresentationMode.$javascriptQueue.$javascriptTransitiontype.'height:'.$datas->height.', initialTransition: "fade", thumbCrop: false, thumbFit: false, thumbQuality: false, showCounter: false, showInfo: false, imageTimeout: 300000, pauseOnInteraction: false});})(jQuery);</script>';
		return $html;
	}

	function render($datas)
	{
		$string			= '';
		$string 		.= $this->build($datas);
		return $string;
	}

	function buildCSS($datas)
	{
		$css = '';

		$percent  = strpos($datas->width, '%');

		$css .= '#jant-lightgallery-'.$datas->random_string.'{
	    			width: '.$datas->width.((!$percent)?'px':'').';
	    			height: '.$datas->height.'px;
	    			background-color: #fffff;
	    			display:inline-table;
				}'."\n";

		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-container {
	    			margin: 0 auto;
	    			padding: 0;
	    			background :'.$datas->img_panel_background.';
	    			border: '.$datas->gallery_boder.'px solid '.$datas->gallery_boder_color.';
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails-container{
	    			background-color: '.$datas->thumb_panel_background.';
	    			left: 0;
				    right: 0;
				    width: 100%;
					height: '.($datas->thumb_height + 15).'px;
					display:none;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-container .galleria-stage{
	    			position: absolute;
				    top:5%;
				    bottom: 5%;
				    left: 5%;
				    right: 5%;
				    overflow:hidden;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails  {
					height: '.($datas->thumb_height + 4).'px;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails .galleria-image {
    				width: '.$datas->thumb_width.'px;
    				height: '.$datas->thumb_height.'px;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails .galleria-image {
	    			border: '.$datas->thumb_border.'px solid '.$datas->thumnail_normal_state_color.';
	    			filter: alpha(opacity=50);
					-moz-opacity:0.5;
					-khtml-opacity: 0.5;
					opacity: 0.5;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails .galleria-image:hover {
	    			border: '.$datas->thumb_border.'px solid '.$datas->thumnail_active_state_color.';
	    			filter: alpha(opacity=100);
					-moz-opacity: 1;
					-khtml-opacity: 1;
					opacity: 1;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails .active {
	    			border: '.$datas->thumb_border.'px solid '.$datas->thumnail_active_state_color.';
	    			filter: alpha(opacity=100);
					-moz-opacity: 1;
					-khtml-opacity: 1;
					opacity: 1;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails-list {
					margin-top: 5px;
    				margin-left: 10px;
    				margin-bottom: 5px;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-carousel .galleria-thumbnails-list {
					margin-left: 30px;
   					margin-right: 30px;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails-container .galleria-thumb-nav-right{
					  background-position: -578px '.(($datas->thumb_height - 20)/2).'px;
					  height: '.($datas->thumb_height + 15).'px;
				}'."\n";
		$css .= '#jant-lightgallery-'.$datas->random_string.' .galleria-thumbnails-container .galleria-thumb-nav-left{
					  background-position: -495px '.(($datas->thumb_height - 20)/2).'px;
					  height: '.($datas->thumb_height + 15).'px;
				}'."\n";

		return $css;
	}
}
