/**
 * GP-Industry – front-end behaviour
 * Header, mobile navigation, dropdowns, theme toggle, search modal,
 * back-to-top, reading progress, scroll reveal, copy link.
 */
(function () {
	'use strict';

	var docEl = document.documentElement;
	docEl.classList.add('js');

	var settings = window.gpiSettings || { i18n: {} };
	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
	function qsa(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

	/* ------------------------------------------------------------------
	 * Header: scrolled state
	 * ---------------------------------------------------------------- */
	var header = qs('.site-header');
	function onScrollHeader() {
		if (!header) { return; }
		header.classList.toggle('scrolled', window.scrollY > 16);
	}

	/* ------------------------------------------------------------------
	 * Mobile navigation
	 * ---------------------------------------------------------------- */
	var menuToggle = qs('.menu-toggle');
	var nav = qs('#site-navigation');
	var navBackdrop = qs('.nav-backdrop');

	function setNav(open) {
		if (!menuToggle || !nav) { return; }
		menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		menuToggle.setAttribute('aria-label', open ? (settings.i18n.closeMenu || 'Close menu') : (settings.i18n.openMenu || 'Open menu'));
		nav.classList.toggle('is-active', open);
		if (navBackdrop) { navBackdrop.classList.toggle('is-active', open); }
		document.body.classList.toggle('nav-open', open);
		if (open) {
			var first = qs('a, button', nav);
			if (first) { first.focus({ preventScroll: true }); }
		}
	}

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', function () {
			setNav(menuToggle.getAttribute('aria-expanded') !== 'true');
		});
		qsa('[data-nav-close]').forEach(function (el) {
			el.addEventListener('click', function () { setNav(false); menuToggle.focus(); });
		});
		// Close after choosing an in-page anchor on mobile.
		nav.addEventListener('click', function (e) {
			var link = e.target.closest('a');
			if (link && link.getAttribute('href') && link.getAttribute('href').charAt(0) === '#' && window.innerWidth <= 900) {
				setNav(false);
			}
		});
	}

	/* ------------------------------------------------------------------
	 * Submenu toggles (mobile tap + keyboard on desktop)
	 * ---------------------------------------------------------------- */
	qsa('.nav-menu .submenu-toggle').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();
			var li = btn.parentElement;
			var open = !li.classList.contains('is-open');

			// Close siblings.
			qsa(':scope > li.is-open', li.parentElement).forEach(function (sib) {
				if (sib !== li) {
					sib.classList.remove('is-open');
					var sb = qs(':scope > .submenu-toggle', sib);
					if (sb) { sb.setAttribute('aria-expanded', 'false'); }
				}
			});

			li.classList.toggle('is-open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	});

	// Close open dropdowns when clicking outside (desktop).
	document.addEventListener('click', function (e) {
		if (e.target.closest('.nav-menu')) { return; }
		qsa('.nav-menu li.is-open').forEach(function (li) {
			li.classList.remove('is-open');
			var b = qs(':scope > .submenu-toggle', li);
			if (b) { b.setAttribute('aria-expanded', 'false'); }
		});
	});

	/* ------------------------------------------------------------------
	 * Dark / light toggle
	 * ---------------------------------------------------------------- */
	qsa('.theme-toggle').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var next = docEl.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
			docEl.setAttribute('data-theme', next);
			try { localStorage.setItem('gp-industry', next); } catch (err) { /* private mode */ }
		});
	});

	/* ------------------------------------------------------------------
	 * Search modal
	 * ---------------------------------------------------------------- */
	var searchModal = qs('#search-modal');
	var searchToggles = qsa('.search-toggle');
	var lastFocused = null;

	function openSearch() {
		if (!searchModal) { return; }
		lastFocused = document.activeElement;
		searchModal.hidden = false;
		document.body.classList.add('search-open');
		searchToggles.forEach(function (t) { t.setAttribute('aria-expanded', 'true'); });
		var input = qs('input[type="search"]', searchModal);
		if (input) { setTimeout(function () { input.focus(); }, 30); }
	}

	function closeSearch() {
		if (!searchModal || searchModal.hidden) { return; }
		searchModal.hidden = true;
		document.body.classList.remove('search-open');
		searchToggles.forEach(function (t) { t.setAttribute('aria-expanded', 'false'); });
		if (lastFocused && lastFocused.focus) { lastFocused.focus(); }
	}

	searchToggles.forEach(function (t) { t.addEventListener('click', openSearch); });
	if (searchModal) {
		qsa('[data-search-close]', searchModal).forEach(function (el) { el.addEventListener('click', closeSearch); });
		// Simple focus trap.
		searchModal.addEventListener('keydown', function (e) {
			if (e.key !== 'Tab') { return; }
			var focusables = qsa('button, input, a[href]', searchModal).filter(function (el) { return !el.disabled; });
			if (!focusables.length) { return; }
			var first = focusables[0];
			var last = focusables[focusables.length - 1];
			if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
			else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
		});
	}

	// Keyboard shortcuts: Esc closes overlays, "/" opens search.
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			closeSearch();
			if (menuToggle && menuToggle.getAttribute('aria-expanded') === 'true') {
				setNav(false);
				menuToggle.focus();
			}
		}
		if (e.key === '/' && searchModal && searchModal.hidden) {
			var tag = (document.activeElement && document.activeElement.tagName) || '';
			if (!/INPUT|TEXTAREA|SELECT/.test(tag) && !(document.activeElement && document.activeElement.isContentEditable)) {
				e.preventDefault();
				openSearch();
			}
		}
	});

	/* ------------------------------------------------------------------
	 * Hero background slideshow (crossfade + Ken Burns)
	 * ---------------------------------------------------------------- */
	var heroSlides = qs('.hero-slides');
	if (heroSlides) {
		var slides = qsa('.hero-slide', heroSlides);
		var dots = qsa('.hero-dot');
		var interval = parseInt(heroSlides.getAttribute('data-interval') || '5000', 10);
		var current = 0;
		var timer = null;

		// Load backgrounds for slides after the first one lazily.
		slides.forEach(function (el) {
			var bg = el.getAttribute('data-bg');
			if (bg) {
				var img = new Image();
				img.onload = function () { el.style.backgroundImage = 'url("' + bg + '")'; el.classList.add('is-loaded'); };
				img.src = bg;
			}
		});

		function goTo(index) {
			if (slides.length < 2) { return; }
			current = (index + slides.length) % slides.length;
			slides.forEach(function (el, i) { el.classList.toggle('is-active', i === current); });
			dots.forEach(function (d, i) { d.classList.toggle('is-active', i === current); });
		}

		function stop() {
			if (timer) { clearInterval(timer); timer = null; }
		}

		function start() {
			stop();
			if (slides.length > 1) { timer = setInterval(function () { goTo(current + 1); }, interval); }
		}

		dots.forEach(function (d) {
			d.addEventListener('click', function () {
				goTo(parseInt(d.getAttribute('data-slide'), 10) || 0);
				start();
			});
		});

		document.addEventListener('visibilitychange', function () {
			if (document.hidden) { stop(); } else { start(); }
		});

		start();
	}

	/* ------------------------------------------------------------------
	 * Announcement bar (dismiss is remembered per message)
	 * ---------------------------------------------------------------- */
	var topbar = qs('.topbar');
	if (topbar) {
		var topbarKey = 'nova-topbar-' + (topbar.getAttribute('data-topbar-id') || '');
		try {
			if (localStorage.getItem(topbarKey) === '1') { topbar.classList.add('is-dismissed'); }
		} catch (err) { /* ignore */ }
		var topbarClose = qs('.topbar-close', topbar);
		if (topbarClose) {
			topbarClose.addEventListener('click', function () {
				topbar.classList.add('is-dismissed');
				try { localStorage.setItem(topbarKey, '1'); } catch (err) { /* ignore */ }
			});
		}
	}

	/* ------------------------------------------------------------------
	 * Back to top + reading progress
	 * ---------------------------------------------------------------- */
	var backToTop = qs('.back-to-top');
	var progressBar = qs('.reading-progress span');
	var article = qs('.single-article');

	if (backToTop) {
		backToTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
		});
	}

	function onScrollUI() {
		if (backToTop) {
			backToTop.classList.toggle('is-visible', window.scrollY > 500);
		}
		if (progressBar && article) {
			var rect = article.getBoundingClientRect();
			var total = article.offsetHeight - window.innerHeight;
			var done = total > 0 ? Math.min(1, Math.max(0, -rect.top / total)) : 1;
			progressBar.style.width = (done * 100).toFixed(2) + '%';
		}
	}

	var ticking = false;
	window.addEventListener('scroll', function () {
		if (ticking) { return; }
		ticking = true;
		window.requestAnimationFrame(function () {
			onScrollHeader();
			onScrollUI();
			ticking = false;
		});
	}, { passive: true });

	onScrollHeader();
	onScrollUI();

	/* ------------------------------------------------------------------
	 * Scroll reveal
	 * ---------------------------------------------------------------- */
	var revealEls = qsa('[data-reveal]');
	if (revealEls.length) {
		revealEls.forEach(function (el) {
			var delay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10);
			if (delay) { el.style.setProperty('--reveal-delay', delay + 'ms'); }
		});

		if ('IntersectionObserver' in window && !reduceMotion) {
			var io = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-revealed');
						io.unobserve(entry.target);
					}
				});
			}, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });
			revealEls.forEach(function (el) { io.observe(el); });
		} else {
			revealEls.forEach(function (el) { el.classList.add('is-revealed'); });
		}
	}

	/* ------------------------------------------------------------------
	 * Copy link (share)
	 * ---------------------------------------------------------------- */
	qsa('.copy-link').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var url = btn.getAttribute('data-url') || window.location.href;
			var done = function () {
				btn.classList.add('is-copied');
				var original = btn.getAttribute('aria-label');
				btn.setAttribute('aria-label', btn.getAttribute('data-copied') || settings.i18n.copied || 'Copied');
				setTimeout(function () {
					btn.classList.remove('is-copied');
					btn.setAttribute('aria-label', original);
				}, 1800);
			};
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(url).then(done).catch(done);
			} else {
				var tmp = document.createElement('input');
				tmp.value = url;
				document.body.appendChild(tmp);
				tmp.select();
				try { document.execCommand('copy'); } catch (err) { /* ignore */ }
				document.body.removeChild(tmp);
				done();
			}
		});
	});

	/* ------------------------------------------------------------------
	 * Smooth anchor scrolling that accounts for the sticky header
	 * ---------------------------------------------------------------- */
	document.addEventListener('click', function (e) {
		var link = e.target.closest('a[href^="#"]');
		if (!link) { return; }
		var id = link.getAttribute('href').slice(1);
		if (!id) { return; }
		var target = document.getElementById(id);
		if (!target) { return; }
		e.preventDefault();
		var offset = (header ? header.offsetHeight : 0) + 16;
		var top = target.getBoundingClientRect().top + window.scrollY - offset;
		window.scrollTo({ top: top, behavior: reduceMotion ? 'auto' : 'smooth' });
		if (history.pushState) { history.pushState(null, '', '#' + id); }
	});
})();
