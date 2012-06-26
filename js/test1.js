//$(editor.getBody()).html()
//Grabs the html code

var editor;

//Controls the tinyMCE toolbar in the iFrame to show and hide
function initMCE() {
    setTimeout(function() {
        if(!tinyMCE.get('areaText')) {
            initMCE();
        } else {

            var editor = tinyMCE.get('areaText');

   //Make the height and width dynamic since they change when on blur and focus
            //When textarea is unactive
            $(editor.getBody()).blur(
            function() 
                {
                    $(editor.getContainer()).find(".mceToolbar, .mceStatusbar").hide()
                        var width = 500;
                        var height = 620;
                        editor.theme.resizeTo(width, height);
                        
                });
                
            //While the textarea is active    
            $(editor.getBody()).focus(
            function() 
                {
                    $(editor.getContainer()).find(".mceToolbar, .mceStatusbar").show()
                      var width = 500;
                        var height = 522;
                        editor.theme.resizeTo(width, height);
                        
                        editor.addShortcut('ctrl+s', 'saveFunction', save);
                });

            $(editor.getBody()).blur();

         //CSS for the lines to display
            $(editor.getBody()).css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',

                //'background': 'url(/moodle/local/mynotebook/images/theo.png)',
                'background': '-webkit-gradient(linear, 0 0, 0 100%, from(#65faff), color-stop(4%, #fff)) 0 4px',
                

                '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'

            }) 
            .css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',
                'background': '-webkit-linear-gradient(top, #65faff 0%, #fff 8%) 0 4px',
                        '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'
            })
                   .css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',
                'background': '-moz-linear-gradient(top, #65faff 0%, #fff 8%) 0 4px',
                        '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'
            })
                   .css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',
                'background': '-ms-linear-gradient(top, #65faff 0%, #fff 8%) 0 4px',
                        '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'
            })
                   .css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',
                'background': '-o-linear-gradient(top, #65faff 0%, #fff 8%) 0 4px',
                        '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'
            })
                             .css({
                'font': 'normal 12px/1.5 "Lucida Grande", arial, sans-serif',
                'color': '#444',
                'line-height': '20px',
                'background': 'linear-gradient(top, #65faff 0%, #fff 8%) 0 4px',
                        '-webkit-background-size': '100% 20px',
                '-moz-background-size': '100% 20px',
                '-ms-background-size': '100% 20px',
                '-o-background-size': '100% 20px',
                'background-size': '100% 20px',

                '-webkit-border-radius': '3px',
                '-moz-border-radius': '3px',
                'border-radius': '3px',

                '-webkit-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                '-moz-box-shadow': '0 1px 2px rgba(0,0,0,0.07)',
                'box-shadow': '0 1px 2px rgba(0,0,0,0.07)'
            })
            ;
        }
    }, 100);
}
        
        
//Save function object
var save = function() {
    //Initialized object
    var editor = tinyMCE.get('areaText');
    alert('Saved');
    //Posts information from the tinyMCE to save
    $.post('save_notes.php', {
        'text': $(editor.getBody()).html(),
        'courseid': $("#courseid").val(),
        'note_id': $("#note_id").val()
    });
    //alert($('#courseid').val());
}
        
//var save_title = function(){
//    alert('Title saved');
//    $_post('save_notes.php',{
//        'title': $("#title").val(),
//        'courseid': $("#courseid").val(),
//        'note_id': $("#note_id").val()
//    });
    
//}

function trim(s)
{
	var l=0; var r=s.length -1;
	while(l < s.length && s[l] == ' ')
	{	l++; }
	while(r > l && s[r] == ' ')
	{	r-=1;	}
	return s.substring(l, r+1);
}
    
function test(){
    $(document).on('blur',".title", function(){
        var iteratorz = $(this).parent().parent().find("#iterator").val();
        console.log('TITLE blur');
        console.log(iteratorz);
       
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
    initMCE();
    test();
    
    //Save shortcut
    $(document).bind('keydown', function(event) {
        if(event.ctrlKey && event.keyCode == 83) {
            save();
            //Stops form from submitting normally
            event.preventDefault();
            event.stopPropagation();
            return false;
        } 
    });
});

