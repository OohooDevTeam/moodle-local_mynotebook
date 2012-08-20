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

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/mod_form.php');

global $CFG, $DB, $USER, $PAGE;
$courseid = required_param('courseid', PARAM_INT);

//Was added since error in moodle 2.0
$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/notebook.php');
require_login();

/* Should use output header for pages that are used in popups and dialogs since they
  will not display properly */
echo"<html><head>";

global $CFG, $USER, $DB;

echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/notebook.css'/>";
echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/paper.css'/>";
echo"<link  rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/menu.css'/>";

/* * ******************************************************** *///Javascript declaration
//Do not need to include again since this modal uses the jquery from the main page
//It will override the other jquery that was called already
//We only include it again when you have a popup or a new window
echo"<script type='text/javascript' src='js/jquery-1.7.2.js'></script>";
echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'></script>";

echo"<script type='text/javascript'>
    var handle;
</script>";

//<!--JS for page flip animation-->
echo"<script type='text/javascript' src='js/turn.js'></script>";
//<!--JS for the view page-->
echo"<script type='text/javascript' src='js/notebook.js'></script>";
/* * ******************************************************** *///End Javascript declaration
echo"<script type='text/javascript' src='js/save_title.js'></script>";

echo"</head><body>";

//Grabs the notes from the specified course
$courseids = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$courseid_array = array();
$coursename_array = array();

foreach ($courseids as $courseidnotes) {
    //Stores the coursename and course ids
    $coursenames = $DB->get_records('course', array('id' => $courseidnotes->courseid));
    $courseid_array[] = $courseidnotes->courseid;

    foreach ($coursenames as $coursename) {
        $coursename_array[] = $coursename->fullname;
    }
}

//Filters out the duplicate course ids and names and then reorders them
$conditions_list = array(TRUE, FALSE, NULL);
$unique_course_id = array_unique($courseid_array);
$ordered_course_id = reorderindex($unique_course_id, $conditions_list);

$unique_course_name = array_unique($coursename_array);
$ordered_course_name = reorderindex($unique_course_name, $conditions_list);

$notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));

/* * ************************************************ */
//Menubar for all coursenotes for quick access
echo"<span ><ul id='nav'>";

for ($j = 0; $j < sizeof($ordered_course_id); $j++) {
    //Limits the text to 10 chars for course names in the navbar
    $name = substr($ordered_course_name[$j], 0, 4);
    if (strlen($name) == 4) {
        $name = $name . "...";
    }
    //ajaxtrigger is what loads the page into a div == dialog
    echo"<li><a class='hsubs ajaxtrigger' coursename='$name' href='notebook.php?courseid=$ordered_course_id[$j]'>$name</a>";
    echo"<ul class='subs'>";

    //Displays all the notes for specified course
    foreach ($notes as $note) {
        if ($note->courseid == $ordered_course_id[$j]) {
            if (strlen($note->name) < 23) {
                $notename = $note->name;
            } else {
                $notename = substr($note->name, 0, 22);
                $notename = $notename . "...";
            }
            echo"<li><a href='#'>$notename</a></li>";
        }
    }
    echo"</ul>";
    echo"</li>";
}
echo"<div id='lavalamp'></div>";
echo"</ul></span>"; // End nav

/* * ************************************************ */
//Buttons on the right of the page
echo"<span><ul id='options'>";
echo"<li><a class='hsubs ' href='#' title='Help'><img src='images/help_icon.gif'/></a></li>";

echo"<li><a class='hsubs '>
        <div id='controls'>
            <label for='page-number'>Page:</label> <input type='text' size='3' id='page-number'> of <span id='number-pages'></span>
        </div>
    </a></li>";

echo"</ul></span>"; // End options
/* * ************************************************ */

$course = $DB->get_record('course', array('id' => $courseid));

echo"<div id='notebook'>";
echo"<div id='cover'>";
echo"<div id='notetitleleft'>$course->fullname</div>";
echo"</div>"; //end cover

$n = 0;
$i = 0;
foreach ($notes as $note) {
    //Check if the courseids match up
    if ($courseid == $note->courseid) {
        $section = $DB->get_record('course_modules', array('id' => $note->cmid, 'course' => $note->courseid));
        $format = $DB->get_record('course', array('id' => $note->courseid));

        //If the section var exists for a course activity
        if ($section) {
            $sql = "SELECT *
                    FROM {course_sections} th
                    WHERE th.id = '$section->section' AND th.course = '$note->courseid'";
            $course_section = $DB->get_record_sql($sql);

            if ($course_section->name == NULL) {
                $course_section->name = 'Section name not specified, but section# is:' . $course_section->section;

            }
            echo"<div>";

                //Notes on a Course Module Page
                if ($n % 2 == 0) {
                    echo"<div >$course_section->name</div>";
                    echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";
                    hidden_note_title_values($i, $note->courseid, $note->id);

                    echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";

                } else {
                    echo"<div >$course_section->name</div>";
                    echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";
                    hidden_note_title_values($i, $note->courseid, $note->id);

                    echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";

                }
            echo"</div>";
        //Notes on a Course Main Page
        } else {
            echo"<div >";
                if ($n % 2 == 0) {
                    echo"<div >Course Page</div>";
                    echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";
                    hidden_note_title_values($i, $note->courseid, $note->id);

                    echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
                } else {
                    echo"<div >Course Page</div>";
                    echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";
                    hidden_note_title_values($i, $note->courseid, $note->id);

                    echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
                }
            echo"</div>";
        }
        $n++;
        $i++;
    }
}

echo"</div>"; //end notebook
echo"</body></html>";
?>



