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
global $DB, $USER;

//$system = get_context_instance(CONTEXT_SYSTEM);
//$PAGE->set_context($system);
//$PAGE->set_url('/local/mynotebook/mergenotes.php');

require_login();

echo"<html><head>";

echo"</head><body>";

//    print_object($_REQUEST);
    $source = $_POST["source"];
    $destination = $_POST["destination"];

    echo 'source' . $source . '</br>';
    echo 'destination' . $destination . '</br>';

    //Cannot have the same source and destination. Probability of basically deleting the note itself
    if ($source == $destination){
        echo "<script type=text/javascript>";
        echo "alert('Can not have the same source and destination.')";
        echo "</script>";
    } else {

        //Get the source and destination of the notes being merged
        $source_note = $DB->get_record('notes', array('userid'=>$USER->id, 'name'=>$source, 'deleted'=>0));
        $destination_note = $DB->get_record('notes', array('userid'=>$USER->id, 'name'=>$destination, 'deleted'=>0));

        echo $source_note->text;
        echo "</br></br>";
        echo $destination_note->text;

        //update record
        $merged_content = $destination_note->text . $source_note->text;
        echo $merged_content;
    //    exit();
        $destination_note->text = $merged_content;
        $DB->update_record('notes', $destination_note);

        //delete old record
        $delete_note = $DB->delete_records('notes', array('userid'=>$USER->id, 'name'=>$source, 'deleted'=>0));

        //Alerts user note merging is completed
        echo "<script type=text/javascript>";
        echo "alert('Merging Completed')";
        echo "</script>";
    }
echo"</body></html>";
?>
