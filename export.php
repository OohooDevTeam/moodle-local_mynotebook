<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * Prints a particular instance of mynotebook
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package   mod_mynotebook
 * @copyright 2010 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
global $DB, $USER;

$courses = enrol_get_users_courses($USER->id);
$registered_courseids = array();
$registered_courseids = array_keys($courses);

$courseids = $DB->get_records('notes', array('userid' => $USER->id));


$array_courseid = array();
foreach ($courseids as $courseid) {
    $array_courseid[] = $courseid->courseid;
}


$conditions_list = array(TRUE, FALSE, NULL);
$arrid = array_unique($array_courseid);
$reordered_courseid = reorderindex($arrid, $conditions_list);


$courses = array();
$course_name = array();

for ($i = 0; $i < sizeof($reordered_courseid); $i++) {
    $courses = $DB->get_record('course', array('id' => $reordered_courseid[$i]));
    $course_name[] = $courses->fullname;
}

$course_no_notes = array();
if (sizeof($registered_courseids) > sizeof($reordered_courseid)) {
    $course_no_notes = array_diff($registered_courseids, $reordered_courseid);
    $course_no_notes = reorderindex($course_no_notes);
} else {
    $course_no_notes = array_diff($reordered_courseid, $registered_courseids);
    $course_no_notes = reorderindex($course_no_notes);
}
$number_no_notes = sizeof($course_no_notes);
$count = sizeof($course_name);

$q = $_GET["q"];

if ($q == 'All Notes') {
    export_all();
} else if ($q == 'Course Notes') {
    export_course($course_name, $count, $course_no_notes, $number_no_notes);
} else {
    echo "No option selected";
}

//Exports all usre notes
function export_all() {
    echo"</br>";
    echo"<form id='export_all' name='export_all' method='post' action='word_template.php'>";
    echo"Name: ";
    echo"<input name='filename' type='text' id='filename' size='10' /></br></br> 
            
   extension:
   <select name='tpl' id='tpl'>
            <option value='ms_word.docx'> Ms Word Document (.docx)</option>
            </select>";

    echo"<div id='save_as_file' style='display:none;'>, save as file with suffix: ";
    echo"<input name='suffix' type='text' id='suffix' size='10' />(let empty for download),</div>";
    echo "</br></br>";
    //Input type before was submit
    echo"<input type='image' name='btn_go' id='btn_go' value='export' src='images/submit.gif' />";
    echo"</form>";
}

//Exports speicified user course notes
function export_course($course_name, $count, $course_no_notes, $number_no_notes) {
    global $DB;
    echo"</br>";
    echo"<form id='export_course' name='export_course' method='post' action='course_template.php' >";
    echo"Name: ";
    echo"<input name='filename' type='text' id='filename' size='10' /></br></br> 
            
                        extension:   
            <select name='tpl' id='tpl'>
            <option value='ms_word.docx'> Ms Word Document (.docx)</option>
            </select>
            </br></br>
            Course : ";
    echo "<select name='course_name' id='course_name'>";
    //Creates a drop down menu with all the course
    for ($i = 0; $i < $count; $i++) {
        echo "<option> $course_name[$i]</option>";
    }

    for ($j = 0; $j < $number_no_notes; $j++) {
        $coursenames = $DB->get_record('course', array('id' => $course_no_notes[$j]));
        if (strlen($coursenames->fullname) < 28) {
            $no_notes = $coursenames->fullname;
        } else {
            $no_notes = substr($coursenames->fullname, 0, 27);
            $no_notes = $no_notes . "...";
        }
        //Displays courses with no notes as greyed out
        echo "<option disabled='disabled'>$no_notes</option>";
    }
    echo"</select>";

    echo"<div id='save_as_file' style='display:none;'>, save as file with suffix: ";
    echo"<input name='suffix' type='text' id='suffix' size='10' />(let empty for download),</div>";
        echo "</br></br>";
    echo"<input type='image' name='btn_go' id='btn_go' value='export' src='images/submit.gif' />";
    echo"</form>";
}
            
?>