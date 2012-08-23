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

var handle;

/**
 * Opens up the notebook dialog when user clicks it
 */
$(document).ready(function(){
      $(document).on('click', '.ajaxtrigger',function(){
        $('#target').dialog('close');
        $(document).unbind("mousemove");
        $(document).unbind("mouseup");
        clearInterval(handle);

        //Grabs the course name and puts it into the header
        var heading = 'MyNotebook - ' + $(this).attr('coursename');

        //Loads the page url and then opens it up in a popup window
        //Specifies the options for the dialog
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
});

/**
 * Opens the export popup menu
 */
$(document).ready(function(){
    $(function() {
        //Specifies the options for the dialog
        $( "#export" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            //Specifies the options for the dialog on show
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
            //Specifies the options for the dialog on hide
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
            $( "#export" ).dialog( "open" );
            return false;
        });
    });
});

/**
 * Opens the merge window
 */
$(document).ready(function(){
    $(function() {
        //Specifies the options for the dialog
        $( "#merge" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            //Specifies the options for the dialog on show
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
            //Specifies the options for the dialog on hide
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
            //When user closes the dialog, page refreshes
            }).parent().find(".ui-dialog-titlebar-close").click(
                function() {
                    location.reload();
                });

        $( ".merge" ).click(function() {
            $( "#merge" ).dialog( "open" );
            return false;
        });
    });
});

/**
 * Opens up the recycle bin
 */
$(document).ready(function(){
    $(function() {
        //Specifies the options for the dialog
        $( "#recyclebin" ).dialog({
            autoOpen: false,
            modal:false,
            resizable: false,
            width:"550px",
            height:"auto",
            position:"center",
            //Specifies the options for the dialog on show
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
            //Specifies the options for the dialog on hide
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
            $( "#recyclebin" ).dialog( "open" );
            return false;
        });
    });
});