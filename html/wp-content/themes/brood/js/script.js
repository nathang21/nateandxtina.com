var $ = jQuery.noConflict();
$(document).ready(function(){
	$('.feat-slider').owlCarousel({
		items: 1,
		nav: true,
		loop: true,
		dots: false,
		mouseDrag: false,
		navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right"></span>' ]
	});
});