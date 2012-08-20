<?php
/**
**************************************************************************
**                              mynotebook                              **
**************************************************************************
* @package     local                                                    **
* @subpackage  mynotebook                                               **
* @name        mynotebook                                               **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Theodore Pham                                            **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/

defined('MOODLE_INTERNAL') || die();

global $DB;

$logs = array(
    array('module'=>'mynotebook', 'action'=>'add', 'mtable'=>'mynotebook', 'field'=>'name'),
    array('module'=>'mynotebook', 'action'=>'update', 'mtable'=>'mynotebook', 'field'=>'name'),
    array('module'=>'mynotebook', 'action'=>'view', 'mtable'=>'mynotebook', 'field'=>'name'),
    array('module'=>'mynotebook', 'action'=>'view all', 'mtable'=>'mynotebook', 'field'=>'name')
);
