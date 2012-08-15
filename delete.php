<?php

//might not need this file
//Outdated file, delete

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');

global $USER, $DB, $SESSION, $CFG, $PAGE;

if (isset($_REQUEST['p'])){
   $p = @$_REQUEST['p'];
}

$list = list($sub_id, $row, $col) = explode('_', $p);

//print_object($list);

$noteid = $list[0];

//Assigns selected notes the number 1, meaning deleted
//For notes on the table
if ($DB->record_exists('gallerytable', array('noteid'=>$noteid, 'userid'=> $USER->id))){
    $gallery_recycled_note = $DB->get_record('gallerytable', array('noteid'=>$noteid, 'userid'=> $USER->id));
    $gallery_recycled_note->deleted = 1;
    $updated_gallery = $DB->update_record('gallerytable', $gallery_recycled_note);

    $notes_recycled_note = $DB->get_record('notes', array('id'=>$noteid, 'userid'=> $USER->id));
    $notes_recycled_note->deleted = 1;
    $updated_notes = $DB->update_record('notes', $notes_recycled_note);

//For notes under the "New Notes" heading
} else {

    $notes_recycled_note = $DB->get_record('notes', array('id'=>$noteid, 'userid'=> $USER->id));
    $notes_recycled_note->deleted = 1;
    $updated_notes = $DB->update_record('notes', $notes_recycled_note);

}

?>