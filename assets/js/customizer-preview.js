/**
 * GP-Industry – Customizer live preview
 */
(function (api) {
	'use strict';

	if (!api) { return; }

	function hexToRgb(hex) {
		hex = (hex || '').replace('#', '');
		if (hex.length === 3) { hex = hex.split('').map(function (c) { return c + c; }).join(''); }
		if (hex.length !== 6) { return null; }
		var n = parseInt(hex, 16);
		return [(n >> 16) & 255, (n >> 8) & 255, n & 255].join(', ');
	}

	function darken(hex, amt) {
		hex = (hex || '').replace('#', '');
		if (hex.length !== 6) { return '#' + hex; }
		var out = '#';
		for (var i = 0; i < 3; i++) {
			var v = Math.max(0, Math.min(255, parseInt(hex.substr(i * 2, 2), 16) + amt));
			out += ('0' + v.toString(16)).slice(-2);
		}
		return out;
	}

	var root = document.documentElement;

	api('blogname', function (value) {
		value.bind(function (to) {
			document.querySelectorAll('.site-title, .footer-site-title').forEach(function (el) { el.textContent = to; });
		});
	});

	api('blogdescription', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.footer-tagline');
			if (el && !el.dataset.custom) { el.textContent = to; }
		});
	});

	api('gpi_accent_color', function (value) {
		value.bind(function (to) {
			var rgb = hexToRgb(to);
			if (!rgb) { return; }
			root.style.setProperty('--color-primary', to);
			root.style.setProperty('--color-primary-rgb', rgb);
			root.style.setProperty('--color-primary-hover', darken(to, -20));
		});
	});

	api('gpi_accent_color_2', function (value) {
		value.bind(function (to) {
			var rgb = hexToRgb(to);
			if (!rgb) { return; }
			root.style.setProperty('--color-accent', to);
			root.style.setProperty('--color-accent-rgb', rgb);
		});
	});

	api('gpi_radius', function (value) {
		value.bind(function (to) {
			var r = parseInt(to, 10) || 0;
			root.style.setProperty('--radius-lg', r + 'px');
			root.style.setProperty('--radius-md', Math.max(6, r - 4) + 'px');
			root.style.setProperty('--radius-xl', (r + 8) + 'px');
		});
	});

	api('gpi_hero_badge', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.hero-badge-text');
			if (el) { el.textContent = to; }
		});
	});

	api('gpi_hero_title', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.hero-title');
			if (el) { el.innerHTML = to; }
		});
	});

	api('gpi_hero_subtitle', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.hero-subtitle');
			if (el) { el.textContent = to; }
		});
	});

	api('gpi_footer_copyright', function (value) {
		value.bind(function (to) {
			var el = document.querySelector('.footer-copyright');
			if (el && to) { el.innerHTML = to.replace('{year}', new Date().getFullYear()); }
		});
	});
})(window.wp && window.wp.customize);
