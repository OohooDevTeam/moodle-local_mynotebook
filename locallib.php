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
 * Internal library of functions for module mynotebook
 *
 * All the mynotebook specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package   mod_mynotebook
 * @copyright 2010 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Does something really useful with the passed things
 *
 * @param array $things
 * @return object
 */

//Reindex a single array
function reorderindex(array $source, $conditions_list = array()) {
    $i = 0;
    foreach ($source as $key => $val) {
        if ($key != $i) {
            unset($source[$key]);
            $source[$i] = $val;
        }
        $i++;
    }

    foreach ($source as $key => $val) {
        foreach ($conditions_list as $var) {
            if ($val === $var) {
                unset($source[$key]);
                $source = reorderindex($source, $conditions_list);
            }
        }
    }

    return $source;
}

//Reindex a multidimensional array (2)
function reindex_this_array($anArray) {
    if (!is_array($anArray)) {
        return $anArray;
    }

    $reindexed_array = array();
    foreach ($anArray as $anElement) {
        $reindexed_array[] = reindex_this_array($anElement);
    }

    return $reindexed_array;
}

//Exports the user notes
function call_to_export() {

    echo "<script type='text/javascript'>
function export_option(str)
{
if (str=='')
  {
  document.getElementById('Show_option').innerHTML='';
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById('Show_option').innerHTML=xmlhttp.responseText;
    }
  }
  console.log(str);
xmlhttp.open('GET','export.php?q='+str ,true);
xmlhttp.send();
}
";
    echo "</script>";
}

//Retrieves the notes that the user wants to merge together
function merge() {

echo "<script type='text/javascript'>
function merge_notes_left()
{

    var source = $('select#merge_left').val();
    console.log(source);
        console.log($('select#merge_left'));

    var destination = $('select#merge_right').val();
    console.log(destination);
        console.log($('select#merge_right'));

    $('#Merge_result').load('mergenotes.php', {'source': source, 'destination': destination});

}";
    echo "</script>";
}

//Check whether the delete or restore button was clicked in the recycle bin
function check_button_clicked() {
    global $CFG;
    echo "<script type='text/javascript'>
    function checkData(id) {
       switch(id) {
          case 'delete':
           var a = 'delete';
             break;
          case 'restore':
           var a = 'restore';
             break;
        }
    console.log(a);
          window.location.href = '$CFG->wwwroot/local/mynotebook/recycle.php?' + a + '=' + a;
    }";
    //          window.location.href = '$CFG->wwwroot/local/mynotebook/recycle.php?test=' + a;
    echo "</script>";
}

//Permeantly delete the notes
function delete_notes() {
    global $DB, $USER;
    if (!empty($_POST['checkbox'])) {
        for ($i = 0; $i < count($_POST['checkbox']); $i++) {
            $DB->delete_records('notes', array('id' => $_POST['checkbox'][$i], 'userid' => $USER->id));
        }
    }
}

//Restores the notes
function restore_notes() {
    global $DB, $USER;
    if (!empty($_POST['checkbox'])) {
        for ($i = 0; $i < count($_POST['checkbox']); $i++) {
            $update2 = $DB->get_record('notes', array('id' => $_POST['checkbox'][$i], 'userid' => $USER->id));
            $update2->deleted = 0;
            $DB->update_record('notes', $update2);
        }
    }
}

//Select all the boxes
function check_all() {

    echo "<script language='JavaScript'>

      checked = false;
      function checkedAll () {
        if (checked == false){
        checked = true
        } else {
        checked = false
        }
	for (var i = 0; i < document.getElementById('check').elements.length; i++) {
	  document.getElementById('check').elements[i].checked = checked;
	}
        console.log('Grabbed All IDs')
      }
";
    echo "</script>";
}

//Limits the number of charater a text can have
function text_limit($text) {
    $chars = 13;
    $points = (strlen($text) > $chars) ? '...' : '';
    return (substr($text, 0, $chars) . "" . $points);
}

