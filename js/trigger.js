//Loads the notebook into a div
//$.fx.speeds._default = 1000;
//$(function() {
////    $( "#dialog" ).dialog({
////        autoOpen: false,
////        resizable: false,
////        //hide: "explode"
////        show: "explode",
////        hide: "explode"
////    });
//    
//    $('#my_loading_div').dialog({
//        'width' : 'auto',
//        'height' : 'auto',
////        'modal' : true,
//        'position' : 'center',
//        'autoOpen' : false
//    });
//});
var handle;

//controls the notebook popup
$(document).ready(function(){
      $(document).on('click', '.ajaxtrigger',function(){
//    $('.ajaxtrigger').live('click',function(){
        $('#target').dialog('close');
        $(document).unbind("mousemove");
        $(document).unbind("mouseup");
        clearInterval(handle);
        
        //Grabs the course name and puts it into the header
        var heading = 'MyNotebook - ' + $(this).attr('coursename');

        //        var array = $.parseJSON($(this).attr('array'));
        //        for (i = 0; i < array.length; i++) {
        //            console.log(array[i]);
        //        }

        //Loads the page url and then opens it up in a popup window
        $('#target').load(this.href, function() {
            setTimeout(function(){
                $( '#target' ).dialog({
                    resizable: false,
                    modal:false,
                    title: heading,
                    show: "explode",
                    hide: "explode",
                    width:"auto",
                    height:"auto",
                    position:"center",
                    draggable: true
                });
                return false;
            }, 50);
        });
        return false;
    });
    //Closes the dialog when 'esc' key is pressed
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('#target').dialog('close');
        }
    });
//    $(document).bind("mousemove");
//        $(document).bind("mouseup");
});

//controls the export popup
$(document).ready(function(){
    $(function() {
        $( "#export" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            show: function() {     
                var $this = $(this);    
                $this
                .dialog("widget")
                .effect("transfer", {      
                    to: "#export", 
                    className: "ui-effects-transfer"  
                }, 500, function() {         
                    $this.remove(); 
                });
            },
            hide: function() { 
                var $this = $(this);
                $this
                .dialog("widget")
                .effect("transfer", {
                    to: "#export", 
                    className: "ui-effects-transfer"
                }, 500, function() {
                    $this.remove(); 
                });
            }
                        
        });

        $( ".export" ).click(function() {
            $('#bookmark').dialog('close');
            $('#settings').dialog('close');
            $( "#export" ).dialog( "open" );
            return false;
        });
    });
});

//controls the merge popup
$(document).ready(function(){
    $(document).on('click', '.merge', function(){
//    $('.merge').live('click',function(){
        $('#merge').dialog('destroy');
        //Loads the page url and then opens it up in a popup window
        $('#merge').load($(this).attr('href'), function() {
            setTimeout(function(){
                $( "#merge" ).dialog({
                    resizable: true,
                    modal:false,
                    show: "explode",
                    hide: "explode",
                    //IE does not like the auto width
                    width:"auto",
                    height:"auto",
                    position:"center"
                });
                return false;
            }, 50);
        });
        return false;
    });
    //Closes the dialog when 'esc' key is pressed
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('#merge').dialog('close');
        }
    });
});

//controls the bookmark popup
$(document).ready(function(){
    $(function() {
        $( "#bookmark" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            show: function() {     
                var $this = $(this);    
                $this
                .dialog("widget")
                .effect("transfer", {      
                    to: "#bookmark", 
                    className: "ui-effects-transfer"  
                }, 500, function() {         
                    $this.remove(); 
                });
            },
            hide: function() { 
                var $this = $(this);
                $this
                .dialog("widget")
                .effect("transfer", {
                    to: "#bookmark", 
                    className: "ui-effects-transfer"
                }, 500, function() {
                    $this.remove(); 
                });
            }
                        
        });

        $( ".bookmark" ).click(function() {
            $('#export').dialog('close');
            $('#settings').dialog('close');
            $( "#bookmark" ).dialog( "open" );
            return false;
        });
    });
});

