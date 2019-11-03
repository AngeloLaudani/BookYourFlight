$(document).ready(function () {

	/* Page load fade */
	$('body').removeClass('fade-out');

	/* For the sticky navigation */
	$('.js--section-features').waypoint(function (direction) {
		if (direction === "down") {
			$('nav').addClass('sticky');
			$('.sidenav-icon').addClass('sticky-icon');
		} else {
			$('nav').removeClass('sticky');
			$('.sidenav-icon').removeClass('sticky-icon');
		}
	}, {
		offset: '60px;'
	});

	/* For the side navigation */
	$('.sidenav-icon').click(function () {
		var nav = $('.sidenav');
		var nav_icon = $('.sidenav-icon');
		var icon = $('.sidenav-icon i');

		if (icon.hasClass('ion-ios-menu')) {
			icon.addClass('ion-ios-close');
			icon.removeClass('ion-ios-menu');
			nav.addClass('open-nav');
			nav_icon.addClass('open-icon');
		} else {
			icon.addClass('ion-ios-menu');
			icon.removeClass('ion-ios-close');
			nav.removeClass('open-nav');
			nav_icon.removeClass('open-icon');
		}
	});

	/* Cookie Check */
	function areCookiesEnabled() {
		try {
			document.cookie = 'cookietest=1';
			var cookiesEnabled = document.cookie.indexOf('cookietest=') !== -1;
			document.cookie = 'cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT';
			return cookiesEnabled;
		} catch (e) {
			return false;
		}
	}
	if (!areCookiesEnabled()) {
		$('.pagecontainer').css("display", "none");
		$('.no-cookies-msg').css("display", "block");
	}


	/* Scroll on buttons */
	$('.js--scroll-to-start').click(function () {
		$('html, body').animate({
			scrollTop: $('.js--section-features').offset().top
		}, 1000);
	});


	/* Navigation scroll */
	$(function () {
		$('a[href*=\\#]:not([href=\\#])').click(function () {
			if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					$('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});
	});


	/* Animations on scroll */
	$('.js--wp-1').addClass('animated fadeIn');


	$('.js--wp-2').waypoint(function () {
		$('.js--wp-2').addClass('animated fadeIn');
	}, {
		offset: '50%'
	});

	$('.js--wp-3').waypoint(function () {
		$('.js--wp-3').addClass('animated fadeInLeft');
	}, {
		offset: '50%'
	});

	$('.js--wp-4').waypoint(function () {
		$('.js--wp-4').addClass('animated fadeInRight');
	}, {
		offset: '50%'
	});

	$('.js--wp-5').waypoint(function () {
		$('.js--wp-5').addClass('animated fadeIn');
	}, {
		offset: '50%'
	});

	$('.js--wp-6').waypoint(function () {
		$('.js--wp-6').addClass('animated fadeInUp');
	}, {
		offset: '80%'
	});

	$('.js--wp-7').waypoint(function () {
		$('.js--wp-7').addClass('animated pulse');
	}, {
		offset: '50%'
	});


	/* Mobile navigation */
	$('.js--nav-icon').click(function () {
		var nav = $('.js--main-nav');
		var icon = $('.js--nav-icon i');

		nav.slideToggle(200);

		if (icon.hasClass('ion-ios-list')) {
			icon.addClass('ion-ios-close');
			icon.removeClass('ion-ios-list');
		} else {
			icon.addClass('ion-ios-list');
			icon.removeClass('ion-ios-close');
		}
	});

	/* Personal Page */
	$(document).on('click', '.check-grid', function () {
		$('.personal-grid').removeClass('hide').addClass('show');
		$('.personal-rules').removeClass('show').addClass('hide');
	});

	$(document).on('click', '.check-rules', function () {
		$('.personal-rules').removeClass('hide').addClass('show');
		$('.personal-grid').removeClass('show').addClass('hide');
	});

});
