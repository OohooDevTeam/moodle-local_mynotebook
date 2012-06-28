   //<!--        <script>$('#notebook').turn();</script>-->

//	setTimeout(function(){
//		// Leave some time for the plugin to
//		// initialize, then show the magazine
//		$('#notebook').fadeTo(500,1);
//	},1000);

//For the notebook flipping
/************************************************************************************/
//$('#notebook').turn({pages: 1000});
//	var numberOfPages = $(this).turn('pages'); 
//
//$('#number-pages').html(numberOfPages);

$(window).ready(function() {
    $('#notebook').turn({
        display: 'double',
        acceleration: true,
        //        gradients: !$.isTouch,
        elevation:100,
        when: {
            turned: function(e, page) {
//                console.log('Current view: ', $(this).turn('view'));
                
//                 console.log('Current view: ', $(this).turn('pages'));
//                     console.log('Current view: ', $(this).turn('page'));
//                var range = $(this).turn('range', page);
//                console.log('Range: ', range);
//                alert($(this).turn('view'));
//                alert(page);
//$('#notebook').bind('turned', function() { alert($(this).turn('view'));});

       $('#page-number').val(page);
                  
            //Determines the number of pages in the book - each note is a page
            var numberOfPages = $(this).turn('pages'); 
            $('#number-pages').html(numberOfPages);
            }
        }
    });
});

//Binds the arrow keys for page turning
//arrowleft:37; arrowright:39
//numpadleft:100; numpadright:102

$(window).bind('keydown', function(e){

    if (e.keyCode==37)
        $('#notebook').turn('previous');
    else if (e.keyCode==39)
        $('#notebook').turn('next');

});

//$('#next').click(function(e) {
//			
//			
//    $('#magazine').turn('next');
//    return false;
//
//});
//
//$('#previous').click(function(e) {
//			
//    e.stopPropagation();
//
//    $('#magazine').turn('previous');
//    return false;
//
//});
/************************************************************************************/






//$(document).ready(function(){
//    $('.menu_button').live('click',function(){
//        $('#menu_options').dialog('destroy');
//        
////        $('#my_loading_div').dialog('open');
//        
//        //Grabs the course name and puts it into the header
////        var heading = 'MyNotebook - ' + $(this).attr('coursename');
//
//        //Loads the page url and then opens it up in a popup window
//        $('#menu_options').load(this.href, function() {
//            setTimeout(function(){
////                $('#my_loading_div').dialog('close');
//                $( "#menu_options" ).dialog({
//                    resizable: true,
//    //               modal:true disables the textarea
//                    modal:true,
//                    title: 'MENU',
//                    //hide: "explode"
//                    show: "explode",
//                    hide: "explode",
//                    width:"auto",
//                    height:"auto",
//                    position:"center"
//
//                });
////                $( "#target" ).dialog('open');
//                return false;
//            }, 50);
//        });
//        return false;
//    });
//});













//text editor for each notepage
//tinyMCE.init({
//    // General options
//    //mode : "textareas",
//    mode : "exact",
//    elements: "area1",
//    theme : "advanced",
//    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
//
//    // Theme options
//    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
//    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
//    theme_advanced_toolbar_location : "external",
//    theme_advanced_toolbar_align : "left",
//    theme_advanced_statusbar_location : "bottom",
//    theme_advanced_resizing : true
//});



//book rotating selection
//$(document).ready(function(){
//		
//    $("#da-vinci-carousel").CloudCarousel( { 
//        reflHeight: 56,
//        reflGap:2,
//        titleBox: $('#da-vinci-title'),
//        altBox: $('#da-vinci-alt'),
//        buttonLeft: $('#but1'),
//        buttonRight: $('#but2'),
//        yRadius:40,
//        xPos: 285,
//        yPos: 120,
//        speed:0.15,
//        mouseWheel:true,
//        bringToFront: true
//    //                autoRotate:'right'
//    });
//	
////extra
////	$("#carousel2").CloudCarousel({			
////		xPos:280,
////		yPos:80,
////		buttonLeft: $('#but3'),
////		buttonRight: $('#but4'),				
////		FPS:30,
////		autoRotate: 'left',
////		autoRotateDelay: 1200,
////		speed:0.2,
////		mouseWheel:true,
////		bringToFront:true
////	});	
//		
//});


/*******************************************************************************/
/*******************************************************************************/
/*******************************************************************************/

