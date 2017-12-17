<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org/>                             //
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
// URL:       http://xoobs.net                                               //
// Project:   The XOOPS Project (https://xoops.org/)                      //
// Module:    XBS MetaTags (TAGS)                                            //
// ------------------------------------------------------------------------- //
/**
 * Admin menu declaration
 *
 * This script conforms to the Xoops standard for admin/menu.php
 *
 * @author     Ashley Kitson http://xoobs.net
 * @copyright  2005 Ashley Kitson, UK
 * @package    TAGS
 * @subpackage Admin
 * @version    1
 * @access     private
 */

/**
 * @global Xoop Configuration
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

//$path = dirname(dirname(dirname(__DIR__)));
//include_once $path . '/mainfile.php';

$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname(basename(dirname(__DIR__)));
$pathIcon32    = '../../' . $module->getInfo('icons32');
xoops_loadLanguage('modinfo', $module->dirname());

$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin') . '/moduleadmin';
if (!file_exists($fileinc = $pathModuleAdmin . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $pathModuleAdmin . '/language/english/main.php';
}
include_once $fileinc;

global $xoopsConfig;

/**
 * make sure we have the admin menu language constants loaded
 */
if (file_exists(XOOPS_ROOT_PATH . '/modules/xbs_tags/language/' . $xoopsConfig['language'] . '/admin.php')) {
    include_once XOOPS_ROOT_PATH . '/modules/xbs_tags/language/' . $xoopsConfig['language'] . '/admin.php';
} else {
    include_once XOOPS_ROOT_PATH . '/modules/xbs_tags/language/english/admin.php';
}

/**
 * Whilst you can link your menu options to a single file, typically admin/index.php
 * and use a switch statement on a variable passed to it from here, to keep things
 * simple, use one script per menu option;
 */

$adminmenu              = [];
$i                      = 0;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_HOME;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/home.png';
$i++;
$adminmenu[$i]['title'] = _AM_TAGS_ADMENU1;
$adminmenu[$i]['link']  = 'admin/main.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/administration.png';
$i++;
$adminmenu[$i]['title'] = _AM_TAGS_ADMENU2;
$adminmenu[$i]['link']  = 'admin/update.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/update.png';
$i++;
$adminmenu[$i]['title'] = _AM_TAGS_ADMENU3;
$adminmenu[$i]['link']  = 'admin/blacklist.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/delete.png';
$i++;
$adminmenu[$i]['title'] = _AM_TAGS_ADMENU4;
$adminmenu[$i]['link']  = 'admin/whitelist.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/button_ok.png';
$i++;
$adminmenu[$i]['title'] = _AM_TAGS_ADMENU5;
$adminmenu[$i]['link']  = 'admin/tracks.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/cart_add.png';
$i++;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/about.png';
$i++;
$adminmenu[$i]['title'] = _AM_MODULEADMIN_ABOUT;
$adminmenu[$i]['link']  = 'admin/help.php';
$adminmenu[$i]['icon']  = $pathIcon32 . '/faq.png';
