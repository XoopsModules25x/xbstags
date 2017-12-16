<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author:    Ashley Kitson                                                  //
// Copyright: (c) 2006, Ashley Kitson                                        //
// URL:       http://xoobs.net			                                     //
// Project:   The XOOPS Project (http://www.xoops.org/)                      //
// Module:    XBS MetaTags (TAGS)                                            //
// ------------------------------------------------------------------------- //
/**
* Admin index page
*
* Display Metatags page index and allow user to operate on records
*
* @author Ashley Kitson http://xoobs.net
* @copyright 2006 Ashley Kitson, UK
* @package TAGS
* @subpackage Admin
* @version 1
* @access private
*/

/**
* Do all the declarations etc needed by an admin page
*/
include_once "adminheader.php";

//Display the admin menu
xoops_module_admin_menu(1,_AM_TAGS_ADMENU1);

/**
* To use this as a template you need to write page to display
* whatever it is you want displaying between here...
*/

/**
* @global array Form Post variables
*/
global $_POST;
/**
* @global array Get variables
*/
global $_GET;

//First process any GETs
extract($_GET);
if (isset($edit)) { //edit the page's record
	adminEditPage($edit); 
} elseif (isset($delete)) {
	adminDeletePage($delete);
} elseif (isset($new)) {
	adminEditPage(0);
} else  { //Process POSTs
	if (isset($_POST['submit'])) { //Record edit session saved
		adminSavePage();
	} elseif (isset($_POST['cancel'])) { 
		redirect_header(TAGS_URL."/admin/index.php",1,_AM_TAGS_CANCELEDIT);
	} else { //Present a list of page sets to select to work with
 		adminSelectPage();
	}
} //end if

/**
* and here.
*/

//And put footer in
xoops_cp_footer();

?>