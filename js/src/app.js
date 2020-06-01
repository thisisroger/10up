(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		$('.nav__mobile-toggle').on('click', function(e) {
            $(this).toggleClass("nav__mobile-toggle--active");
            $(".nav").slideToggle();
            
        });
		
	});
	
})(jQuery, this);