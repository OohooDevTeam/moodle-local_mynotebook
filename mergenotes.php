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
require_once(dirname(__FILE__) . '/locallib.php');
global $DB, $USER;

require_login();

echo"<html><head>";
echo"</head><body>";

    $source = $_POST["source"];
    $destination = $_POST["destination"];

    //Cannot have the same source and destination. Probability of it deleting the note itself
    if ($source == $destination){
        echo "<script type=text/javascript>";
        echo    "alert('Source and destination must be different.')";
        echo "</script>";

    } else {

        //Get the source and destination of the notes being merged
        $source_note = $DB->get_record('notes', array('userid'=>$USER->id, 'name'=>$source, 'deleted'=>0));
        $destination_note = $DB->get_record('notes', array('userid'=>$USER->id, 'name'=>$destination, 'deleted'=>0));

        //Append the source content to the destination content
        $merged_content = $destination_note->text . $source_note->text;

        //Assign the new merged content to the destination text field
        $destination_note->text = $merged_content;

        //Update the record with new merged contents
        $DB->update_record('notes', $destination_note);

        //Delete old record
        $DB->delete_records('notes', array('userid'=>$USER->id, 'name'=>$source, 'deleted'=>0));

        //Alerts user note merging is completed
        echo "<script type=text/javascript>";
        echo    "var index = $('select#merge_left').get(0).selectedIndex;";
        echo    "$('select#merge_left option:eq(' + index + ')').remove();";
        echo    "alert('Merging Completed')";
        echo "</script>";
    }

echo"</body></html>";
?>
