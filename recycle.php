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

global $USER, $DB, $CFG, $PAGE;

$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/recycle.php');
////require_login($course, true, $cm);
require_login();

echo"<html><head>";

global $CFG, $USER, $DB;

echo'<link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css"> ';

echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/recycle.css'/>";
echo"<link rel='stylesheet' type='text/css' href='$CFG->wwwroot/local/mynotebook/css/form.css'/>";

echo"</head><body>";

    echo"<script> console.log('Started') </script>";
    
//Checks which vaariable is set as requested by the user to either delete or restore specified notes
if (isset($_REQUEST['delete'])) {
    echo "Test del: ".$_REQUEST['delete']."<br>";
    echo"<script> console.log('DEL') </script>";
    delete_notes();
}

if (isset($_REQUEST['restore'])) {
    echo "Test res: ".$_REQUEST['restore']."<br>";
    echo"<script> console.log('RES') </script>";
    restore_notes();
}

if (isset($_REQUEST['test'])) {
    echo "Test : ".$_REQUEST['test']."<br>";
    echo"<script> console.log('YES') </script>";
}

//echo "<h1><center>Recycle Bin</center></h1>";
//Display all the notes that are sent to the recycle bin
//'0' is false || '1' is true

$recycle = $DB->get_records('notes', array('deleted' => 1, 'userid' => $USER->id));
//echo "<body>";


echo "<form id='check' method='post' action='view.php'>";
//echo "<table class='deleted' id='table'>";
//echo "<thead>";
//echo "<tr>";
    check_all();
    echo"<br/><input type='submit' name='checkall' id='checkall' value='Select All' onclick='checkedAll();return false;'/>";

    check_button_clicked();

    echo "  <input type='submit' name='delete' id='delete' value='Delete' onClick='if( confirm(\"Permanently delete selected notes?\")){ return checkData(this.id);}'/>";

    //Reloads parent window when you restore notes
//    echo "  <input type='submit' name='restore' id='restore' value='Restore' onClick='if( confirm(\"Are you sure you want to restore these notes?\")){ opener.location.reload(); return checkData(this.id);}'/>";
    echo "  <input type='submit' name='restore' id='restore' value='Restore' onClick='if( confirm(\"Are you sure you want to restore these notes?\"))
                                                                                        {
                                                                                            function reloadParentPage() {
                                                                                                var selfUrl = unescape(parent.window.location.pathname);
                                                                                                parent.location.reload(true);
                                                                                                parent.window.location.replace(selfUrl);
                                                                                                parent.window.location.href = selfUrl;
                                                                                            } 
                                                                                        return checkData(this.id);}'/>";

    $deleted_notes = $DB->get_records('notes', array('deleted' => 1, 'userid' => $USER->id));
    $count = $DB->count_records('notes', array('deleted' => 1, 'userid' => $USER->id));

    //Creates an unordered list to display all the notes that have been sent to the recycle bin
    for ($row = 1; $row < $count + 1; $row++) {
        $get = array_pop($deleted_notes);
        if (isset($get)) {
            $name = text_limit($get->name);
            echo"<ul class='recycle'>";
                echo"<li>";
                    echo "<div align='left' id='$get->id'>";
                        echo "<br/>";
                        echo "<input type='checkbox' name='checkbox[]' value='$get->id'/>";
                        echo "</br>";
                    echo "</div>";
                    
                    echo"<a href='#' >"; 
                        echo"<h2>$name</h2>";
                        echo"<p>$get->text</p>";
                    echo"</a>";
                echo"</li>";
            echo"</ul>";
        }
    }
    echo "</br>";
    echo "</br>";
    echo "</br>";
echo "</form>";

echo"</body></html>";

?>

