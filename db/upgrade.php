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

/**
 * Upgrades the current version if there is a newer one available
 *
 * @param int $oldversion This string is for checking the plugin version
 * @return bool Returns whether current version is newer than the previous version
 */
function xmldb_local_mynotebook_upgrade($oldversion) {

    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

    if ($oldversion < 2012081700) {
    }

    return true;
}
