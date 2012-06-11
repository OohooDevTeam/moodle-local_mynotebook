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
//$PAGE->requires->css('/local/mynotebook/css/paper.css');
$PAGE->requires->css('/local/mynotebook/css/followtab.css');


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
// Output starts here
echo $OUTPUT->header();

/* * ******************************************************** *///Javascript declaration
//Another way of including js
//echo<<<SCRIPT
//..your js file
//SCRIPT;

echo"<script type='text/javascript' src='js/jquery-1.7.2.js'></script>";
echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'></script>";
//echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.tabs.js'></script>";
//

////<!--JS for page flip animation-->
//echo"<script type='text/javascript' src='js/turn.js'></script>";


//Scripts needed for jquery popup dialog
echo<<<SCRIPT
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.mouse.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.draggable.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.position.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.resizable.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.effects.core.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.effects.blind.js"></script>
	<script src="js/jquery-ui-1.8.18.custom/development-bundle/ui/jquery.effects.explode.js"></script>
SCRIPT;
//Global variables for trigger.js and turn.js, files which make page flipping work
echo"<script type='text/javascript'>
    var handle;
</script>";
echo"<script type='text/javascript' src='js/trigger.js'></script>";

//$tinymce = new tinymce_texteditor();
//echo"<script type='text/javascript' src='tinymce/jscripts/tiny_mce/tiny_mce.js'></script>";
//echo"<script type='text/javascript' language='javascript' src='$CFG->wwwroot/lib/editor/tinymce/tiny_mce/$tinymce->version/jquery.tinymce.js'></script>";
//echo"<script type='text/javascript' language='avascript' src='$CFG->wwwroot/lib/editor/tinymce/tiny_mce/$tinymce->version/tiny_mce.js'></script>";
//echo"<script type='text/javascript' src='js/test.js'></script>";
//echo"<style type='text/css'>
//	body		{ margin: 0; }
//	a		{ margin: 1px 3px; }
//	#wrap		{ width: 1024px; margin: 0 auto; }
//	#content	{ border: 1px dotted #333; padding: 0 10px; }
//	#overlay	{ top: 0; left: 0; position: absolute; width: 100%; height: 100%; background: #000000; opacity: .5; z-index:5; }
//	#edit_area	{ z-index:10; position: absolute; width: 800px; left: 150px; top: 100px; }
//
//</style>";
//<!--<script type='text/javascript' src='js/IE9.js'></script>
//[if lt IE 9]>
//<script src='http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js'></script>
//<![endif]-->


