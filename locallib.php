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

defined('MOODLE_INTERNAL') || die();

/**
 * Reorders a single array index in ascending sequential order
 *
 * @param array $source This array holds the array to be reindexed
 * @param array $conditions_list This array holds the conditions for reindexing
 * @return array Returns the reindexed array
 */
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
xmlhttp.open('GET','export.php?q='+str ,true);
xmlhttp.send();
}
";
    echo "</script>";
}

//Limits the number of charater a text can have
/**
 * Cuts of the string if more than 13 characters and adds ellipses
 *
 * @param string $text This string is the text to be trimmed
 * @return string Returns the substring
 */
function text_limit($text) {
    $chars = 13;
    $points = (strlen($text) > $chars) ? '...' : '';
    return (substr($text, 0, $chars) . "" . $points);
}

//Stores all the record for the note titles in hidden fields
/**
 * This function contains hidden input fields for storing the note title
 *
 * @param int $i This number is for a unique courseid and noteid and act as an iterator
 * @param int $courseid This number is for finding the course the note is taken
 * @param int $noteid This number is for finding the note
 */
function hidden_note_title_values($i, $courseid, $noteid) {
    echo "<input id='iterator' type='hidden' value=' $i '/>";
    echo "<input id='courseid$i' type='hidden' value=' $courseid '/>";
    echo "<input id='note_id$i' type='hidden' value=' $noteid '/>";
}

/**
 * Displays 2 drop down menu for the user to merge their notes
 *
 * @global moodle_database $DB
 * @global stdClass $USER
 */
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

    //Left drop down menu
    echo "<div id='merge_left' title='" . get_string('merge_title', 'local_mynotebook'). "'>";
    echo    "<fieldset>";
    echo        "<form>";
    //Course on left hand
    echo            get_string('source', 'local_mynotebook');
    echo"</br>";
    echo            "<select style='width:200px' name='merge_left' id='merge_left'>";

                    //Displays courses with notes
                    for ($i = 0; $i < $count; $i++) {
                        echo "<optgroup label='$course_name[$i]'</optgroup>";
                        $courseid = $DB->get_record('course', array('fullname'=>$course_name[$i]));
                        $course_notes = $DB->get_records('notes', array('userid'=>$USER->id, 'courseid'=>$courseid->id, 'deleted'=>0));
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
    echo            "</select>";
    echo        "</form>";
    echo    "</fieldset>";
    echo "</div>";

    //Right drop down menu
    echo "<div id='merge_right' title='" . get_string('merge_title', 'local_mynotebook'). "'>";
    echo    "<form>";
    echo        "<fieldset>";

    echo            "</br>";

    //Course on right hand
    echo            get_string('destination', 'local_mynotebook');
    echo"</br>";
    echo            "<select style='width:200px' name='merge_right' id='merge_right'>";

                    //Displays courses with notes
                    for ($i = 0; $i < $count; $i++) {
                        echo "<optgroup label='$course_name[$i]'</optgroup>";
                        $courseid = $DB->get_record('course', array('fullname'=>$course_name[$i]));
                        $course_notes = $DB->get_records('notes', array('userid'=>$USER->id, 'courseid'=>$courseid->id, 'deleted'=>0));
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
    echo            "</select>";
    echo        "</fieldset>";
    echo    "</form>";
    echo"</div>";

    echo"<div id='Merge_result'></div>";
}

//Retrieves the notes that the user wants to merge together
function merge() {

echo "<script type='text/javascript'>
function merge_notes()
{
    var source = $('select#merge_left').val();
    var destination = $('select#merge_right').val();

    $('#Merge_result').load('mergenotes.php', {'source': source, 'destination': destination});

    $('#merge').dialog('isOpen');
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
            window.location.href = '$CFG->wwwroot/local/mynotebook/view.php?delete=' + id;
            break;
          case 'restore':
            window.location.href = '$CFG->wwwroot/local/mynotebook/view.php?restore=' + id;
            break;
        }
    }";
    echo "</script>";
}

//Permeantly delete the selected notes
/**
 * Permanently deletes the selected note(s)
 *
 * @global moodle_database $DB
 * @global stdClass $USER
 */
function delete_notes() {
    global $DB, $USER;
    if (!empty($_POST['checkbox'])) {
        for ($i = 0; $i < count($_POST['checkbox']); $i++) {
            $DB->delete_records('notes', array('id' => $_POST['checkbox'][$i], 'userid' => $USER->id));
        }
    }
}

//Restores the selected notes
/**
 * Restores the selected note(s)
 *
 * @global moodle_database $DB
 * @global stdClass $USER
 */
function restore_notes() {
    global $DB, $USER;
    echo $_POST['checkbox'];
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

/**
 * Function which displays all the notes that have been moved to the recycle bin
 *
 * @global moodle_database $DB
 * @global stdClass $USER
 */
function display_recyclebin(){
    global $DB, $USER;

    //Display all the notes that are sent to the recycle bin
    //'0' is false || '1' is true
    $recycle = $DB->get_records('notes', array('deleted' => 1, 'userid' => $USER->id));

    echo "<form id='check' method='post' action='view.php'>";

    check_all();
    echo"<br/><input type='submit' name='checkall' id='checkall' value='Select All' onclick='checkedAll();return false;'/>";

    check_button_clicked();
    echo "  <input type='submit' name='delete' id='delete' value='Delete' onclick=\"if( confirm(' ". get_string('delete_msg', 'local_mynotebook'). " ')){ return checkData(this.id);}\"/>";

    //Reloads parent window when you restore notes
    echo "  <input type='submit' name='restore' id='restore' value='Restore' onclick=\"if( confirm(' " . get_string('restore_msg', 'local_mynotebook'). " ')){ return checkData(this.id);}\"/>";

    $deleted_notes = $DB->get_records('notes', array('deleted' => 1, 'userid' => $USER->id));
    $count = $DB->count_records('notes', array('deleted' => 1, 'userid' => $USER->id));

    //Creates an unordered list to display all the notes that have been sent to the recycle bin
    for ($row = 1; $row < $count + 1; $row++) {
        $get = array_pop($deleted_notes);
        if (isset($get)) {
            $name = text_limit($get->name);

    echo    "<ul class='recycle'>";
    echo        "<li>";
    echo            "<div align='left' id='$get->id'>";
    echo                "<br/>";
    echo                "<input type='checkbox' name='checkbox[]' value='$get->id'/>";
    echo                "</br>";
    echo            "</div>";

    echo            "<a href='#' >";
    echo                "<h2>$name</h2>";
    echo                "<p>$get->text</p>";
    echo                "</a>";
    echo        "</li>";
    echo    "</ul>";
        }
    }
    echo "</br>";
    echo "</br>";
    echo "</br>";
echo "</form>";
}
?>