//Stores all the record for the note titles in hidden fields
function hidden_note_title_values($i, $courseid, $noteid) {
    echo "<input id='iterator' type='hidden' value=' $i '/>";
    echo "<input id='courseid$i' type='hidden' value=' $courseid '/>";
    echo "<input id='note_id$i' type='hidden' value=' $noteid '/>";
}


function display_courses_2_merge(){
    global $DB, $USER;
    merge();

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
    //Finds all courses with no notes, reorders them, and then stores it
    if (sizeof($registered_courseids) > sizeof($reordered_courseid)) {
        $course_no_notes = array_diff($registered_courseids, $reordered_courseid);
        $course_no_notes = reorderindex($course_no_notes);
    } else {
        $course_no_notes = array_diff($reordered_courseid, $registered_courseids);
        $course_no_notes = reorderindex($course_no_notes);
    }
    $number_no_notes = sizeof($course_no_notes);
    $count = sizeof($course_name);

    echo "<div id='merge_left' title='Merge Notes'>";
    echo "<fieldset>";
    echo"<form>";
    //Course on left hand
    echo "Source:</br>";
    echo "<select style='width:200px' name='merge_left' id='merge_left' onchange='merge_notes_left()'>";
        //Displays courses with notes
        for ($i = 0; $i < $count; $i++) {
            echo "<optgroup label='$course_name[$i]'</optgroup>";
            $courseid = $DB->get_record('course', array('fullname'=>$course_name[$i]));
            $course_notes = $DB->get_records('notes', array('userid'=>$USER->id, 'courseid'=>$courseid->id));
            foreach ($course_notes as $notes){
                echo "<option value='$notes->name'>$notes->name</option>";
            }

        }

        //Courses with no notes as greyed out
        for ($j = 0; $j < $number_no_notes; $j++) {
            $coursenames = $DB->get_record('course', array('id' => $course_no_notes[$j]));
            if (strlen($coursenames->fullname) < 28) {
                $no_notes = $coursenames->fullname;
            } else {
                $no_notes = substr($coursenames->fullname, 0, 27);
                $no_notes = $no_notes . "...";
            }
            echo "<optgroup label='$no_notes' disabled='disabled'></optgroup>";
        }
    echo"</select>";
    echo"</form>";
    echo"</fieldset>";
//    echo"<div id='Merge_left_option'></div>";
    echo"</div>";

    echo "<div id='merge_right' title='Merge Notes'>";
    echo "<fieldset>";
    echo"<form>";
    //Course on right hand
    echo "Destination:</br>";
    echo "<select style='width:200px' name='merge_right' id='merge_right' onchange='merge_notes_left()'>";
        //Displays courses with notes
        for ($i = 0; $i < $count; $i++) {
            echo "<optgroup label='$course_name[$i]'</optgroup>";
            $courseid = $DB->get_record('course', array('fullname'=>$course_name[$i]));
            $course_notes = $DB->get_records('notes', array('userid'=>$USER->id, 'courseid'=>$courseid->id));
            foreach ($course_notes as $notes){
                echo "<option value='$notes->name'>$notes->name</option>";
            }
        }

        //Courses with no notes as greyed out
        for ($j = 0; $j < $number_no_notes; $j++) {
            $coursenames = $DB->get_record('course', array('id' => $course_no_notes[$j]));
            if (strlen($coursenames->fullname) < 28) {
                $no_notes = $coursenames->fullname;
            } else {
                $no_notes = substr($coursenames->fullname, 0, 27);
                $no_notes = $no_notes . "...";
            }
            echo "<optgroup label='$no_notes' disabled='disabled'></optgroup>";
        }
    echo"</select>";
    echo"</form>";
    echo"</fieldset>";
//    echo"<div id='Merge_right_option'></div>";
    echo"</div>";


    echo"<div id='Merge_result'></div>";

    }

    function merge_button(){
            echo "<script language='JavaScript'>

      function mergenotes () {
        console.log('HELLO');
      }
";
    echo "</script>";
    }

?>