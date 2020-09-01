<?php declare(strict_types=1);

//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source page or any supporting         //
//  source page which is considered copyrighted (c) material of the          //
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
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS MetaTags (TAGS)                                            //
// ------------------------------------------------------------------------- //
/**
 * Update MetaTags database with recently installed modules information
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2006 Ashley Kitson, UK
 * @package    TAGS
 * @subpackage Admin
 * @version    1
 * @access     private
 */

/**
 * Do all the declarations etc needed by an admin page
 */
$path = dirname(dirname(dirname(__DIR__)));
require_once __DIR__ . '/adminheader.php';

//Display the admin menu
//xoops_module_admin_menu(2,_AM_XBSTAGS_ADMENU2);

/**
 * To use this as a template you need to write page to display
 * whatever it is you want displaying between here...
 */

/**
 * @global array Form Post variables
 */
#global $_POST;

if (isset($_POST['submit'])) { //User wants to update tags database for module(s)
    if (!adminUpdatePage($_POST['mid'])) {
        redirect_header(TAGS_URL . '/admin/index.php', 1, _AM_XBSTAGS_UPDTFAIL);
    } else {
        redirect_header(TAGS_URL . '/admin/index.php', 1, _AM_XBSTAGS_UPDTOK);
    }
} elseif (isset($_POST['cancel'])) {
    redirect_header(TAGS_URL . '/admin/index.php', 1, _AM_XBSTAGS_CANCELEUPDT);
} else { //Present a list of page sets to select to work with
    adminSelectUpdate();
}

/**
 * and here.
 */

//And put footer in
xoops_cp_footer();
