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
 *
 * Prints a particular instance of mynotebook
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package   mod_mynotebook
 * @copyright 2012 ????
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/mod_form.php');

global $CFG, $DB, $USER, $PAGE;

//CSS files
$PAGE->requires->css('/local/mynotebook/js/jquery-ui-1.8.18.custom/css/ui-lightness/jquery-ui-1.8.18.custom.css');
$PAGE->requires->css('/local/mynotebook/css/view.css');
$PAGE->requires->css('/local/mynotebook/css/cssplay6.css');
$PAGE->requires->css('/local/mynotebook/css/target.css');
$PAGE->requires->css('/local/mynotebook/css/paper.css');
$PAGE->requires->css('/local/mynotebook/css/followtab.css');

//$PAGE->requires->css('/local/mynotebook/demo/jquery-ajax/css/tutorial.css');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_pagelayout('standard');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n = optional_param('n', 0, PARAM_INT);  // mynotebook instance ID - it should be named as the first character of the module

$system = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/local/mynotebook/view.php');
$PAGE->set_context($system);

require_login();

$title = 'Notebook';
//Sets the page title
$PAGE->set_title($title);
$PAGE->set_heading($USER->firstname . '\'s ' . $title);

//JS files
$PAGE->requires->js('/local/mynotebook/js/jquery-1.7.2.js', true);
$PAGE->requires->js('/local/mynotebook/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js', true);
$PAGE->requires->js('/local/mynotebook/js/trigger.js', true);

//$PAGE->requires->js('/local/mynotebook/demo/jquery-ajax/js/tutorial.js');
//$PAGE->requires->js('/local/mynotebook/js/essential_functions.js', true);


echo $OUTPUT->header();


//Grabs all courses of the user
$courses = enrol_get_users_courses($USER->id);
$registered_courseids = array();
$registered_courseids = array_keys($courses);

//Grabs all the course ids that have notes
$allcourseids = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$courseid_array = array();
$coursename_array = array();
$b = 0;

foreach ($allcourseids as $courseid) {
    //Stores the coursename and course ids
    $coursenames = $DB->get_records('course', array('id' => $courseid->courseid));
    $courseid_array[] = $courseid->courseid;

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

$course_no_notes = array();
$course_yes_notes = array();

//Finds the courses that the users have no notes in
//This is done both ways to ensure all the courses are included
if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
    $course_no_notes = array_diff($registered_courseids, $ordered_course_id);
    $course_no_notes = reorderindex($course_no_notes);
} else {
    $course_no_notes = array_diff($ordered_course_id, $registered_courseids);
    $course_no_notes = reorderindex($course_no_notes);
}

//Finds the courses that the users have notes in
//This is done both ways to ensure all the courses are included
if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
    $course_yes_notes = array_intersect($registered_courseids, $ordered_course_id);
    $course_yes_notes = reorderindex($course_yes_notes);
} else {
    $course_yes_notes = array_intersect($ordered_course_id, $registered_courseids);
    $course_yes_notes = reorderindex($course_yes_notes);
}

$notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));

//Deleting this div will break the side bar
echo"<div id='topshelf'>";
/* * ******************************************************************************* */
//Creates the book on the shelf and passes the courseid as well
//The course name will have a text limit of 20
echo"<div id='book'>";
$a = 0;

