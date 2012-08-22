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

//Controls the merge window //new one
$(document).ready(function(){
    $(function() {
        $( "#merge" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            show: function() {
                var $this = $(this);
                $this
                .dialog("widget")
                .effect("transfer", {
                    to: "#merge",
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
                    to: "#merge",
                    className: "ui-effects-transfer"
                }, 500, function() {
                    $this.remove();
                });
            }
//            buttons: { "Ok" :
//                function() { $(this).dialog("close"); } }
            //When user closes the dialog, page refreshes
            }).parent().find(".ui-dialog-titlebar-close").click(
                function() {
//                    alert("Closed by title bar X, clear the other form here");
                    location.reload();
                });

        $( ".merge" ).click(function() {
            $('#bookmark').dialog('close');
            $('#settings').dialog('close');
            $( "#merge" ).dialog( "open" );
            return false;
        });
    });
});

$(document).ready(function(){
    $(function() {
        $( "#recyclebin" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            width:"550px",
            height:"auto",
            position:"center",

            show: function() {
                var $this = $(this);
                $this
                .dialog("widget")
                .effect("transfer", {
                    to: "#recyclebin",
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
                    to: "#recyclebin",
                    className: "ui-effects-transfer"
                }, 500, function() {
                    $this.remove();
                });
            }

        });

        $( ".recyclebin" ).click(function() {
            $('#bookmark').dialog('close');
            $('#settings').dialog('close');
            $( "#recyclebin" ).dialog( "open" );
            return false;
        });
    });
});
