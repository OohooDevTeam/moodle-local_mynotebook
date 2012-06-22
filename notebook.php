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
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/mod_form.php');

global $CFG, $DB, $USER, $PAGE;
$courseid = required_param('courseid', PARAM_INT);

//Was added since error in moodle 2.0
$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/notebook.php');
////require_login($course, true, $cm);
require_login();

/* Should use output header for pages that are used in popups and dialogs since they
will not display properly */
echo"<html><head>";

global $CFG, $USER, $DB;


//echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/js/jquery-ui-1.8.18.custom/css/ui-lightness/jquery-ui-1.8.18.custom.css'/>";
echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/notebook.css'/>";
echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/paper.css'/>";
echo"<link  rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/development/source/example249/css/menu.css'/>";

/* * ******************************************************** *///Javascript declaration
//Do not need to include again since this modal uses the jquery from the main page
//It will override the other jquery that was called already
//We only include it again when you have a popup or a new window
echo"<script type='text/javascript' src='js/jquery-1.7.2.js'></script>";
echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'></script>";

//echo"<script type='text/javascript'>
//    var handle;
//</script>";
//
//<!--JS for page flip animation-->
echo"<script type='text/javascript' src='js/turn.js'></script>";

//<!--JS for the view page-->
echo"<script type='text/javascript' src='js/notebook.js'></script>";
/* * ******************************************************** *///End Javascript declaration
//$tinymce = new tinymce_texteditor();
echo"<script type='text/javascript' src='tinymce/jscripts/tiny_mce/tiny_mce.js'></script>";
//echo"<script type='text/javascript' language='javascript' src='$CFG->wwwroot/lib/editor/tinymce/tiny_mce/$tinymce->version/jquery.tinymce.js'></script>";
//echo"<script type='text/javascript' language='avascript' src='$CFG->wwwroot/lib/editor/tinymce/tiny_mce/$tinymce->version/tiny_mce.js'></script>";
echo"<script type='text/javascript' src='js/test1.js'></script>";

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

/***************************************************/
//Menubar for all coursenotes for quick access
echo"<span ><ul id='nav'>";
    
for ($j = 0; $j < sizeof($ordered_course_id); $j++) {
    //Limits the text to 10 chars
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

/***************************************************/
//buttons on the right of the page
echo"<span><ul id='options'>"; 
    echo"<li><a class='hsubs ' href='#'><img src='images/help_icon.gif'/></a></li>";
    echo"<li><a class='hsubs ' href='#'><img src='images/save.png'/></a></li>";
    echo"<li><a class='hsubs '>
        <div id='controls'>
            <label for='page-number'>Page:</label> <input type='text' size='3' id='page-number'> of <span id='number-pages'></span>
        </div>
    </a></li>";

echo"</ul></span>"; // End options
/***************************************************/

$course = $DB->get_record('course', array('id' => $courseid));

echo"<div id='notebook'>";
    echo"<div id='cover'>";
        echo"<div id='notetitleleft'>$course->fullname</div>";
    echo"</div>";//end cover
    
    
    $n = 0;
foreach ($notes as $note) {
//    echo $note->courseid;
//    echo $note->id;
    if ($courseid == $note->courseid) {
//        //Strip all html tags
////        $trimmed = strip_tags($note->text);
//        $trimmed  = urlencode($note->text);
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
                    
            //Notes on a Course Module Page            
            if ($n % 2 == 0) {
                echo"<div >$course_section->name</div>";    
                echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";

echo "<input id='courseid1' type='hidden' value=' $note->courseid '/>";
echo "<input id='note_id1' type='hidden' value=' $note->id '/>";
                echo $note->courseid . '</br>' . $note->id;
                
                echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
           
            } else {
                echo"<div >$course_section->name</div>";    
                echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";

echo "<input id='courseid1' type='hidden' value=' $note->courseid '/>";
echo "<input id='note_id1' type='hidden' value=' $note->id '/>";
                echo $note->courseid . '</br>' . $note->id;
                
                echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
            }
            echo"</div>";  
            
        } else { //Notes on a Course Main Page
            echo"<div >";
            if ($n % 2 == 0) {
                echo"<div >Course Page</div>";    
                echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";

echo "<input id='courseid1' type='hidden' value=' $note->courseid '/>";
echo "<input id='note_id1' type='hidden' value=' $note->id '/>";
                echo $note->courseid . '</br>' . $note->id;
                
                echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
           
            } else {
                echo"<div >Course Page</div>";  
                echo"<div id='pagenum'><input class='title' type='text' value='$note->name' style='border:0px; text-align:center; font:18px bold;' maxlength='18'/></div>";

echo "<input id='courseid1' type='hidden' value=' $note->courseid '/>";
echo "<input id='note_id1' type='hidden' value=' $note->id '/>";
                echo $note->courseid . '</br>' . $note->id;
                
                echo"<iframe src='notepage.php?note_id=$note->id&courseid=$courseid' style='height:100%; width:100%'></iframe>";
            }
            echo"</div>";  
        }
        $n++;
    }
}
    
    
    
    
    