//controls the settings popup
$(document).ready(function(){
    $(function() {
        $( "#settings" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            show: function() {     
                var $this = $(this);    
                $this
                .dialog("widget")
                .effect("transfer", {      
                    to: "#settings", 
                    className: "ui-effects-transfer"  
                }, 500, function() {         
                    $this.remove(); 
                });
            },
            hide: function() { 
                var $this = $(this);
                $this
                .dialog("widget")
                .effect("transfer", {
                    to: "#settings", 
                    className: "ui-effects-transfer"
                }, 500, function() {
                    $this.remove(); 
                });
            }
                        
        });

        $( ".settings" ).click(function() {
            $('#export').dialog('close');
            $('#bookmark').dialog('close');
            $( "#settings" ).dialog( "open" );
            return false;
        });
    });
});

//controls the notebook popup
$(document).ready(function(){
      $(document).on('click', '.recyclebin', function(){
//    $('.recyclebin').live('click',function(){
        $('#recyclebin').dialog('destroy');
        
        //        $('#my_loading_div').dialog('open');
        
        //Grabs the course name and puts it into the header
        //        var heading = 'MyNotebook - ' + $(this).attr('coursename');

        //        var array = $.parseJSON($(this).attr('array'));
        //        for (i = 0; i < array.length; i++) {
        //            console.log(array[i]);
        //        }

        //Loads the page url and then opens it up in a popup window
        $('#recyclebin').load($(this).attr('href'), function() {
            setTimeout(function(){
                $( "#recyclebin" ).dialog({
                    resizable: true,
                    modal:false,
                    show: "explode",
                    hide: "explode",
                    width:"550px",
                    height:"auto",
                    position:"center"
                });
                return false;
            }, 50);
        });
        return false;
    });
    //Closes the dialog when 'esc' key is pressed
    $(document).keyup(function(e) {
        if (e.keyCode == 27) {
            $('#recyclebin').dialog('close');
        }
    });
});

////Loads the notebook into a div
//$.fx.speeds._default = 1000;
//$(document).ready(function(){
//    
//    $( "#target" ).dialog({
//        'autoOpen': false,
//        resizable: true,
//        show: "explode",
//        hide: "explode",
//        width: "auto",
//        height: "auto",
//        title: "MyNoteBook"
//                                        
//    });
//    
//    console.log("Target Loaded");
//    
//    $('.ajaxtrigger').click(function(){
//        $("#target").dialog("close");
//
//        //        var url = $(this).attr('href');
//        //    $('#target').load('view.php');
//        //    
//        //        var url = this.href;
//        //Splits the url and then checks for encoded spaces
//        //        var split = url.split("=");
//        //        if(split[2].search("%20")!=-1){
//        //            var name = split[2].split("%20");
//        //            alert(sizeof(name));
//        //            for(var i=0; i<sizeof(name);i++){
//        //                
//        //            }
//        //        }
//
//        //Loads the page url and then opens it up in a popup window
//        $("#target").load(this.href, function() {
//            $("#target").dialog("open");
//
//            return false;
//        });
//        return false;
//    });
//});




//Jquery dialog popup for the export button
// increase the default animation speed to exaggerate the effect
//$.fx.speeds._default = 1000;
//$(function() {
//    $( "#dialog" ).dialog({
//        autoOpen: false,
//        resizable: false,
//        //hide: "explode"
//        show: function() {     
//            var $this = $(this);    
//            $this
//            .dialog("widget")
//            .effect("transfer", {      
//                to: "#opener", 
//                className: "ui-effects-transfer"  
//            }, 500, function() {         
//                $this.remove(); 
//            });
//        },
//        hide: function() { 
//            var $this = $(this);
//            $this
//            .dialog("widget")
//            .effect("transfer", {
//                to: "#opener", 
//                className: "ui-effects-transfer"
//            }, 500, function() {
//                $this.remove(); 
//            });
//        }
//    });
//
//
//    $( "#opener" ).click(function() {
//        $( "#dialog" ).dialog( "open" );
//        return false;
//    });
//});