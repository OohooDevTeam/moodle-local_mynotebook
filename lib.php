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
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @param object $mynotebook An object from the form in mod_form.php
 * @return int The id of the newly inserted mynotebook record
 */

function mynotebook_extends_navigation(global_navigation $navigation) {

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

global $CFG;

$url = new moodle_url($CFG->wwwroot.'/local/mynotebook/view.php');

//Adds the makenote plugin under "Navigation" block
$node = $navigation->add('MyNotebook', $url);

//Force node to open on display
$node->forceopen = false;

}

function mynotebook_add_instance($mynotebook) {
    global $DB;

    $mynotebook->timecreated = time();

    # You may have to add extra stuff in here #

    return $DB->insert_record('mynotebook', $mynotebook);
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @param object $mynotebook An object from the form in mod_form.php
 * @return boolean Success/Fail
 */
function mynotebook_update_instance($mynotebook) {
    global $DB;

    $mynotebook->timemodified = time();
    $mynotebook->id = $mynotebook->instance;

    # You may have to add extra stuff in here #

    return $DB->update_record('mynotebook', $mynotebook);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 */
function mynotebook_delete_instance($id) {
    global $DB;

    if (! $mynotebook = $DB->get_record('mynotebook', array('id' => $id))) {
        return false;
    }

    # Delete any dependent records here #

    $DB->delete_records('mynotebook', array('id' => $mynotebook->id));

    return true;
}

/**
 * Return a small object with summary information about what a
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return null
 * @todo Finish documenting this function
 */
function mynotebook_user_outline($course, $user, $mod, $mynotebook) {
    $return = new stdClass;
    $return->time = 0;
    $return->info = '';
    return $return;
}

/**
 * Print a detailed representation of what a user has done with
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 */
function mynotebook_user_complete($course, $user, $mod, $mynotebook) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity
 * that has occurred in mynotebook activities and print it out.
 * Return true if there was output, or false is there was none.
 *
 * @return boolean
 * @todo Finish documenting this function
 */
function mynotebook_print_recent_activity($course, $viewfullnames, $timestart) {
    return false;  //  True if anything was printed, otherwise false
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such
 * as sending out mail, toggling flags etc ...
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function mynotebook_cron () {
    return true;
}

/**
 * Must return an array of users who are participants for a given instance
 * of mynotebook. Must include every user involved in the instance,
 * independient of his role (student, teacher, admin...). The returned
 * objects must contain at least id property.
 * See other modules as example.
 *
 * @param int $mynotebookid ID of an instance of this module
 * @return boolean|array false if no participants, array of objects otherwise
 */
function mynotebook_get_participants($mynotebookid) {
    return false;
}

/**
 * This function returns if a scale is being used by one mynotebook
 * if it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $mynotebookid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 */
function mynotebook_scale_used($mynotebookid, $scaleid) {
    global $DB;

    $return = false;

    //$rec = $DB->get_record("mynotebook", array("id" => "$mynotebookid", "scale" => "-$scaleid"));
    //
    //if (!empty($rec) && !empty($scaleid)) {
    //    $return = true;
    //}

    return $return;
}

/**
 * Checks if scale is being used by any instance of mynotebook.
 * This function was added in 1.9
 *
 * This is used to find out if scale used anywhere
 * @param $scaleid int
 * @return boolean True if the scale is used by any mynotebook
 */
function mynotebook_scale_used_anywhere($scaleid) {
    global $DB;

    if ($scaleid and $DB->record_exists('mynotebook', 'grade', -$scaleid)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Execute post-uninstall custom actions for the module
 * This function was added in 1.9
 *
 * @return boolean true if success, false on error
 */
function mynotebook_uninstall() {
    return true;
}
