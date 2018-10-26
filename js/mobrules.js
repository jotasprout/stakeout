if (window.innerWidth && window.innerWidth <= 600) {
	$(document).ready(function() {
		$('nav').removeClass('navbar navbar-default');
		$('#header').removeClass('container-fluid');
		$('#header h1').removeClass('hide');
		$('#header ul').addClass('hide');
		var $homeLink = $('#home');
		$homeLink.remove();
		$('#cases').addClass('newFirstChild');
		$('#header').append('<div class="leftButton" onclick="toggleMenu()">Menu</div>');
	});

	function toggleMenu() {
		$('#header ul').toggleClass('hide');
		$('#header .leftButton').toggleClass('pressed');
	}
}