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

//Grabs the user input for the filename
$filename = $_POST['filename'];
echo $filename;
$filename = $filename . '.doc';

header("Content-type: application/vnd.ms-word");
//	header("Content-type: application/pdf");

header("Content-Disposition: attachment; Filename=$filename");


echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MyNotes</title>
</head>';

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

//Takes user input to export wither all note or specific course notes
$user_choice = optional_param('user_choice', NULL, PARAM_TEXT);

if ($user_choice == 'all_notes'){
    $notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));

} else if ($user_choice == 'course_notes'){
    $course_name = $_POST['course_name'];

    $course_id = $DB->get_record('course', array('fullname'=>$course_name));

    $notes = $DB->get_records('notes', array('userid'=>$USER->id, 'deleted'=>0, 'courseid'=>$course_id->id));

}

echo'<body>';

$note_name = array();
$note_content = array();
$courseid = array();
$course_name = array();
$date_created = array();

//Retrieve all the necessary information about each note to be displayed
foreach ($notes as $note) {

    echo "**********************************************************************";
    echo "**********************************************************************";
    echo "**********************************************************************";

    $note_name[] = $note->name;
    $note_content[] = strip_tags($note->text);
    $coursenames = $DB->get_records('course', array('id' => $note->courseid));
    $courseid[] = $note->courseid;
    $date_created[] = $note->time_modified;

    foreach ($coursenames as $coursename) {
        $course_name[] = $coursename->fullname;
    }


//Creates a table to display each note
echo"<div align=center>
<table class='MsoNormalTable' border='1' cellspacing='0' cellpadding='0' width='652' style='width:488.85pt;border-collapse:collapse;border:none'>
    <tbody>
        <tr style='height:51.0pt'>
            <td width='125' style='width:93.45pt;border:solid windowtext 1.0pt;background:
            silver;padding:0in 5.75pt 0in 5.75pt;height:51.0pt'>
                <p class='MsoNormal' align='center' style='text-align:center'><b><span lang='FR' style='font-size:16.0pt;line-height:115%'>$note->name</span></b></p>
            </td>
            <td width='527' style='width:395.4pt;border:solid windowtext 1.0pt;border-left:
            none;background:silver;padding:0in 5.75pt 0in 5.75pt;height:51.0pt'>
                <p class='MsoNormal' align='center' style='text-align:center'><b><span lang='FR' style='font-size:16.0pt;line-height:115%'>Content</span></b></p>
            </td>
        </tr>
        <tr style='height:559.4pt'>
            <td width='125' valign='top' style='width:93.45pt;border:solid windowtext 1.0pt;
            border-top:none;padding:0in 5.75pt 0in 5.75pt;height:559.4pt'>
                <p class='MsoNormal' align='center' style='text-align:center'><span lang='FR'>&nbsp;</span></p>
                <p class='MsoNormal' align='center' style='text-align:center'><span lang='FR'>&nbsp;</span></p>
                <p class='MsoNormal' align='center' style='text-align:center'><span lang='FR'>&nbsp;</span></p>
                <p class='MsoNormal' align='center' style='text-align:center'><span lang='FR'>$note->name</span></p>
            </td>
            <td width='527' valign='top' style='width:395.4pt;border-top:none;border-left:
            none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
            padding:0in 5.75pt 0in 5.75pt;height:559.4pt'>
            <p class='MsoNormal'><span lang='FR'>$note->text</span></p>
            </td>
        </tr>
    </tbody>
</table></div>";

}//end foreach

?>