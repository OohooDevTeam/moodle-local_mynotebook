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

//Grabs the page url
//function curPageURL() {
//    $pageURL = 'http';
//    //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
//    $pageURL .= "://";
//    if ($_SERVER["SERVER_PORT"] != "80") {
//        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
//    } else {
//        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
//    }
//    return $pageURL;
//}
//Calls the export function
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
xmlhttp.open('GET','export.php?q='+str ,true);
xmlhttp.send();
}
";
    echo "</script>";
}

//Check whether the delete or restore button was clicked
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
          window.location.href = '$CFG->wwwroot/local/makenote/recycle.php?test=' + a;
    }";
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
    //Debugging
    echo $i . '</br>' . $courseid . '</br>' . $noteid;
}

?>