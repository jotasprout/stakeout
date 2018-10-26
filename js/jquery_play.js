// JavaScript Document



// This first bit, commented out was from a Codecademy exercise.





$(document).ready(function(){

	

	$("div").hover(

	

		function(){

			$(this).addClass("active");

		},

		function(){

			$(this).removeClass("active");

		}

		);

		

});



// This next bit is actually used for a "real" page--my inserting presidents form.



$(document).ready(function(){

	$("input").focus(function(){

		$(this).css("background-color", "#9999ff");

	});

});



$(document).ready(function(){

	$("input").blur(function(){

		$(this).css("background-color", "#FFFFFF");

	});

});