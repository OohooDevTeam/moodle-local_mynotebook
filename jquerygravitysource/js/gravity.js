var Gravity = {
		
	init: function() {
		
		$("#air .block_container").css({
			height: $("#air").outerHeight() + "px"
		});
		
		$(".handle").mouseenter(function(i) {
			//animate the cutting of the string
			$(this).animate({
				height: "20px"
			}, {
				duration: 1500,
				easing: "easeOutElastic"
			});
			
			var block = $(this).parent().next();
			
			var yposBlock = $(block).position()['top'] - $("#air").position()['top'];
			var fallDist = ($("#air").outerHeight() - yposBlock) - $(block).outerHeight();
			
			//let the block fall
			$(block).stop().animate({
				marginTop: fallDist+"px"
			}, {
				duration: 1000,
				easing: "easeOutBounce"
			});
		});
	
	},
	
	reset: function() {
		$(".handle").stop().animate({
			height: "50px"
		},{
			duration: 1000,
			easing: "easeInElastic"
		});
		
		$(".block").stop().animate({
			marginTop: "0px"
		},{
			duration: 1000,
			easing: "easeInBounce"
		});
	}

}

$(document).ready(function(){
	Gravity.init();
});