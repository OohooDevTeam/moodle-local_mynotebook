$(window).ready(function() {
    $('#notebook').turn({
        display: 'double',
        acceleration: true,
        //        gradients: !$.isTouch,
        elevation:100,
        when: {
            turned: function(e, page) {

            $('#page-number').val(page);
//            console.log($('#page-number').val(page));
//            console.log($('#page-number').turn('page'));
            //Determines the number of pages in the book - each note is a page
            var numberOfPages = $(this).turn('pages'); 
            $('#number-pages').html(numberOfPages);
            }
        }
    });
});

function turn2page(pagenum){
        $('#notebook').turn('page', pagenum);
}

function bookmarkpage(){
        $('#notebook').turn('page');
        console.log($('#notebook').turn('page'));
        alert($('#notebook').turn('page'));
}

//function grabpage(){
//    
//    $('#notebook').turn('page');
//    console.log($('#notebook').turn('page'));
//    alert($('#notebook').turn('page'));
//
//    $('#notebook').turn('pages');
//    console.log($('#notebook').turn('pages'));
//    alert($('#notebook').turn('pages'));
//}


//Binds the arrow keys for page turning
//arrowleft:37; arrowright:39
//numpadleft:100; numpadright:102

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

//Shorthand for DOMReady
//When user enters a page to go to in the search box
$(function(){
    $("#page-number").keypress(function(event) {
        if ( event.which == 13 ) {
            event.preventDefault();              
            page = $("#page-number").val();  
            $('#notebook').turn('page', page);
        }
    });    
});