//The max number of courses should be 12
//Loops to grab the notes of the specified user course**************************
echo"<ul class='topUL'>";
for ($k = 0; $k < sizeof($ordered_course_id); $k++) {
    $p = $k + 1;
//    //Limits the length of the course name
    $name = substr($ordered_course_name[$k], 0, 18);
//    //Displays notebook when clicked
    if (strlen($name < 18)) {
        //Do nothing
    } else {
        $name = $name . "...";
    }

    $test = json_encode($course_yes_notes);
        //Creates the books on the shelf
        echo"<li class='b$p'><a array='$test' coursename='$name' href='notebook.php?courseid=$ordered_course_id[$k]' class='p1 ajaxtrigger' ><span>$name</span></a>";
            echo"<ul class='sub'>";
                echo"<li class='cover'>$name<br /><em>Hover to open ...</em></li>";
                echo"<li class='content'>";
                    echo"<b>Content</b><br />";
                    //Displays the content when you hover over the book
                    foreach ($notes as $note) {
                        if ($note->courseid == $ordered_course_id[$k]) {
                            if (strlen($note->name) < 18) {
                                $trimmed_name = $note->name;
//                                echo"<a href='#url'>$a. $trimmed_name</a><br />";
                                  echo"<div>$a. $trimmed_name</div><br />";
                            } else {
                                $trimmed_name = substr($note->name, 0, 18);
                                $trimmed_name .= '...';
                                echo"<a href='#url' title='$note->name'>$a. $trimmed_name</a><br />";
                            }
                            $a++;
                        }
                    }
                echo"</li>";
            echo"</ul>"; //End sub
        echo"</li>";
    $a = 0;
}

//Displays the books with no notes in grey dotted lines
//    echo"<ul class='topUL'>";
for ($m = 0; $m < sizeof($course_no_notes); $m++) {
    $coursenames = $DB->get_record('course', array('id' => $course_no_notes[$m]));
    //checks length of name and limits the displayed coursename on each book if 15 characters or more
    if (strlen($coursenames->fullname) < 15) {
        $no_notes = $coursenames->fullname;
    } else {
        $no_notes = substr($coursenames->fullname, 0, 14);
        $no_notes .= "...";
    }
    echo"<li class='faded'><a class='fadedbook'><span>$no_notes (No Notes)</span></a></li>";
}
echo"</ul>"; // End topUL


echo"<div class='shelf'></div>";
echo"</div>"; //End book div
echo"</div>"; //End topshelf div

//Menu on the right to export notes, add bookmarks, change settings, and check recycle bin
echo"<ul id='followTab'>";
echo"<li><button class='export'><img src='images/export.png' title='Export Notes'/></button></li>";
//echo"<li><a class='export1' href='html2word.php'><img src='images/export.png' title='Export1 Test'/></a></li>";
//echo"<li><button class='export1'><img src='images/export.png' title='Export1 Test'/></button></li>";

//echo"<li><a class='merge' href='mergenotes.php'><img src='images/merge.png' title='Merge Notes'/></a></li>";
echo"<li><button class='merge'><img src='images/merge.png' title='Merge Notes'/></button></li>";

echo"<li><button class='bookmark'><img src='images/bookmark_icon.png' title='Add Bookmark'/></button></li>";
//echo"<li><button class='settings'><img src='images/settings.png' title='Settings'/></button></li>";
echo"<li><a class='recyclebin' href='recycle.php'><img src='images/recycle.png' title='Recycle Bin'/></a></li>";
echo"</ul>";

//Calls the export function
call_to_export();

//Hides all the dialog divs
echo"<div style='display:none'>";
    //div where notebook will popup
    echo"<div id='target' ></div>";

    //All the different side menu popups
    //***************************************************
    //Popup for exporting notes
    echo"<div id='export' title='Export Notes'>";
        echo"<fieldset>";
            echo "<form>
                Export:
                <select name='export' onchange='export_option(this.value)'>
                <option value=''>None</option>
                <option value='All Notes'> All Notes </option>
                <option value='Course Notes'> Course Notes </option>
                </select>
            </form>
        </fieldset>
        <div id='Show_option'></div>";
    echo"</div>";//export

    //Merge Notes
//    echo"<div id='merge' title='Merge Notes'></div>";
        echo"<div id='merge' title='Merge Notes'>";
        display_courses_2_merge();
            
        merge();
        echo "<button onclick='merge_notes()'><img src='images/merge.png' title='Merge'/>MAGIC!</button>";

        echo"</div>";

    //Bookmarks
    echo"<div id='bookmark' title='Bookmark'></div>";

    //Settings
//    echo"<div id='settings' title='Settings'></div>";

    //Recycle Bin
    echo"<div id='recyclebin' title='Recycle Bin'></div>";

echo"</div>";//End display:none div

//// Finish the page
echo $OUTPUT->footer();
?>