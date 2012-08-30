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

//Initializes page flipping
$(window).ready(function() {
    $('#notebook').turn({
        display: 'double',
        acceleration: true,
        elevation:100,
        when: {
            turned: function(e, page) {

            $('#page-number').val(page);

            //Determines the number of pages in the book - each note is a page
            var numberOfPages = $(this).turn('pages');
            $('#number-pages').html(numberOfPages);

//Testing to show for page numbers
//           var page = $('#notebook').turn('page');
            $('#pagefooter').val(page);
            }
        }
    });
});

/**
 * Function turns to the desired page
 *
 * @param int pagenum This number is the desired page to turn to
 */
function turn2page(pagenum){
        $('#notebook').turn('page', pagenum);
}

function bookmarkpage(){
        $('#notebook').turn('page');
}

$(window).bind('keydown', function(e){

    if (e.keyCode==37){
        $('#notebook').turn('previous');
    }
    else if (e.keyCode==39){
        $('#notebook').turn('next');
    }

//    http://www.coderanch.com/t/479386/HTML-CSS-JavaScript/Capturing-window-keycode-not-working
    var evt = e || window.event;
    if(evt.keyCode == 116){
    }
});


/**
 * When user enters a page to go to in the search box
 * Shorthand for DOMReady
 */
$(function(){
    $("#page-number").keypress(function(event) {
        if ( event.which == 13 ) {
            //Prevents the default functionality of the 'enter' key
            event.preventDefault();
            page = $("#page-number").val();
            $('#notebook').turn('page', page);
        }
    });
});

//$(function(){
//                var numberOfPages = $(this).turn('pages');
//                          $('#pagefooter').html(numberOfPages);
//                          var page =         $('#notebook').turn('page');
//
//            $('#pagefooter').val(page);
//
//                     console.log('TeST');
//});

