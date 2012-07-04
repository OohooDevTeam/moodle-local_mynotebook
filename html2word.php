<?php

header("Content-type: application/vnd.ms-word");
//	header("Content-type: application/pdf");

header("Content-Disposition: attachment; Filename=SaveAsWordDoc.doc");

echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

    echo $note->text;
    echo "**********************************************************************";
    $note_name[] = $note->name;
    $note_content[] = strip_tags($note->text);
    $coursenames = $DB->get_records('course', array('id' => $note->courseid));
    $courseid[] = $note->courseid;
    $date_created[] = $note->time_modified;

    foreach ($coursenames as $coursename) {
        $course_name[] = $coursename->fullname;
    }
}





echo'
<h1>Header</h1>
  This text can be seen in word
<ul>
<li><span style="background-color: red; color: yellow;"> List 1</span></li>
<li>List 2</li>
</ul>
  
  <p>WORD</p>
<p>WORD</p>
<p class="MsoNormal">Fgdsgdgdfg</p>
<p class="MsoNormal"><span style="color: red;">Hdrjyjydtjdtj</span></p>
<p class="MsoNormal" style="text-align: center;" align="center"><span style="color: red;">Gerggeargregreggregergegergege</span></p>
<p class="MsoNormal" style="text-align: right;" align="right"><span style="color: &lt;br /&gt;red;">Gregreagrege</span></p>
<p class="MsoNormal"><span style="text-decoration: underline;"><span style="color: red;">Herhehehhrehre</span></span></p>
<p class="MsoNormal"><span style="text-decoration: underline;"><span style="color: red;">Hehre</span></span><strong><span style="color: red;">hrehrehe</span></strong></p>
<p class="MsoNormal"><strong><em><span style="color: red;">Herhreherhe</span></em></strong><em></em></p>
<p class="MsoNormal"><em><span style="color: red;">hrehreh</span></em></p>
<p>;</p>
<p>;</p>
<table border="1">
<tbody>
<tr>
<td>gdgdgdg</td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td> </td>
<td> </td>
<td> </td>
<td>dgdfgfffg</td>
</tr>
</tbody>
</table>
  
</body>
</html>
';
?>