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
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/mod_form.php');

require_once($CFG->dirroot.'/lib/editor/tinymce/lib.php');

$courseid = required_param('courseid', PARAM_INT);
echo $courseid;
echo $USER->id;

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

echo "<textarea id='areaText' style='height:100%; width:100%;'></textarea>";

$notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$course = $DB->get_record('course', array('id' => $courseid));

echo $course->fullname;

$n = 0;
foreach ($notes as $note) {
//    echo $note->courseid;
    if ($courseid == $note->courseid) {

        $trimmed  = $note->text;
        $section = $DB->get_record('course_modules', array('id' => $note->cmid, 'course' => $note->courseid));
        $format = $DB->get_record('course', array('id' => $note->courseid));
        $var=json_encode($format);
        
        echo"<script>console.log($var);</script>";
        //If the section var exists for a course activity
        if ($section) {
            $sql = "SELECT *
                    FROM {course_sections} th
                    WHERE th.id = '$section->section' AND th.course = '$note->courseid'";
            $course_section = $DB->get_record_sql($sql);

            if ($course_section->name == NULL) {
                $course_section->name = 'Section name not specified, but section# is:' . $course_section->section;
            }
                //debugging
                echo "section=" . $section->section . "</br>";
                echo "sectionid=" . $section->id . "</br>";
                echo "section=" . $course_section->section . "</br>";
                    echo"<div>";
            if ($n % 2 == 0) { //Notes on a Course Module Page
                echo"<div >$course_section->name</div>";
                echo"<textarea >
                \n $note->name 
                    \n
                    $trimmed
                </textarea>";
            } else {
                echo"<div >$course_section->name</div>";
                echo"<textarea>
                           \n $note->name 
                            \n
                            $trimmed
                        </textarea>";
            }
            echo"</div>";  
        } else { //Notes on a Course Main Page
            echo"<div >";
            if ($n % 2 == 0) {
                echo"<div >Course Page</div>";
                echo"<textarea>
                           \n $note->name 
                            \n
                            $trimmed
                        </textarea>";
            } else {
                echo"<div >Course Page</div>";
                echo"<textarea>
                           \n $note->name 
                            \n
                            $trimmed
                        </textarea>";
            }

            echo"</div>";  
        }
        $n++;
    }
}

//Applies tinyMCE to targetted text area
$editor = new tinymce_texteditor();
$editor->use_editor('areaText');

echo $OUTPUT->footer();
?>
