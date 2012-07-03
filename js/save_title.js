//Saves the title of each note when user chagnes it
function save_title(){
    $(document).on('blur',".title", function(){
        var iteratorz = $(this).parent().parent().find("#iterator").val();
//        console.log('TITLE blur');
//        console.log(iteratorz);
       
        var temp_course = "#courseid";
        var temp_note = "#note_id";
        
        var trimmed_iterator = iteratorz.trim();
        
        var courseid = temp_course + trimmed_iterator;
        var noteid = temp_note + trimmed_iterator;
        
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