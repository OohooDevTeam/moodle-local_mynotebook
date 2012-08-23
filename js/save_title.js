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

/**
 * Saves the title of each note when user changes it. Used in the function
 * hidden_note_title_values()
 */
function save_title(){
    $(document).on('blur',".title", function(){
        //Grabs the value of the input field
        var iteratorz = $(this).parent().parent().find("#iterator").val();

        var temp_course = "#courseid";
        var temp_note = "#note_id";

        var trimmed_iterator = $.trim(iteratorz);

        var courseid = temp_course + trimmed_iterator;
        var noteid = temp_note + trimmed_iterator;

        //Passes these variables to save the notes with
        $.post('save_notes.php',{
            'title': $(this).val(),
            'courseid1': $(courseid).val(),
            'note_id1': $(noteid).val()
        });
    });
}

$(document).ready(function(){
    save_title();
});