//echo"<form method='post' action='somepage' id='edit'>
//    <div id='wrap' >
//        <div id='content' style='display:none;'>
//                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc turpis magna, dapibus eget egestas quis, vulputate quis dolor. Ut quis ligula condimentum orci volutpat euismod eget ut turpis. Donec ac ligula erat. Mauris eu dui sem, id auctor nisl. Aenean sagittis mauris tellus, sit amet consectetur velit. Nam a magna dolor, vitae sollicitudin odio. Cras id orci est, ut suscipit nunc. Vestibulum aliquet nisi arcu. In eu ligula ac purus rutrum pharetra. Integer non nunc quam. Vivamus laoreet nibh vitae dolor aliquet et sodales felis sodales. Cras eu libero eget mi porta pharetra. Nam quis sapien eu massa convallis scelerisque. Nam quam tellus, ullamcorper in aliquet quis, imperdiet a tellus. Duis ut leo erat, sit amet ultrices neque.</p>
//                <p>Sed at risus sit amet nibh ullamcorper porta ac quis leo. Aliquam convallis vulputate tincidunt. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus aliquam rhoncus condimentum. Nunc malesuada quam ac neque ornare at vehicula sapien tristique. Donec quis luctus sem. Nulla rhoncus scelerisque ligula, nec rutrum nulla accumsan in. Maecenas nec dignissim urna. Maecenas gravida dictum arcu, eget varius ligula pulvinar ut. Nulla adipiscing odio turpis, ut volutpat dui.</p>
//                <p>Duis et leo mauris, ornare varius felis. Mauris metus est, hendrerit quis volutpat ut, consequat sit amet massa. Curabitur enim elit, tempor eget imperdiet nec, vehicula sed diam. Maecenas lorem magna, cursus vel dapibus vitae, dignissim a eros. Sed ultrices sagittis magna eu vestibulum. Etiam dolor massa, mollis id volutpat id, consequat in nisi. Nunc ornare luctus sem vel iaculis. Suspendisse quis scelerisque enim. Quisque vulputate suscipit sodales. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum massa arcu, elementum at dictum a, consequat sit amet erat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum elementum mattis libero a laoreet. Sed rutrum purus in lacus posuere varius. Fusce viverra velit at tortor posuere bibendum porttitor ut ligula. Phasellus vehicula semper nulla, quis ultrices erat sollicitudin at. Aliquam laoreet mi et magna aliquam ut tristique ipsum bibendum. Cras id quam justo. Donec tristique elementum euismod.</p>
//                <p>Sed ornare sapien ac est commodo a tincidunt diam tristique. Aliquam elit leo, volutpat sed malesuada sit amet, rhoncus eget nunc. Suspendisse id nisl sem, sit amet cursus metus. Donec fermentum, tortor eget egestas auctor, felis felis placerat odio, sit amet rutrum justo enim sit amet sapien. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent consectetur, ligula quis luctus laoreet, turpis velit sodales dui, quis consequat tortor ipsum quis est. Mauris euismod posuere magna sit amet lacinia. Nam sit amet vestibulum nulla. Proin dapibus mauris eu velit sagittis mollis. Praesent semper odio eu metus ullamcorper pulvinar. Mauris et odio in neque fermentum ornare eu quis tortor. Pellentesque tempor tempor orci, at dictum lorem aliquet iaculis. Suspendisse iaculis dapibus dignissim. In ornare consectetur metus lacinia placerat.</p>
//                <p>Etiam sagittis commodo interdum. Sed et nulla ut eros pulvinar facilisis sit amet sit amet elit. Phasellus ac mauris sem. Sed lacus magna, volutpat eu blandit at, convallis dapibus justo. Nunc tempus hendrerit suscipit. Maecenas in turpis non orci malesuada vulputate eget et mi. Proin vel libero vitae erat lobortis dignissim sed vel metus. Donec risus velit, commodo quis mollis sed, gravida ut felis. Fusce tempor magna vel neque accumsan posuere. Mauris pharetra nibh nec neque bibendum sed varius risus auctor. Duis sed fermentum mi.</p>					
//        </div>			
//        <a href='#' id='load'>Load TinyMCE</a>
//    </div>
//</form>";

/* * ******************************************************** *///End Javascript declaration

$courses = enrol_get_users_courses($USER->id);
$registered_courseids = array();
$registered_courseids = array_keys($courses);
//echo"USER REGISTERED COURSES:</br>";
//print_object($registered_courseids);
//Extracts the courses and orders alphabetically
//$sql = "SELECT *
//                FROM {course} th
//                WHERE th.category = '1' ORDER BY th.fullname";
//$all_courses = $DB->get_records_sql($sql);
//Grabs all the course ids that have notes
$allcourseids = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$courseid_array = array();
$coursename_array = array();
$b = 0;
foreach ($allcourseids as $courseid) {
//    //Stores the coursename and course ids

    $coursenames = $DB->get_records('course', array('id' => $courseid->courseid));
    $courseid_array[] = $courseid->courseid;
//
    foreach ($coursenames as $coursename) {
        $coursename_array[] = $coursename->fullname;
    }
}
//echo"COURSE NAMES WITH NOTE:</br>";
//print_object($coursename_array);
//echo"COURSE IDS WITH NOTES:</br>";
//print_object($courseid_array);
//Filters out the duplicate course ids and names and then reorders them
$conditions_list = array(TRUE, FALSE, NULL);
$unique_course_id = array_unique($courseid_array);
$ordered_course_id = reorderindex($unique_course_id, $conditions_list);
//
$unique_course_name = array_unique($coursename_array);
$ordered_course_name = reorderindex($unique_course_name, $conditions_list);