//    echo"<iframe src='notepage.php?courseid=$courseid&n=$n' style='height:100%; width:100%'></iframe>";

    
echo"</div>";//end notebook

/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/
/*
echo '<div id="viewport">
<header>
	<nav>
		<a href="#home" class="on">Home</a>
		<a href="#usage">Usage</a>
		<a href="#get">Get turn.js</a>
		<a href="#reference">Reference</a>
		<a href="#credits">Credits</a>
	</nav>
</header>';
echo'<div id="controllers" style="display:none;">';
	echo'<div class="pages shadows" id="magazine">';	
		echo'<!-- Home -->	
		<div turn-effect="flipboard">
			<p>The awesome paper-like effect made for HTML5</p>
		</div>
		';
		echo'<!-- Usage -->
		<div> 
			<div class="page-content">
				<h1>turn.js</h1>
			</div>
		</div>
                ';    
		echo'<!-- Quick Reference -->
		<div> 
			<div class="page-content">
			<h2>Getting Started</h2>
			</div>
		</div>
		<!--   -->
		<div> 
			<div class="page-content">

				<h2> Contact </h2>
			</div>
		</div>
	</div>
	<div id="next"> <i></i> </div>
	<div id="previous"> <i></i> </div>
	<div id="shadow-page"></div>
</div>

</div>';
*/

//Old code for displaying notes on a page
//Creates the pages for each note
//foreach ($notes as $note) {
//    if ($courseid == $note->courseid) {
////        //Strip all html tags
//////        $trimmed = strip_tags($note->text);
////        $trimmed  = $note->text;
////
//        $section = $DB->get_record('course_modules', array('id' => $note->cmid, 'course' => $note->courseid));
//        $format = $DB->get_record('course', array('id' => $note->courseid));
////        $var=json_encode($format);
////echo"<script>console.log($var);</script>";
////        //If the section var exists for a course activity
//        if ($section) {
//            $sql = "SELECT *
//                    FROM {course_sections} th
//                    WHERE th.id = '$section->section' AND th.course = '$note->courseid'";
//            $course_section = $DB->get_record_sql($sql);
////
//            if ($course_section->name == NULL) {
//                $course_section->name = 'Section name not specified, but section# is:' . $course_section->section;
//            }
////            //debugging
////        echo "section=" . $section->section . "</br>";
////        echo "sectionid=" . $section->id . "</br>";
////        echo "section=" . $course_section->section . "</br>";
////            echo"<div id='pagenum'>";
//            if ($n % 2 == 0) { //Notes on a Course Module Page
////                echo"<div id='notetitleright'>$course_section->name</div>";
////                echo"<textarea id='pagetextright' class='paper'>
////                           \n $note->name 
////                            \n
////                            $trimmed
////                        </textarea>";
//////                echo"</div>";
//                echo"<iframe src='notepage.php?courseid=$courseid' style='height:100%; width:100%'></iframe>";
//
//            } else {
//////                echo"<div id='pagenum'>";
////                echo"<div id='notetitleright'>$course_section->name</div>";
////                echo"<textarea id='pagetextright' class='paper'>
////                           \n $note->name 
////                            \n
////                            $trimmed
////                        </textarea>";
//                echo"<iframe src='notepage.php?courseid=$courseid' style='height:100%; width:100%'></iframe>";
//
//            }
////            echo"</div>";  
//        } else { //Notes on a Course Main Page
////            echo"<div id='pagenum'>";
//            if ($n % 2 == 0) {
//////                echo"<div id='notetitleright'>Course Page</div>";
//////                echo"<textarea id='pagetextright' class='paper'>
//////                           \n $note->name 
//////                            \n
//////                            $trimmed
//////                        </textarea>";
//                echo"<iframe src='notepage.php?courseid=$courseid' style='height:100%; width:100%'></iframe>";
//
//            } else {
//////                echo"<div id='notetitleleft'>Course Page</div>";
//////                echo"<textarea id='pagetextleft' class='paper'>
//////                           \n $note->name 
//////                            \n
//////                            $trimmed
//////                        </textarea>";
//                echo"<iframe src='notepage.php?courseid=$courseid' style='height:100%; width:100%'></iframe>";
//
//            }
////            echo"<iframe src='notepage.php?courseid=$courseid' style='height:100%; width:100%'></iframe>";
////            //echo "<h1 id='in_iframe'>Test</h1>";
////            echo"</div>";  
//        }
//        $n++;
//    }
//}


echo"</body></html>";
?>



