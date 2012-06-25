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
global $CFG, $DB, $USER, $PAGE;

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

require_once($CFG->dirroot . '/lib/editor/tinymce/lib.php');

$courseid = required_param('courseid', PARAM_INT);
//$n = required_param('n', PARAM_INT);
$note_id = required_param('note_id', PARAM_INT);
//$note_name = optional_param('note_name','', PARAM_TEXT);
//$trim = optional_param('trimmed','', PARAM_TEXT);

$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/notepage.php');

require_login();

$PAGE->set_pagelayout('popup');
//or embedded
echo $OUTPUT->header();

/* * ******************************************************** *///Javascript declaration
echo"<script type='text/javascript' src='js/jquery-1.7.2.js'></script>";
echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'></script>";

echo"<script type='text/javascript' src='js/test1.js'></script>";

//echo "<textarea id='areaText' style='height:100%; width:100%;'></textarea>";

//$notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$course = $DB->get_record('course', array('id' => $courseid));

$trim = $DB->get_record('notes', array('userid'=>$USER->id, 'courseid'=>$courseid, 'id'=>$note_id));
$note_name = $trim->name;
$text = $trim->text;
echo "<textarea id='areaText'>
    \n $note_name 
    \n
    $text;
</textarea>";

//echo '<input id="courseid" type="hidden" value="' . $courseid . '"/>';
echo "<input id='courseid' type='hidden' value=' $courseid '/>";
echo "<input id='note_id' type='hidden' value=' $note_id '/>";
//echo "<input id='title' type='hidden' value=' $note_id '/>";



//Applies tinyMCE to targetted text area
$editor = new tinymce_texteditor();
$editor->use_editor('areaText');

echo $OUTPUT->footer();
?>