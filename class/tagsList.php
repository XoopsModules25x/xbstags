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
 * Classes used by XBS MetaTags system
 *
 * @package       TAGS
 * @subpackage    tagsList
 * @access        private
 * @author        Ashley Kitson http://xoobs.net
 * @copyright (c) 2006 Ashley Kitson, Great Britain
 */

/**
 * Require Xoops kernel objects so we can extend them
 */
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
/**
 * MetaTags constant defines
 */
require_once XOOPS_ROOT_PATH . '/modules/xbs_tags/include/defines.php';
/**
 * @global Xoops configuration
 */
global $xoopsConfig;
if (file_exists(TAGS_PATH . '/language/' . $xoopsConfig['language'] . '/main.php')) {
    include_once TAGS_PATH . '/language/' . $xoopsConfig['language'] . '/main.php';
} else {
    include_once TAGS_PATH . '/language/english/main.php';
}

/**
 *
 * A tags list object
 *
 * @package    TAGS
 * @subpackage tagsList
 * @author     Ashley Kitson (http://xoobs.net)
 * @copyright  2006, Ashley Kitson, UK
 */
class tagsList extends XoopsObject
{

    /**
     * Constructor
     *
     * The following variables  are set for retrieval with ->getVar()
     * {@source 2 10}
     */
    public function __construct()
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('typ', XOBJ_DTYPE_OTHER);
        $this->initVar('pid', XOBJ_DTYPE_INT, null, true);
        $this->initVar('keywords', XOBJ_DTYPE_OTHER);
        parent::__construct(); //call ancestor constructor
    }
}//end class tagsList

/**
 * Class xbs_tagstagsListHandler
 */
class xbs_tagstagsListHandler extends XoopsObjectHandler
{

    // Public Variables
    /**
     * Set in descendent constructor to name of object that this handler handles
     * @var string
     */
    public $classname = 'tagsList';
    /**
     * Set in ancestor to name of unique ID generator tag for use with insert function
     * @var string
     */
    public $ins_tagname = 'ins_tagsList';

    // Private variables
    /**
     * most recent error number
     * @access private
     * @var int
     */
    public $_errno = 0;
    /**
     * most recent error string
     * @access private
     * @var string
     */
    public $_error = '';

    /**
     * Constructor
     *
     * @param  xoopsDatabase &$db handle for xoops database object
     */
    public function __construct($db)
    {
        parent::__construct($db);
    }

    /**
     * Set error information
     *
     * @param int    $errnum =0 Error number
     * @param string $errstr ='' Error Message
     */
    public function setError($errnum = 0, $errstr = '')
    {
        $this->_errno = $errnum;
        $this->_error = $errstr;
    }

    /**
     * Return last error number
     *
     * @return int
     */
    public function errno()
    {
        return $this->_errno;
    }

    /**
     * Return last error message
     *
     * @return  string
     */
    public function error()
    {
        return $this->_error;
    }

    /**
     * return last error number and message
     *
     * @return string
     */
    public function getError()
    {
        $e = 'Error No ' . (string)$this->_errno . ' - ' . $this->_error;
        return $e;
    }

    /**
     * Create a new object
     *
     * @param boolean $isNew =true create a new object and tell it is new.  If False then create object but set it as not new
     * @return object tagsList else False if failure
     */
    public function &create($isNew = true)
    {
        $obj = new tagsList();
        if ($isNew && $obj) { //if it is new and the object was created
            $obj->setNew();
            $obj->unsetDirty();
        } else {
            if ($obj) {         //it is not new (forced by caller, usually &getall()) but obj was created
                $obj->unsetNew();
                $obj->unsetDirty();
            } else {
                $this->setError(-1, sprintf(_MD_TAGS_ERR_2, $classname));
                return false;      //obj was not created so return False to caller.
            }
        }
        return $obj;
    }// end create function

    /**
     * Get all data for object given id.
     *
     * @param  int $id data item internal identifier
     * @return object descendent of tagsList
     */
    public function &get($id)
    {
        $test = (is_int($id) ? ($id > 0 ? true : false) : !empty($id) ? true : false); //test validity of id
        //    $id = intval($id);
        if ($test) {
            $obj =& $this->create(false);
            if ($obj) {
                $sql = 'SELECT * FROM ' . $this->db->prefix(TAGS_TBL_LIST) . ' WHERE id = ' . $id;

                if ($result = $this->db->query($sql)) {
                    if (1 == $this->db->getRowsNum($result)) {
                        $res             = $this->db->fetchArray($result);
                        $res['keywords'] = unserialize($res['keywords']);
                        $obj->assignVars($res);
                        return $obj;
                    } else {
                        $this->setError(-1, sprintf(_MD_TAGS_ERR_1, (string)$id));
                    }
                } else {
                    $this->setError($this->db->errno(), $this->db->error());
                }//end if
            }//end if - error value set in call to create()
        } else {
            $this->setError(-1, sprintf(_MD_TAGS_ERR_1, (string)$id));
        }//end if
        $ret = false;
        return $ret; //default return
    }//end function &get

