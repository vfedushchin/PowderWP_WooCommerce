(function ($) {

	var settings = {
			cntClass: 'rd-mobilemenu',
			menuClass: 'rd-mobilemenu_ul',
			submenuClass: 'rd-mobilemenu_submenu',
			panelClass: 'rd-mobilepanel',
			toggleClass: 'rd-mobilepanel_toggle',
			titleClass: 'rd-mobilepanel_title'
		},
		lastY, dir;

	var RDMobileMenu = function (element, options) {
		this.options = options;

		this.$source = $(element);
	};

	RDMobileMenu.prototype = {
		init: function () {
			var nav = this;
			nav.createDOM();
			nav.createListeners();
		},

		createDOM: function () {
			var nav = this;

			$('body')
				.append($('<div/>', {
					'class': settings.cntClass
				}).append(nav.createNavDOM()))
				.append($('<div/>', {
					'class': settings.panelClass
				})
					.append($('<button/>', {
						'class': settings.toggleClass
					}).append($('<span/>')))
					.append($('<h2/>', {
						'class': settings.titleClass,
						'text': document.title
					})));
		},

		createNavDOM: function () {
			var nav = this;

			var menu = $('<ul>', {'class': settings.menuClass});

			var li = nav.$source.children();

			for (var i = 0; i < li.length; i++) {
				var o = li[i].children,
					item = null;
				for (var j = 0; j < o.length; j++) {
					if (o[j].tagName) {
						if (!item) {
							item = document.createElement('li');
							if (li[i].className.indexOf('current_page_item') > -1) {
								item.className = 'current_page_item';
							}
						}

						switch (o[j].tagName.toLowerCase()) {
							case 'a':
								var link = o[j].cloneNode(true);
								item.appendChild(link);
								break;
							case 'ul':
								var submenu = o[j].cloneNode(true);
								submenu.className = settings.submenuClass;
								$(submenu).css({"display": "none"});
								item.appendChild(submenu);
								$(item).find('> a')
									.each(function () {
										$this = $(this);
										$this.addClass('rd-with-ul')
											.append($('<span/>', {class: 'rd-submenu-toggle'}))
											.find('.rd-submenu-toggle')
											.on('click', function (e) {
												e.preventDefault();
												$this = $(this).parent();

												if ($this.hasClass('rd-with-ul') && !$this.hasClass('opened')) {
													$('.rd-with-ul').removeClass('opened');
													var submenu = $this.addClass('opened').parent().find('.' + settings.submenuClass);
													submenu.stop().css({"display": "block"});
													$('.' + settings.submenuClass).not(submenu).stop();
												} else {
													var submenu = $this.removeClass('opened').parent().find('.' + settings.submenuClass);
													submenu.stop().css({"display": "none"});
												}
											});
									});

								break;
							default:
								break;
						}
					}
				}

				if (item) {
					menu.append(item);
				}
			}

			return menu;
		},

		createListeners: function () {
			var nav = this;

			nav.createToggleListener();
			nav.createResizeListener();
		},

		createToggleListener: function () {
			var nav = this,
				type;

			if (nav.isMobile()) {
				type = 'touchstart';
			} else {
				type = 'click';
			}

			$('body').delegate('.' + settings.toggleClass, type, function () {
				var o = $('.' + settings.cntClass);
				$(this).toggleClass('active');

				if (o.hasClass('active')) {
					$(this).removeClass('active');
					o.removeClass('active');
					$('body').undelegate('*', 'mousewheel', nav.scroll);
					$('body').undelegate('*', 'touchmove', nav.scroll);
					$('body').undelegate('*', 'touchend', nav.touchend);
					$('body').undelegate('*', 'touchstart', nav.close);
					$('body').undelegate('*:not(.' + settings.toggleClass + ' span)', 'click', nav.close);
				} else {
					$(this).addClass('active');
					o.addClass('active');
					$('body').delegate('*', 'mousewheel', nav.scroll);
					$('body').delegate('*', 'touchmove', nav.scroll);
					$('body').delegate('*', 'touchend', nav.touchend);
					$('body').delegate('*', 'touchstart', {type: type}, nav.close);
					$('body').delegate('*:not(.' + settings.toggleClass + ' span)', 'click', {type: type}, nav.close);
				}
			});
		},

		createResizeListener: function () {
			var nav = this;

			$(window).on('resize', function () {
				var o = $('.' + settings.cntClass);

				if (o.css('display') == 'none') {
					o.removeClass('active');
					$('.' + settings.toggleClass).removeClass('active');
					$('body').undelegate('*', 'mousewheel', nav.scroll);
					$('body').undelegate('*', 'touchmove', nav.scroll);
					$('body').undelegate('*', 'touchend', nav.touchend);
					$('body').undelegate('*', 'touchstart', nav.close);
					$('body').undelegate('*:not(.' + settings.toggleClass + ' span)', 'click', nav.close);
				}
			});
		},

		scroll: function (e) {
			e.preventDefault();
			var menu = $('.' + settings.menuClass);

			var x = e.originalEvent.targetTouches ? e.originalEvent.targetTouches[0].pageX : e.pageX,
				y = e.originalEvent.targetTouches ? e.originalEvent.targetTouches[0].pageY : e.pageY;

			if (
				y > menu.offset().top &&
				y < (menu.offset().top + menu.outerHeight()) &&
				x > menu.offset().left &&
				x < (menu.offset().left + menu.outerWidth())
			) {
				var delta = 0;
				if (e.originalEvent.targetTouches) {
					if (!lastY) lastY = y;
					delta = (lastY - y);

					lastY = y;
					dir = delta > 0;

				} else {
					delta = (e.originalEvent.wheelDelta || -e.originalEvent.detail) * (-50)
				}

				menu.stop().scrollTop(menu.scrollTop() + delta);
			}
			return false;
		},

		touchend: function (e) {
			var menu = $('.' + settings.menuClass);

			menu.stop().animate({
				scrollTop: menu.scrollTop() + (dir ? 100 : -100)
			}, 3000, 'easeOutQuint');
			lastY = undefined;
		},

		close: function (e) {
			if (!e.originalEvent) {
				return;
			}

			var menu = $('.' + settings.menuClass);
			var x = e.originalEvent.targetTouches ? e.originalEvent.targetTouches[0].pageX : e.pageX,
				y = e.originalEvent.targetTouches ? e.originalEvent.targetTouches[0].pageY : e.pageY;

			if (!(
					y > menu.offset().top &&
					y < (menu.offset().top + menu.outerHeight()) &&
					x > menu.offset().left &&
					x < (menu.offset().left + menu.outerWidth())
				)
			) {
				$('.' + settings.toggleClass).trigger(e.data.type);
			}
		},

		isMobile: function () {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
		}
	};

	$.fn.rdparallax = function (option) {
		var o = this;
		if (o.length) {
			new RDMobileMenu(o[0]).init();
		}
		return o;
	};

	window.RDMobilemenu_autoinit = function (selector) {
		var o = $(selector);
		if (o.length) {
			new RDMobileMenu(o[0]).init();
		}
	};

	RDMobilemenu_autoinit('[id*="rd-navbar-menu"]');

	$(function () {
		$('#wpadminbar').addClass('rd-navbar-active');
	});

	function addNavbarShopMenu() {
		$('#rd-navbar-shop-menu li').clone('#rd-navbar-shop-menu li').appendTo('.rd-mobilemenu_ul').addClass('rd-mobile-menu-shop');
	};

	function addNavbarContent() {
		if ($(window).width() < 767) {
			$('.currency_switcher').appendTo('.rd-mobilemenu_ul').addClass('rd-mobile-currency');
			// alert('piZdeTs');
			$('.social-list.social-list--header').appendTo('.rd-mobilemenu_ul').addClass('rd-mobile-social-list');
		} else {
			$('.currency_switcher').appendTo('.search_switcher_block').removeClass('rd-mobile-currency');
			$('.social-list.social-list--header').appendTo('.rd-mobilemenu_ul').addClass('rd-mobile-social-list');
		}
	};

	addNavbarShopMenu();

	addNavbarContent();

	$(window).resize(addNavbarContent);

	$('.navbar-search-toggle').on('click', function () {
		$(this).toggleClass('search-active');
		$('.navbar-search').toggleClass('search-active');
		$('.rd-mobilepanel').toggleClass('search-active');
		$('.navbar-header-cart').toggleClass('search-active');
	});

	if (window.pageYOffset > 1) {
		$('.rd-mobilepanel').addClass('rd-mobilepanel-isStuck');
	}

	$(window).scroll(function () {
		if ($(this).scrollTop() > 1) {
			$('.rd-mobilepanel').addClass('rd-mobilepanel-isStuck');
		} else {
			$('.rd-mobilepanel').removeClass('rd-mobilepanel-isStuck');
		}
	});
})(jQuery);