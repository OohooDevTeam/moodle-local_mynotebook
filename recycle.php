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

global $PAGE;

$system = get_context_instance(CONTEXT_SYSTEM);
$PAGE->set_context($system);
$PAGE->set_url('/local/mynotebook/recycle.php');

require_login();

//Checks which vaariable is set as requested by the user to either delete or restore specified notes
if (isset($_REQUEST['delete'])) {
    echo "Test del: ".$_REQUEST['delete']."<br>";
    echo"<script> console.log('DEL')
        alert('DELETE');
    </script>";
    delete_notes();
}

if (isset($_REQUEST['restore'])) {
    echo "Test res: ".$_REQUEST['restore']."<br>";
    echo"<script> console.log('RES')
        alert('RESTORE');
    </script>";
    restore_notes();
}

?>