    /**
     * Get a list denoted by its user side key
     *
     * @param string $type one of TAGS_LISTBLACK, TAGS_LISTWHITE, TAGS_LISTPAGE
     * @param int    $pid  Page identifier
     * @return bool|object
     */
    public function &getByKey($type, $pid = 0)
    {
        $sql = 'SELECT id FROM ' . $this->db->prefix(TAGS_TBL_LIST) . ' WHERE typ = ' . $this->db->quoteString($type) . ' AND pid = ' . $pid;
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        $res = $this->db->fetchArray($result);
        $obj = $this->get($res['id']);
        return $obj;
    }

    /**
     * Insert sql string
     *
     * @access private
     * @param tagsList object $obj
     * @return string SQL string to insert object data into database
     */
    public function _ins_insert($obj)
    {
        $keys = serialize($obj->getVar('keywords'));
        $sql  = sprintf('INSERT INTO %s (typ, pid, keywords) VALUES (%s,%u,%s)', $this->db->prefix(TAGS_TBL_LIST), $this->db->quoteString($obj->getVar('typ')), $obj->getVar('pid'), $this->db->quoteString($keys));
        return $sql;
    }

    /**
     * update sql string
     *
     * @access private
     * @param tagsList object $obj
     * @return string SQL string to update object data into database
     */
    public function _ins_update($obj)
    {
        $keys = serialize($obj->getVar('keywords'));
        $sql  = sprintf('UPDATE %s SET typ = %s, pid = %u, keywords = %s WHERE id = %u', $this->db->prefix(TAGS_TBL_LIST), $this->db->quoteString($obj->getVar('typ')), $obj->getVar('pid'), $this->db->quoteString($keys), $obj->getVar('id'));
        return $sql;
    }

    /**
     * Write an object back to the database
     *
     * @param \XoopsObject $obj
     * @return  bool           True if successful
     */

    public function insert(XoopsObject $obj)
    {
        if (!$obj->isDirty()) {
            return true;
        }    // if data is untouched then don't save
        if ($obj->isNew()) {
            //next line not really required for mysql, but left in for future compatibility
            $obj->setVar('id', $this->db->genId($this->ins_tagname));
        }
        //get the sql for insert or update
        $sql = ($obj->isNew() ? $this->_ins_insert($obj) : $this->_ins_update($obj));
        if (!$result = $this->db->queryF($sql)) {
            $this->setError($this->db->errno(), $this->db->error());
            return false;
        } else {
            $obj->unsetDirty(); //It has been saved so now it is clean
        }

        if ($obj->isNew()) { //retrieve the new internal id for the code and store
            $id = $this->db->getInsertId();
            $obj->setVar('id', $id);
            $obj->unsetNew();  //it's been saved so it's not new anymore
        }

        return true;
    }//end function insert

    /**
     * Delete object from the database
     *
     * @param \XoopsObject $obj
     * @return bool TRUE on success else False
     */
    public function delete(XoopsObject $obj)
    {
        $sql = sprintf('DELETE FROM %s WHERE id = %u', $this->db->prefix(TAGS_TBL_LIST), (int)$obj->getVar('id'));
        if (!$result = $this->db->queryF($sql)) {
            $this->setError($this->db->errno(), $this->db->error());
            return false;
        } else {
            unset($obj);
            return true;
        }
    } //end function delete

    /**
     * Function: Retrieve all the stored tagsList objects as an array
     *
     *
     *
     * @version 1
     * @return array tagsList object array else False on error
     */
    public function &getAllLists()
    {
        $ret = [];
        $sql = 'SELECT id FROM ' . $this->db->prefix(TAGS_TBL_LIST) . ' ORDER BY typ,pid';
        if (!$result = $this->db->query($sql)) {
            $this->setError($this->db->errno(), $this->db->error());
            return false;
        } else {
            while ($obj = $this->db->fetchArray($result)) {
                if (!$ret[] = $this->get($obj['id'])) {
                    return false;
                }
            }
            return $ret;
        }
    }//end function getAllLists
} //end of class tagsListHandler
