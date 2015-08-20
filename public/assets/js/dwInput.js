jQuery.noConflict();
( function($) {

	$(document).ready(function() {
		$('#slider1').cycle({
			//fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				fx:     'fade',
				timeout: 6000,
				delay:  1000,
				pager: '#navSlider'
		});
		
			//masker
			var e = "aemp1224"; // replace with your email username
			var atSign = "@"; // replace with your email username
			var t = "outlook"; // replace with your email provider
			var n = ".com"; // replace with your email provider TLD
			var r =  e + atSign + t + n;
			$('.hide-email').attr('href','mailto:' + r).html(r);
			
			var delayTime = 100;
		
			//toggle menu mobile
			$('#menu-toggle').click(function (e) {
				$('#menu').slideToggle( "slow");
				e.preventDefault();
			});
			
			//toggle menu mobile
			$('#searchLoupe').click(function (e) {
				$('#searchForm').slideToggle( "slow");
				e.preventDefault();
			});			
		
			$('.hasChild').mouseenter(function (e) {
				$(this).children('div.dropContainer').stop().slideDown(delayTime);
			});
			
			$('.hasChild').mouseleave(function () {
				$(this).children('div.dropContainer').stop().slideUp(delayTime);
			});		
		
		
	});


} ) ( jQuery );