window.pages = ['home', 'usage', 'usage', 'get', 'get', 'reference', 'reference', 'credits'];


	function getURL() {
		
		return window.location.href.split('#').shift();

	}

	function getHash() {
		
		return window.location.hash.slice(1);

	}

	function setControllPos() {

		var view = $('#magazine').turn('view');

		if (view[0]) $('#previous').addClass('visible');
		else $('#previous').removeClass('visible');

		if (view[1]) $('#next').addClass('visible');
		else $('#next').removeClass('visible');

	}

	function checkHash(hash) {

		var hash = getHash(), k;

		if ((k=jQuery.inArray(hash, pages))!=-1) {
			$('nav').children().each(function(index, value) { 
				if ($(value).attr('href').indexOf(hash)!=-1) 
					$(value).addClass('on');
				else 
					$(value).removeClass('on');
			});
			return k+1;
		}
		
		return 1;
	}


	function rotated() {
		
		return Math.abs(window.orientation)==90;
	
	}

	function isPhone() {
		
		return navigator.userAgent.match(/iPhone/i);

	}

	function resizeViewport() {

		$('#viewport').css({width: $(window).width(), height: (isPhone() && !rotated()) ? 1670 :  $(document).height()});

	}

	function setScroll() {

		if (isPhone())
			window.scrollTo(0, (rotated()) ? $('#magazine').offset().top-6 : 1);

	}

	function moveMagazine(page) {

	var that = $('#magazine'),
			rendered = that.data().done,
			width = that.width(),
			pageWidth = width/2,
			total = that.data().totalPages,
			options = {duration: (!rendered) ? 0 : 600, easing: 'easeInOutCubic', complete: function(){ $('#magazine').turn('resize'); }};


			$('#controllers').stop();

			if (page==total)
					$('#shadow-page').fadeOut(0);

			if ((page==1 || page == total) && !rotated()) {

				var leftc = ($(window).width()-width)/2,
					leftr = ($(window).width()-pageWidth)/2, 
					leftd = (page==1)? leftr - leftc - pageWidth : leftr - leftc;

				$('#controllers').animate({left: leftd}, options);
				
			} else {
				$('#shadow-page').fadeOut('slow');
				$('#controllers').animate({left: 0}, options);
			}
	}


	$(document).ready(function() {

	

		// Turn events 
		$('#magazine').
			bind('turn', function(e, page){

				moveMagazine(page);

			}).
			bind('turned', function(e, page, pageObj) {

				var rendered = $(this).data().done;
				
				moveMagazine(page);

				if (!rendered) {
					$('#controllers').fadeIn();
				} else {
					jQuery.each(pages, function(index, value) {
						if (page==index+1) {
							var newUrl = getURL() + '#' + value;
							window.location.href = newUrl;
							return false;
						}
					});
				}

				setControllPos();

				if (page==1) $('#shadow-page').fadeIn('slow');
				else $('#shadow-page').fadeOut((rendered) ? 'slow' : 0);

				setScroll();	

		 }).bind('start', function(e, page) {
		 
			if (page==2)
				$('#previous').hide();
			else if (page==$(this).data().totalPages-1)
				$('#next').hide();

		}).bind('end', function(e, page) {

			if (page!=1) 
				$('#previous').show();
			if (page!=$(this).data().totalPages-1)
				$('#next').show();

		});


		// Window events 
		$(window).bind('keydown', function(e){
			
			if (e.keyCode==37) 
				$('#magazine').turn('previous');
			else if (e.keyCode==39)
				$('#magazine').turn('next');

		}).bind('hashchange', function() {
			
				var page = checkHash();
				if (pages!=$('#magazine').turn('page'))
				$('#magazine').turn('page', page);

		}).bind('touchstart', function(e) {

			var t = e.originalEvent.touches;
			if (t[0]) touchStart = {x: t[0].pageX, y: t[0].pageY};

			touchEnd = null;

		}).bind('touchmove', function(e) {

			var t = e.originalEvent.touches, pos = $('#magazine').offset();

			if (t[0].pageX>pos.left && t[0].pageY>pos.top && t[0].pageX<pos.left+$('#magazine').width() && t[0].pageY<pos.top+$('#magazine').height()) {
				
				if (t.length==1)
				e.preventDefault();
			
				if (t[0]) touchEnd = {x: t[0].pageX, y: t[0].pageY};

			}

		}).bind('touchend', function(e) {

			if (window.touchStart && window.touchEnd) {
				var that = $('#magazine'),
					w = that.width()/2,
					d = {x: touchEnd.x-touchStart.x, y: touchEnd.y-touchStart.y},
					pos = {x: touchStart.x-that.offset().left, y: touchStart.y-that.offset().top};
			
				if (Math.abs(d.y)<100)
				 if (d.x>100 && pos.x<w)
				 	$('#magazine').turn('previous');
				 else if (d.x<100 && pos.x>w)
				 	$('#magazine').turn('next');

			}
		}).resize(function() {
 			
 			$('#magazine').turn('resize');

 			resizeViewport();

		});


		$('#next').click(function(e) {
			
			
			$('#magazine').turn('next');
			return false;

		});

		$('#previous').click(function(e) {
			
			e.stopPropagation();

			$('#magazine').turn('previous');
			return false;

		});

		$('#magazine').children(':first').bind('flip', function() {
			
		

		}).find('p').fadeOut(0).fadeIn(2000);


		$('body').bind('orientationchange', function() {
			
			resizeViewport();

			setScroll();

			moveMagazine($('#magazine').turn('page'));

		});

		// Create internal instance 
		
		if ($(window).width()<=1200)
			$('body').addClass('x1024');
		
		$('#magazine').turn({page: checkHash(), gradients: !$.isTouch, acceleration: $.isTouch, elevation: 50});


		resizeViewport();

		setScroll();

	
	});

