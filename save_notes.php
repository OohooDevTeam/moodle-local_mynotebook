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

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

//Saves the note title
if (isset($_POST['title']) && isset($_POST['courseid1']) && isset($_POST['note_id1'])){
    //Grab the essential variables
    $title = $_POST['title'];
    $courseid1 = $_POST['courseid1'];
    $note_id1 = $_POST['note_id1'];

    $newtitle = $DB->get_record('notes', array('id'=>$note_id1, 'deleted'=>0, 'userid'=> $USER->id, 'courseid'=>$courseid1));
    //Assigns the new title
    $newtitle->name = $title;

    $update = $DB->update_record('notes', $newtitle);
}

//Saves the note
if (isset($_POST['text']) && isset($_POST['courseid']) && isset($_POST['note_id'])){
    //Grab the essential variables
    $text = $_POST['text'];
    $courseid = $_POST['courseid'];
    $note_id = $_POST['note_id'];

    $note = $DB->get_record('notes', array('id'=>$note_id, 'deleted'=>0, 'userid'=> $USER->id, 'courseid'=>$courseid));
    //Assigns the new content
    $note->text = $text;

    $update = $DB->update_record('notes', $note);
}
?>
