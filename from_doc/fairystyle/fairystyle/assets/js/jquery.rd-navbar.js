;
(function ($) {

	var settings = {
		cntClass: 'rd-mobilemenu',
		menuClass: 'rd-mobilemenu_ul',
		submenuClass: 'rd-mobilemenu_submenu',
		panelClass: 'rd-mobilepanel',
		toggleClass: 'rd-mobilepanel_toggle',
		titleClass: 'rd-mobilepanel_title'
	};

	var RDMobileMenu = function (element, options) {
		this.options = options;

		this.$source = $(element);
	};

	RDMobileMenu.prototype = {
		init: function () {
			this.createDOM();
			this.createListeners();
		},

		createDOM: function () {
			$('body')
				.append($('<div/>', {
					'class': settings.cntClass
				}).append(this.createNavDOM()))
				.append($('<div/>', {
						'class': settings.panelClass
					})
					.append($('<button/>', {
						'class': settings.toggleClass
					}).append($('<span/>')))
				);
		},

		createNavDOM: function () {
			var menu = $('<ul>', {'class': settings.menuClass}),
				li = this.$source.children();

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
			this.createToggleListener();
			this.createResizeListener();
		},

		createToggleListener: function () {
			var isTouch = "ontouchstart" in window;

			$('.' + settings.toggleClass).on((isTouch ? 'touchstart' : 'click'), function () {
				$('.' + settings.cntClass).toggleClass('active');
				$(this).toggleClass('active');
			});

			$('.navbar-header-cart').on((isTouch ? 'touchstart' : 'click'), function () {
				$('.' + settings.cntClass).removeClass('active');
				$('.' + settings.toggleClass).removeClass('active');
			});

			$.fn.touchScrolling = function () {
				var startPos = 0,
					self = $(this);

				self.bind('touchstart', function (event) {
					var e = event.originalEvent;
					startPos = self.scrollTop() + e.touches[0].pageY;
					e;
				});

				self.bind('touchmove', function (event) {
					var e = event.originalEvent;
					self.scrollTop(startPos - e.touches[0].pageY);
					e.preventDefault();
				});
			};

			$(function () {
				$('.rd-mobilemenu_ul').touchScrolling();
			});
		},

		createResizeListener: function () {
			$(window).on('resize', function () {
				$('.' + settings.cntClass).removeClass('active');
				$('.' + settings.toggleClass).removeClass('active');
			});
		}
	};

	window.RDMobilemenu_autoinit = function (selector) {
		var o = $(selector);
		if (o.length) {
			new RDMobileMenu(o[0]).init();
		}
	};

	RDMobilemenu_autoinit('[id*="main-menu"]');

	$(document).ready(function () {
		var $rdMobilePanel = $('.rd-mobilepanel'),
			$rdMobilepanelToggle = $('.rd-mobilepanel_toggle'),
			$rdMobileMenu = $('.rd-mobilemenu'),
			$rdMobileMenuUl = $('.rd-mobilemenu_ul'),
			$navbarSearch = $('.navbar-search'),
			$navbarSearchToggle = $('.navbar-search-toggle'),
			$navbarHeaderCart = $('.navbar-header-cart'),
			rdMobilePanelisStuck = 'rd-mobilepanel-isStuck',
			searchSwitcherBlock = '.search_switcher_block',
			SearchActive = 'search-active';

		$('#wpadminbar').addClass('rd-navbar-active');

		function addNavbarContent() {
			$('#rd-navbar-shop-menu li').clone().appendTo('.' + settings.menuClass).addClass('rd-mobile-menu-shop');
			$('.currency_switcher').clone().appendTo('.' + settings.menuClass).addClass('rd-mobile-currency');
			$('#lang_sel').clone().appendTo('.' + settings.menuClass).addClass('rd-mobile-lang');
			$('.social-list.social-list--header').clone().appendTo('.' + settings.menuClass).addClass('rd-mobile-social-list');
			$navbarHeaderCart.addClass('navbar-header-cart-active');
		};

		$('.navbar-search-toggle').on('click', function () {
			$(this).toggleClass(SearchActive);
			$navbarSearch.toggleClass(SearchActive);
			$('.' + settings.panelClass).toggleClass(SearchActive);
			$navbarHeaderCart.toggleClass(SearchActive);
		});

		function MobilePanelisStuck(){
			if (window.pageYOffset > 1) {
				$('.' + settings.panelClass).addClass(rdMobilePanelisStuck);
			}

			$(window).scroll(function () {
				if ($(this).scrollTop() > 1) {
					$('.' + settings.panelClass).addClass(rdMobilePanelisStuck);
				} else {
					$('.' + settings.panelClass).removeClass(rdMobilePanelisStuck);
				}
			});
		}

		function wpadminbarActive() {
			var offsetNavbarwpAdminBarActive = 'offset-navbar-adminbar-active',
				posAbsolute = 'absolute',
				wpAdminBarActive = 'wpadminbar-active',
				wpadminbarHeight = $('#wpadminbar').height();


			function wpAdminBarActiveAddClass() {
				$rdMobilePanel.addClass(offsetNavbarwpAdminBarActive);
				$rdMobilepanelToggle.addClass(posAbsolute);
				$rdMobileMenu.addClass(offsetNavbarwpAdminBarActive);
				$rdMobileMenuUl.addClass(posAbsolute);
				$navbarSearch.addClass(offsetNavbarwpAdminBarActive);
				$navbarSearchToggle.addClass(offsetNavbarwpAdminBarActive);
				$navbarHeaderCart.addClass(offsetNavbarwpAdminBarActive);
			}

			function wpAdminBarActiveRemoveClass() {
				$rdMobilePanel.removeClass(offsetNavbarwpAdminBarActive);
				$rdMobilepanelToggle.removeClass(posAbsolute);
				$rdMobileMenu.removeClass(offsetNavbarwpAdminBarActive);
				$rdMobileMenuUl.removeClass(posAbsolute);
				$navbarSearch.removeClass(offsetNavbarwpAdminBarActive);
				$navbarSearchToggle.removeClass(offsetNavbarwpAdminBarActive);
				$navbarHeaderCart.removeClass(offsetNavbarwpAdminBarActive);
			}

			function wpAdminBarActiveScroll() {
				$(window).scroll(function () {
					if ($(window).width() < 768) {
						if ($(this).scrollTop() > wpadminbarHeight) {
							wpAdminBarActiveRemoveClass();
						} else {
							wpAdminBarActiveAddClass();
						}
					}
				});
			}

			function wpadminbarActiveAdd() {
				if ($(window).width() < 768) {
					$('body').addClass(wpAdminBarActive);
					if (this.pageYOffset < wpadminbarHeight) {
						wpAdminBarActiveAddClass();
					} else{
						wpAdminBarActiveRemoveClass();
					}
					wpAdminBarActiveScroll();
				} else {
					$('body').removeClass(wpAdminBarActive);
					wpAdminBarActiveRemoveClass();
				}
			};

			wpadminbarActiveAdd();

			$(window).resize(wpadminbarActiveAdd);
		}

		addNavbarContent();

		MobilePanelisStuck();

		if ($('.rd-navbar-active').length) {
			wpadminbarActive();
		}
	});
})(jQuery);