//echo"REINDEXED NAMES:</br>";
//print_object($ordered_course_name);
//echo"REINDEXED IDS:</br>";
//print_object($ordered_course_id);

$course_no_notes = array();
$course_yes_notes = array();
//Finds the courses that the users have no notes in
if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
    $course_no_notes = array_diff($registered_courseids, $ordered_course_id);
    $course_no_notes = reorderindex($course_no_notes);
} else {
    $course_no_notes = array_diff($ordered_course_id, $registered_courseids);
    $course_no_notes = reorderindex($course_no_notes);
}

//Finds the courses that the users do have notes in
if (sizeof($registered_courseids) > sizeof($ordered_course_id)) {
    $course_yes_notes = array_intersect($registered_courseids, $ordered_course_id);
    $course_yes_notes = reorderindex($course_yes_notes);
} else {
    $course_yes_notes = array_intersect($ordered_course_id, $registered_courseids);
    $course_yes_notes = reorderindex($course_yes_notes);
}
//echo"COURSE WITH NO NOTES:";
//print_object($course_no_notes);
//echo"COURSE WITH NOTES:";
//print_object($course_yes_notes);

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
                                echo"<a href='#url'>$a. $trimmed_name</a><br />";
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
echo"<ul id='followTab'>
    <li><button class='export'><img src='images/export.png' title='Export Notes'/></button></li>
<li><button class='bookmark'><img src='images/bookmark_icon.png' title='Add Bookmark'/></button></li>
<li><button class='settings'><img src='images/settings.png' title='Settings'/></button></li>
<li><a class='recyclebin' href='recycle.php'><img src='images/recycle.png' title='Recycle Bin'/></a></li>
</ul>";

//Calls the export function
call_to_export();

//Hides all the dialog divs
echo"<div style='display:none'>";
    //div where notebook will popup
    echo"<div id='target' ></div>";

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
    echo"</div>";

    echo"<div id='bookmark' title='Bookmark'></div>";
    echo"<div id='settings' title='Settings'></div>";
    echo"<div id='recyclebin' title='Recycle Bin'></div>";

echo"</div>";

//// Finish the page
echo $OUTPUT->footer();
?>






<!--JS for setting and getting textarea cursoe position
http://blog.vishalon.net/index.php/javascript-getting-and-setting-caret-position-in-textarea/-->
<!--<script>
    function doGetCaretPosition (ctrl) {

        var CaretPos = 0;
        // IE Support
        if (document.selection) {

            ctrl.focus ();
            var Sel = document.selection.createRange ();

            Sel.moveStart ('character', -ctrl.value.length);

            CaretPos = Sel.text.length;
        }
        // Firefox support
        else if (ctrl.selectionStart || ctrl.selectionStart == '0')
            CaretPos = ctrl.selectionStart;

        return (CaretPos);

    }

    function setCaretPosition(ctrl, pos)
    {

        if(ctrl.setSelectionRange)
        {
            ctrl.focus();
            ctrl.setSelectionRange(pos,pos);
        }
        else if (ctrl.createTextRange) {
            var range = ctrl.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }

    function process()
    {
        var no = document.getElementById('no').value;
        setCaretPosition(document.getElementById('get'),no);
    }

</script>
<textarea id="get" name="get" rows="5" cols="31">Please write some integer in the textbox given below and press "Set Position" button. Press "Get Position" button to get the position of cursor.</textarea>
<br>
Enter Caret Position: <input type="text" id="no" size="1" /><input type="button" onclick="process();" value="Set Position">
<BR>
<input type="button" onclick="alert(doGetCaretPosition(document.getElementById('get')));"
       value="Get Position">-->
