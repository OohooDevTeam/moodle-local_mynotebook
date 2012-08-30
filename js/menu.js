var speed = 400;//speed of lava lamp
var menuFadeIn = 350;//speed of menu fade in transition
var menuFadeOut = 350;//speed of menu fade in transition
var style = 'easeInOutBack';//style of lava lamp
var totalWidth = 0;//variable for calculating total width of menu according to how many li's there are
var reducedWidth = 4;
(function($) {
$(document).ready(function(){

	if($.browser.opera){
		$(".nav ul").css("margin-top", "32px");//opera fix for margin top
		$(".nav ul ul").css("margin-top", "-20px");
	}
    if(!$.browser.msie){// ie fix
		$("ul.nav span").css("opacity", "0");
		$(".nav ul ul ul").css("margin-top", "-20px");
	}
	if($.browser.msie){
		$("ul.nav span").css({visibility:"hidden"});
	}
       totalWidth = $(".nav li:last").offset().left -  $(".nav li:first").offset().left + $(".nav li:last").width();//width of menu
	   $(".nav").css({width:totalWidth});//setting total width of menu

	   var dLeft = $('.nav li:first').offset().left;//setting default position of menu
	   var dWidth = $('.nav li:first').width() + reducedWidth;
	   var dTop = $('.nav li:first').offset().top;

		//Set the initial lava lamp position and width
		$('#box').css({left:dLeft});
		$('#box').css({top: dTop});
		$('#box').css({width: dWidth});

	$(".nav > li").hover(function(){
		var position = $(this).offset().left;//set width and position of lava lamp
		var width = $(this).width()+ reducedWidth;
		if(!$.browser.msie){//hover effect of triangle (glow)
			$(this).find('span:first').stop().animate({opacity: 1}, 'slow');
		}
		else{
			$(this).find('span:first').css({visibility:"visible"});
        }
		$('#box').stop().animate({left:position, width:width},{duration:speed, easing: style});
		},
		function(){
	    if(!$.browser.msie){
			$(this).find('span:first').stop().animate({opacity: 0}, 'slow');//hiding the glow on mouseout
		}

		if($.browser.msie){
			$(this).find('span:first').css({visibility:"hidden"});
        }
	});


	 $(".submenu").hover(function(){//animating the fade in and fade out of submenus level 1
        $(this).find('li').fadeIn(menuFadeIn);
		$('li li li').css({display:"none"});
		},
        function(){
		    $(this).find('li').fadeOut(menuFadeIn);
	    });

    	 $(".submenu2").hover(function(){//animating the fade in and fade out of submenus level 2
			$(this).find('li').fadeIn(menuFadeIn);
			$('li li li li').css({display:"none"});

		},
        function(){
            $(this).find('li').fadeOut(menuFadeOut);

        });
		 $(".submenu3").hover(function(){//animating the fade in and fade out of submenus  level 3
        $(this).find('li').fadeIn(menuFadeIn);
		},
        function(){
            $(this).find('li').fadeOut(menuFadeOut);


        });
});

})($);
