<?php

header("Content-type: application/vnd.ms-word");
//	header("Content-type: application/pdf");

header("Content-Disposition: attachment; Filename=SaveAsWordDoc.doc");

echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Saves as a Word Doc</title>
</head>
    ';


echo'
<body>';



require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

$notes = $DB->get_records('notes', array('userid' => $USER->id, 'deleted' => 0));
$note_name = array();
$note_content = array();
$courseid = array();
$course_name = array();
$date_created = array();

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
    
    
//Table for representing each note in Word
echo"
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
                <p class='MsoNormal' align='center' style='text-align:center'><span lang='FR'>$note->courseid</span></p>
            </td>
            <td width='527' valign='top' style='width:395.4pt;border-top:none;border-left:
            none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
            padding:0in 5.75pt 0in 5.75pt;height:559.4pt'>
            <p class='MsoNormal'><span lang='FR'>$note->text</span></p>
            </td>
        </tr>
    </tbody>
</table>";

}


?>