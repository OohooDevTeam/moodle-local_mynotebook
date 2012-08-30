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
global $CFG, $DB, $USER, $PAGE;
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/lib/editor/tinymce/lib.php');

//require_once($CFG->dirroot . '/lib/editor/tinymce/lib.php');

$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/notepage.php');
require_login();

$PAGE->set_pagelayout('popup');
//$PAGE->set_pagelayout('embedded');

$PAGE->requires->js(new moodle_url('/local/mynotebook/js/jquery-1.7.2.js'));
$PAGE->requires->js(new moodle_url('/local/mynotebook/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'));
$PAGE->requires->js(new moodle_url('/local/mynotebook/js/save_notes.js'));

//This is what causes the errors to appear in IE9
//Works when viewing in compatibility mode
echo $OUTPUT->header();
//
//Temp fix for IE9, but tinyMCE breaks
//echo'
//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
//<html xmlns="http://www.w3.org/1999/xhtml">
//<head>
//<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
//    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
//    <script type="text/javascript" src="js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js"></script>
//    <script type="text/javascript" src="js/save_notes.js"></script>
//</head><body>';

//echo"<html><head>";
//    echo'<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">';
//    echo"<script type='text/javascript' src='js/jquery-1.7.2.js'></script>";
//    echo"<script type='text/javascript' src='js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js'></script>";
//        echo"<script type='text/javascript' src='../../lib/editor/tinymce/lib.php'></script>";
//    echo"<script type='text/javascript' src='js/save_notes.js'></script>";
//echo"</head><body>";

if ($_REQUEST['courseid'] && $_REQUEST['note_id']){
    $courseid = $_REQUEST['courseid'];
    $note_id = $_REQUEST['note_id'];

    $course = $DB->get_record('course', array('id' => $courseid));

    //Grabs the note name and content
    $trim = $DB->get_record('notes', array('userid'=>$USER->id, 'courseid'=>$courseid, 'id'=>$note_id));
    $note_name = $trim->name;
    //Creates a textarea initialized with the notes name and
    $text = $trim->text;
    //Creates a textarea initialized with the notes name and content
    echo "<textarea id='areaText'>
        \n
        $text
    </textarea>";

    //Stores the notes id and courseid in hidden fields for access
    echo "<input id='courseid' type='hidden' value=' $courseid '/>";
    echo "<input id='note_id' type='hidden' value=' $note_id '/>";

    //Applies tinyMCE to targetted text area
    $editor = new tinymce_texteditor();
    $editor->use_editor('areaText', null, null);

} else {
    print_error("Course id or Note id was not found");
}
echo $OUTPUT->footer();
//echo"</body></html>";









/************ORIGINAL CODE***********************************>>>*/
/************ORIGINAL CODE***********************************/
/************ORIGINAL CODE***********************************/
/*
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->dirroot . '/lib/editor/tinymce/lib.php');

global $CFG, $DB, $USER, $PAGE;

$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/notepage.php');

require_login();

$PAGE->set_pagelayout('popup');

$PAGE->requires->js('/local/mynotebook/js/jquery-1.7.2.js', true);
$PAGE->requires->js('/local/mynotebook/js/jquery-ui-1.8.18.custom/js/jquery-ui-1.8.18.custom.min.js', true);
$PAGE->requires->js('/local/mynotebook/js/save_notes.js', true);

//This is what causes the errors to appear in IE9
echo $OUTPUT->header();

if ($_REQUEST['courseid'] && $_REQUEST['note_id']){
    $courseid = $_REQUEST['courseid'];
    $note_id = $_REQUEST['note_id'];

    $course = $DB->get_record('course', array('id' => $courseid));

    //Grabs the note name and content
    $trim = $DB->get_record('notes', array('userid'=>$USER->id, 'courseid'=>$courseid, 'id'=>$note_id));
    $note_name = $trim->name;
    //Creates a textarea initialized with the notes name and
    $text = $trim->text;
    //Creates a textarea initialized with the notes name and content
    echo "<textarea id='areaText'>
        \n
        $text
    </textarea>";

    //Stores the notes id and courseid in hidden fields for access
    echo "<input id='courseid' type='hidden' value=' $courseid '/>";
    echo "<input id='note_id' type='hidden' value=' $note_id '/>";

    //Applies tinyMCE to targetted text area
    $editor = new tinymce_texteditor();
    $editor->use_editor('areaText', null, null);

} else {
    print_error("Course id or Note id was not found");
}
echo $OUTPUT->footer();
 * */
?>