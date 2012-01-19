<?php
/**
* @version		1.1 (J16)
* @author		Michael A. Gilkes (jaido7@yahoo.com)
* @copyright	Michael Albert Gilkes
* @license		GNU/GPLv2
*/

/*

Easy Folder Listing Module for Joomla! 1.6+
Copyright (C) 2010  Michael Albert Gilkes

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

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');


class modEasyFolderListingHelper
{
	//this method retieves a formatted listing of the file names,
	//  which may include file extensions, modified dates, and size.
	//  it returns html text of the information
	function getFormattedListing(&$params)
	{
		//specify the folder
		$folder = modEasyFolderListingHelper::folderPath($params);
		$list = array();
		$result = "";
		
		//get a list of all the files in the folder
		$original = JFolder::files($folder);
		
		//create the final list that contains: name, ext, size, date
		$total = count($original);
		$index = 0;
		for($i = 0; $i < $total; $i++)
		{
			//check to see if the file type is forbidden
			if (stripos($params->get('efl_forbidden'), JFile::getExt($original[$i])) === false)
			{
				//remove the file extension and the dot from the filename
				$list[$index]['name'] = substr($original[$i], 0, -1*(1+strlen(JFile::getExt($original[$i]))));
				//add the extension
				$list[$index]['ext'] = JFile::getExt($original[$i]);
				//get the stats for the file
				$filestats = stat($folder.'/'.$original[$i]);
				$list[$index]['size'] = modEasyFolderListingHelper::sizeToText($filestats['size']);
				$list[$index]['bytes'] = $filestats['size'];
				$list[$index]['date'] = modEasyFolderListingHelper::formatDate($params, $filestats['mtime']);
				$index++;
			}
		}
		//sort the array in ascending order
		if ($params->get('efl_sortcolumn') == "name")
		{
			usort($list, "modEasyFolderListingHelper::compareName");
		}
		elseif ($params->get('efl_sortcolumn') == "size")
		{
			usort($list, "modEasyFolderListingHelper::compareSize");
		}
		elseif ($params->get('efl_sortcolumn') == "date")
		{
			usort($list, "modEasyFolderListingHelper::compareDate");
		}
		
		//sort in descending order
		if ($params->get('efl_sortdirection') == "desc")
		{
			$list = array_reverse($list);
		}
		
		//reset the array pointer
		reset($list);
		
		//format the display
		if ($params->get('efl_method') == "table")
		{
			//use the html table
			$result = modEasyFolderListingHelper::formatTable($params, $list, $folder);
		}
		else //use the unordered list
		{
			$result = modEasyFolderListingHelper::formatList($params, $list, $folder);
		}
		
		return $result;
	}
	
	protected static function compareName($x, $y)
	{
		if ($x['name'] == $y['name'])
		{
			return 0;
		}
		elseif ($x['name'] < $y['name'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
	
	protected static function compareSize($x, $y)
	{
		if ($x['bytes'] == $y['bytes'])
		{
			return 0;
		}
		elseif ($x['bytes'] < $y['bytes'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
	
	protected static function compareDate($x, $y)
	{
		if ($x['date'] == $y['date'])
		{
			return 0;
		}
		elseif ($x['date'] < $y['date'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
	
	protected static function formatTable(&$params, &$rows, $folder)
	{
		$total = count($rows); //get the total number of files
		$html = '<table style="width:100%; border-collapse:separate; border-spacing:1px; background-color:'.$params->get('efl_bordercolor').'; text-align:left;">'."\n";
		$html .= "\t".'<tr style="background-color:'.$params->get('efl_headcolor').';">'."\n";
		$html .= "\t\t".'<th style="border: 1px solid #FFFFFF; padding: 4px;">Filename</th>'."\n";
		if ($params->get('efl_size') == "yes")
		{
			$html .= "\t\t".'<th style="border: 1px solid #FFFFFF; padding: 4px;">Size</th>'."\n";
		}
		if ($params->get('efl_date') == "yes")
		{
			$html .= "\t\t".'<th style="border: 1px solid #FFFFFF; padding: 4px;">Date</th>'."\n";
		}
		$html .= "\t".'</tr>'."\n";
		for ($i = 0; $i < $total; $i++)
		{
			//set the colour for the odd row
			$color = $params->get('efl_oddcolor');
			//is the row even
			if (($i+1)%2 == 0)
			{
				//set the colour for the even row
				$color = $params->get('efl_evencolor');
			}
			//start the table row
			$html .= "\t".'<tr style="background-color:'.$color.';">'."\n";
			//filename column
			$html .= "\t\t".'<td style="padding:1px;">';
			//show icons?
			if ($params->get('efl_icons') == "yes")
			{
				$html .= modEasyFolderListingHelper::attachIcon($rows[$i]['ext']);
			}
			//link it?
			if ($params->get('efl_linktofiles') == "yes")
			{
				$html .= '<a href="'.JURI::base().$folder.'/'.$rows[$i]['name'].'.'.$rows[$i]['ext'].'">';
			}
			//show the file's name
			$html .= $rows[$i]['name'];
			//show extension?
			if ($params->get('efl_extensions') == "yes")
			{
				$html .= '.'.$rows[$i]['ext'];
			}
			//close the tag, if we are linking it
			if ($params->get('efl_linktofiles') == "yes")
			{
				$html .= '</a>';
			}
			//close filename column
			$html .= '</td>'."\n";
			//show size?
			if ($params->get('efl_size') == "yes")
			{
				$html .= "\t\t".'<td style="padding:1px;">';
				$html .= $rows[$i]['size'];
				$html .= '</td>'."\n";
			}
			//show date?
			if ($params->get('efl_date') == "yes")
			{
				$html .= "\t\t".'<td style="padding:1px;">';
				$html .= $rows[$i]['date'];
				$html .= '</td>'."\n";
			}
			//end the tag
			$html .= "\t".'</tr>'."\n";
		}
		$html .= '</table>'."\n";
		
		return $html;
	}
	
	protected static function formatList(&$params, &$rows, $folder)
	{
		$total = count($rows); //get the total number of files
		$html = '<ul style="list-style:none;">'."\n";
		for ($i = 0; $i < $total; $i++)
		{
			$html .= "\t".'<li>';
			//show icons?
			if ($params->get('efl_icons') == "yes")
			{
				$html .= modEasyFolderListingHelper::attachIcon($rows[$i]['ext']);
			}
			//link it?
			if ($params->get('efl_linktofiles') == "yes")
			{
				$html .= '<a href="'.JURI::base().$folder.'/'.$rows[$i]['name'].'.'.$rows[$i]['ext'].'">';
			}
			//show the file's name
			$html .= $rows[$i]['name'];
			//show extension?
			if ($params->get('efl_extensions') == "yes")
			{
				$html .= '.'.$rows[$i]['ext'];
			}
			//close the tag, if we are linking it
			if ($params->get('efl_linktofiles') == "yes")
			{
				$html .= '</a>';
			}
			//show size?
			if ($params->get('efl_size') == "yes")
			{
				$html .= ' ['.$rows[$i]['size'].']';
			}
			//show date?
			if ($params->get('efl_date') == "yes")
			{
				$html .= ' ['.$rows[$i]['date'].']';
			}
			//end the tag
			$html .= '</li>'."\n";
		}
		$html .= '</ul>'."\n";
		
		return $html;
	}
	
	protected static function folderPath(&$params)
	{
		//get the full path based on the parent folder selection
		$path = $params->get('efl_parent');
		$folder = trim($params->get('efl_folder')); //remove any whitespace
		if (strlen($folder) != 0) //check if a specific folder was entered
		{
			if (JFolder::exists(JPATH_SITE.'/'.$path.'/'.$folder)) //check to see if the folder exists
			{
				$path .= '/'.$folder; //complete the path
			}
			else
			{
				//throw an exception... ouch!
				throw new Exception(JText::_("Directory folder specified is not a valid directory: ".$path.$folder));
			}
		}
		return $path;
	}
	
	protected static function formatDate(&$params, $mtime)
	{
		$datetime = date('Y-m-d', $mtime);
		
		if ($params->get('efl_time') == "yes")
		{
			$datetime = date('Y-m-d H:i:s', $mtime);
		}
		
		return $datetime;
	}
	
	protected static function attachIcon($ext)
	{
		$path = JURI::base().'modules'.'/'.'mod_easyfolderlisting'.'/'.'icons';
		$html = "";
		if (stripos("exe", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'application.png" alt="An executable file" />';
		}
		elseif (stripos("c", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_c.png" alt="A C file" />';
		}
		elseif (stripos("cpp", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_cplusplus.png" alt="A C plus plus file" />';
		}
		elseif (stripos("cs", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_csharp.png" alt="A C sharp file" />';
		}
		elseif (stripos("wmv,mp4,mov,divx,avi,flv,mkv", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'film.png" alt="A video file" />';
		}
		elseif (stripos("htm,html", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'html.png" alt="An html file" />';
		}
		elseif (stripos("bmp,jpg,jpeg,png,gif,tif", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'picture.png" alt="An image file" />';
		}
		elseif (stripos("mp3,wma", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'music.png" alt="A music file" />';
		}
		elseif (stripos("java,py", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_code.png" alt="A code file" />';
		}
		elseif (stripos("pdf,ps", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_acrobat.png" alt="An Adobe Acrobat file" />';
		}
		elseif (stripos("zip", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_compressed.png" alt="A compressed ZIP file" />';
		}
		elseif (stripos("swf", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_flash.png" alt="A flash SWF file" />';
		}
		elseif (stripos("xls,xlsx", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_excel.png" alt="A Microsoft Excel file" />';
		}
		elseif (stripos("php", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_php.png" alt="A PHP file" />';
		}
		elseif (stripos("ppt,pptx", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_powerpoint.png" alt="A Microsoft Powerpoint file" />';
		}
		elseif (stripos("txt", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_text.png" alt="A Text file" />';
		}
		elseif (stripos("sln", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_visualstudio.png" alt="A Visual Studio Solution file" />';
		}
		elseif (stripos("doc,docx", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_word.png" alt="A Microsoft Word file" />';
		}
		elseif (stripos("tar.gz,tgz,tbz,tb2,tar.bz2,taz,tar.Z,tlz,tar.lz,txz,tar.xz,7z,rar", $ext) !== false)
		{
			$html .= '<img src="'.$path.'/'.'page_white_zip.png" alt="A Compressed file" />';
		}
		else
		{
			$html .= '<img src="'.$path.'/'.'page_white.png" alt="A file of unknown type" />';
		}
		
		//add a space to the end
		$html .= ' ';
		
		return $html;
	}
	
	//this method returns the file size formatted according to an appropriate size units
	protected static function sizeToText($size)
	{
		$text = "";
		$kb = 1024;
		$mb = $kb * $kb;
		$gb = $mb * $kb;
		
		if ($size >= $gb)
		{
			$size = round($size / $gb, 2);
			$text = $size." GB";
		}
		elseif ($size >= $mb)
		{
			$size = round($size / $mb, 2);
			$text = $size." MB";
		}
		elseif ($size >= $kb)
		{
			$size = round($size / $kb, 2);
			$text = $size." KB";
		}
		else
		{
			$text = $size." bytes";
		}
		return $text;
	}
}
?>