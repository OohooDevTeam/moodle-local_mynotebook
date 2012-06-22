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

////echo"<script>console.log('NOT WORKED');</script>";
//echo"<script>console.log($title);</script>";

//Saves the note title
if (isset($_POST['title']) && isset($_POST['courseid1']) && isset($_POST['note_id1'])){
    $title = $_POST['title'];
    $courseid1 = $_POST['courseid1'];
    $note_id1 = $_POST['note_id1'];
    
    echo $title . '</br>';
    echo $courseid1 . '</br>';
    echo $note_id1 . '</br>';
//    $newtitle = $DB->get_record('notes', array('id'=>$note_id, 'deleted'=>0, 'userid'=> $USER->id, 'courseid'=>$courseid));
//    $newtitle->name = $title;
//    
//    $update = $DB->update_record('notes', $newtitle); 
    
}

//Saves the note
if (isset($_POST['text']) && isset($_POST['courseid']) && isset($_POST['note_id'])){  
    $text = $_POST['text'];
    $courseid = $_POST['courseid'];
    $note_id = $_POST['note_id'];
    
    
//    $note = $DB->get_record('notes', array('id'=>$note_id, 'deleted'=>0, 'userid'=> $USER->id, 'courseid'=>$courseid));
//    $note->text = $text;
//      
//    $update = $DB->update_record('notes', $note);  
    
} else {
    ECHO"!SET";
    
}

?>
