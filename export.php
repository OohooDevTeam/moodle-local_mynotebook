<?php

/**
 * *************************************************************************
 * *                              mynotebook                              **
 * *************************************************************************
 * @package     local                                                    **
 * @subpackage  mynotebook                                               **
 * @name        mynotebook                                               **
 * @copyright   oohoo.biz                                                **
 * @link        http://oohoo.biz                                         **
 * @author      Theodore Pham                                            **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
 * *************************************************************************
 * ************************************************************************ */
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
global $DB, $USER;

//Get the courses the user is enrolled in
$courses = enrol_get_users_courses($USER->id);
$registered_courseids = array();
$registered_courseids = array_keys($courses);

$courseids = $DB->get_records('notes', array('userid' => $USER->id));

$array_courseid = array();
//Grabs all the courses
foreach ($courseids as $courseid) {
    $array_courseid[] = $courseid->courseid;
}

$conditions_list = array(TRUE, FALSE, NULL);
//Gets rid of duplicate courses
$arrid = array_unique($array_courseid);
//Reorders array index
$reordered_courseid = reorderindex($arrid, $conditions_list);

$courses = array();
$course_name = array();

//Store the course names
for ($i = 0; $i < sizeof($reordered_courseid); $i++) {
    $courses = $DB->get_record('course', array('id' => $reordered_courseid[$i]));
    $course_name[] = $courses->fullname;
}

$course_no_notes = array();
//Get all the courses with no notes and reorder the indec in the array
if (sizeof($registered_courseids) > sizeof($reordered_courseid)) {
    $course_no_notes = array_diff($registered_courseids, $reordered_courseid);
    $course_no_notes = reorderindex($course_no_notes);
} else {
    $course_no_notes = array_diff($reordered_courseid, $registered_courseids);
    $course_no_notes = reorderindex($course_no_notes);
}
$number_no_notes = sizeof($course_no_notes);
$count = sizeof($course_name);

//Users choice
$q = $_GET["q"];

if ($q == get_string('allnotes', 'local_mynotebook')) {
    export_all();
} else if ($q == get_string('coursenotes', 'local_mynotebook')) {
    export_course($course_name, $count, $course_no_notes, $number_no_notes);
} else {
    //Do nothing
}

/**
 * Exports all the notes that the user has ever created
 */
function export_all() {
    echo"</br>";
    echo"<form id='export_all' name='export_all' method='post' action='html2word.php?user_choice=all_notes'>";
    echo get_string('name', 'local_mynotebook');
    echo"<input name='filename' type='text' id='filename' size='10' required='required'/></br></br>
   " . get_string('ext', 'local_mynotebook'). "
   <select name='tpl' id='tpl'>
            <option value='ms_word.doc'> " . get_string('msword', 'local_mynotebook'). "</option>
            </select>";
    echo "</br></br>";
    //Input type before was submit
    echo"<div style='text-align: center;'>";
    echo"<input type='image' title='" . get_string('dl', 'local_mynotebook'). "' name='btn_go' id='btn_go' value='export' src='images/dl.png' />";
    echo"</div></form>";
}

/**
 * Exports all the notes of a course chosen by the user
 *
 * @global moodle_database $DB
 * @param string $course_name This string is for displaying the course name as a list header
 * @param int $count This number is for looping through the array of course names
 * @param int $course_no_notes This number is for the id of the course with no notes
 * @param int $number_no_notes This number is for the id of the course with notes
 */
function export_course($course_name, $count, $course_no_notes, $number_no_notes) {
    global $DB;
    echo"</br>";
    echo"<form id='export_course' name='export_course' method='post' action='html2word.php?user_choice=course_notes' >";
    echo get_string('name', 'local_mynotebook');
    echo"<input name='filename' type='text' id='filename' size='10' required='required'/></br></br>
            " . get_string('ext', 'local_mynotebook'). "
            <select name='tpl' id='tpl'>
            <option value='ms_word.doc'> " . get_string('msword', 'local_mynotebook'). "</option>
            </select>
            </br></br>
            " . get_string('course', 'local_mynotebook'). " ";
    echo "<select name='course_name' id='course_name'>";

    //Creates a drop down menu with all the course
    for ($i = 0; $i < $count; $i++) {
        echo "<option> $course_name[$i]</option>";
    }

    //Creates a dropdown menu of all courses without notes greyed out
    for ($j = 0; $j < $number_no_notes; $j++) {
        $coursenames = $DB->get_record('course', array('id' => $course_no_notes[$j]));
        if (strlen($coursenames->fullname) < 28) {
            $no_notes = $coursenames->fullname;

        //Adds ellipses to names that are too long
        } else {
            $no_notes = substr($coursenames->fullname, 0, 27);
            $no_notes = $no_notes . "...";
        }
        //Displays courses with no notes as greyed out
        echo "<option disabled='disabled'>$no_notes</option>";
    }
    echo"</select>";

    echo "</br></br>";
    echo"<div style='text-align: center;'>";
    echo"<input type='image' title='" . get_string('dl', 'local_mynotebook'). "' name='btn_go' id='btn_go' value='export' src='images/dl.png'/>";
    echo"</div></form>";
}

?>