<?php
/**
 * Maker's Mark: "Crafted by GP" Industrial Engineering Easter Egg.
 *
 * Sequence: typing 'gpgp' outside form inputs triggers the signature industrial badge.
 *
 * @package GPIndustry
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Maker's Mark in wp_footer.
 */
function gpi_makers_mark_footer() {
	if ( is_admin() ) {
		return;
	}
	?>
	<div id="gpi-makers-mark" class="gpi-makers-mark" aria-hidden="true">
		<div class="gpi-makers-card">
			<!-- Industrial Ambient Glow -->
			<div class="gpi-makers-glow"></div>

			<!-- Header Kicker -->
			<div class="gpi-makers-header">
				<span class="gpi-makers-tag">
					<svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
					GP-INDUSTRY
				</span>
			</div>

			<!-- Industrial Blueprint Emblem SVG -->
			<div class="gpi-makers-emblem">
				<svg viewBox="0 0 140 140" class="gpi-makers-svg" width="90" height="90" aria-hidden="true">
					<defs>
						<!-- Industrial Cyan-to-Indigo-to-Accent Gradient -->
						<linearGradient id="gpIndGrad" x1="0%" y1="0%" x2="100%" y2="100%">
							<stop offset="0%" stop-color="#06b6d4" />
							<stop offset="50%" stop-color="#6366f1" />
							<stop offset="100%" stop-color="#ec4899" />
						</linearGradient>

						<!-- Subtle Neon Glow Filter -->
						<filter id="gpIndGlow" x="-20%" y="-20%" width="140%" height="140%">
							<feDropShadow dx="0" dy="0" stdDeviation="3.5" flood-color="#6366f1" flood-opacity="0.65" />
						</filter>
					</defs>

					<!-- Outer Technical Calibration Rings -->
					<circle cx="70" cy="70" r="64" fill="none" stroke="rgba(99, 102, 241, 0.22)" stroke-width="1.2" stroke-dasharray="4 6" />
					<circle cx="70" cy="70" r="56" fill="none" stroke="rgba(6, 182, 212, 0.35)" stroke-width="1" />
					<circle cx="70" cy="70" r="50" fill="rgba(15, 23, 42, 0.6)" stroke="rgba(255, 255, 255, 0.08)" stroke-width="1" />

					<!-- Coordinate Reticle Crosshairs (Industrial Blueprint Ticks) -->
					<line x1="70" y1="6" x2="70" y2="14" stroke="#06b6d4" stroke-width="1.8" stroke-linecap="round" />
					<line x1="70" y1="126" x2="70" y2="134" stroke="#06b6d4" stroke-width="1.8" stroke-linecap="round" />
					<line x1="6" y1="70" x2="14" y2="70" stroke="#06b6d4" stroke-width="1.8" stroke-linecap="round" />
					<line x1="126" y1="70" x2="134" y2="70" stroke="#06b6d4" stroke-width="1.8" stroke-linecap="round" />

					<!-- Diagonal Micro-Ticks -->
					<circle cx="28" cy="28" r="1.5" fill="rgba(99, 102, 241, 0.6)" />
					<circle cx="112" cy="28" r="1.5" fill="rgba(99, 102, 241, 0.6)" />
					<circle cx="28" cy="112" r="1.5" fill="rgba(99, 102, 241, 0.6)" />
					<circle cx="112" cy="112" r="1.5" fill="rgba(99, 102, 241, 0.6)" />

					<!-- Engineered "G" Glyph (Precision CNC Track) -->
					<path
						d="M66 45 A25 25 0 1 0 66 89 L66 69 L51 69"
						fill="none"
						stroke="url(#gpIndGrad)"
						stroke-width="9.5"
						stroke-linecap="round"
						stroke-linejoin="round"
						filter="url(#gpIndGlow)"
					/>

					<!-- Engineered "P" Glyph (Interlocked Machined Stem) -->
					<path
						d="M79 97 L79 39 L93 39 A15 15 0 0 1 93 69 L79 69"
						fill="none"
						stroke="url(#gpIndGrad)"
						stroke-width="9.5"
						stroke-linecap="round"
						stroke-linejoin="round"
						filter="url(#gpIndGlow)"
					/>

					<!-- Precision Center Mechanical Pivot / Bolt -->
					<circle cx="70" cy="112" r="3.2" fill="#06b6d4" />
					<circle cx="70" cy="112" r="6" fill="none" stroke="rgba(6, 182, 212, 0.4)" stroke-width="1" />
				</svg>
			</div>

			<!-- Footer Signature & Status -->
			<div class="gpi-makers-footer">
				<span class="gpi-makers-crafted">CRAFTED BY GP</span>
				<div class="gpi-makers-meta">
					<span class="gpi-makers-dot"></span>
					<span class="gpi-makers-spec">HEAVY ENGINEERING &bull; &plusmn;0.005mm</span>
				</div>
			</div>
		</div>
	</div>

	<style>
		.gpi-makers-mark {
			position: fixed;
			bottom: 24px;
			left: 24px;
			z-index: 2147483000;
			pointer-events: none;
			display: none;
		}
		.gpi-makers-mark.is-visible {
			display: block;
			animation: gpIndustrialFade 3.5s cubic-bezier(0.16, 1, 0.3, 1) both;
		}
		@keyframes gpIndustrialFade {
			0% {
				opacity: 0;
				transform: translateY(20px) scale(0.92);
			}
			12% {
				opacity: 1;
				transform: translateY(0) scale(1);
			}
			82% {
				opacity: 1;
				transform: translateY(0) scale(1);
			}
			100% {
				opacity: 0;
				transform: translateY(12px) scale(0.96);
			}
		}
		.gpi-makers-card {
			position: relative;
			width: 136px;
			padding: 14px 12px 12px;
			border-radius: 20px;
			background: linear-gradient(150deg, rgba(17, 24, 39, 0.97) 0%, rgba(11, 15, 25, 0.99) 100%);
			border: 1px solid rgba(99, 102, 241, 0.45);
			box-shadow:
				0 24px 60px rgba(0, 0, 0, 0.75),
				0 0 35px rgba(99, 102, 241, 0.28),
				inset 0 1px 0 rgba(255, 255, 255, 0.15);
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
			backdrop-filter: blur(16px);
			-webkit-backdrop-filter: blur(16px);
			overflow: hidden;
		}
		.gpi-makers-glow {
			position: absolute;
			top: -40px;
			left: -40px;
			width: 100px;
			height: 100px;
			border-radius: 50%;
			background: radial-gradient(circle, rgba(6, 182, 212, 0.35) 0%, transparent 70%);
			pointer-events: none;
		}
		.gpi-makers-header {
			margin-bottom: 4px;
		}
		.gpi-makers-tag {
			display: inline-flex;
			align-items: center;
			gap: 4px;
			font-family: 'Outfit', ui-sans-serif, system-ui, sans-serif;
			font-size: 7.5px;
			font-weight: 800;
			letter-spacing: 0.2em;
			text-transform: uppercase;
			color: #38bdf8;
			background: rgba(6, 182, 212, 0.12);
			padding: 2px 7px;
			border-radius: 9999px;
			border: 1px solid rgba(6, 182, 212, 0.25);
		}
		.gpi-makers-emblem {
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 2px 0 6px;
		}
		.gpi-makers-svg {
			width: 82px;
			height: 82px;
			display: block;
			animation: gpReticleRotate 20s linear infinite;
		}
		@keyframes gpReticleRotate {
			0% { transform: rotate(0deg); }
			100% { transform: rotate(360deg); }
		}
		.gpi-makers-footer {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 3px;
			width: 100%;
		}
		.gpi-makers-crafted {
			font-family: 'Outfit', ui-sans-serif, system-ui, sans-serif;
			font-size: 8.5px;
			font-weight: 800;
			letter-spacing: 0.22em;
			color: #f8fafc;
			text-transform: uppercase;
			line-height: 1;
		}
		.gpi-makers-meta {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 4px;
		}
		.gpi-makers-dot {
			width: 5px;
			height: 5px;
			border-radius: 50%;
			background: #10b981;
			box-shadow: 0 0 6px #10b981;
			flex-shrink: 0;
			animation: gpPulse 1.8s ease-in-out infinite;
		}
		@keyframes gpPulse {
			0%, 100% { opacity: 1; transform: scale(1); }
			50% { opacity: 0.5; transform: scale(0.85); }
		}
		.gpi-makers-spec {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			font-size: 6.2px;
			font-weight: 700;
			letter-spacing: 0.08em;
			color: #94a3b8;
			text-transform: uppercase;
			white-space: nowrap;
		}
		@media (max-width: 640px) {
			.gpi-makers-mark {
				bottom: 16px;
				left: 16px;
			}
			.gpi-makers-card {
				width: 122px;
				padding: 10px 10px 8px;
			}
			.gpi-makers-svg {
				width: 72px;
				height: 72px;
			}
		}
	</style>

	<script>
	(function() {
		var SEQUENCE = 'gpgp';
		var WINDOW_MS = 1800;
		var SHOW_MS = 3500;
		var typed = '';
		var last = 0;
		var hideTimer = null;
		var el = document.getElementById('gpi-makers-mark');

		function showBadge() {
			if (!el) return;
			el.classList.remove('is-visible');
			void el.offsetWidth; // Force CSS reflow
			el.classList.add('is-visible');
			clearTimeout(hideTimer);
			hideTimer = setTimeout(function() {
				el.classList.remove('is-visible');
			}, SHOW_MS);
		}

		window.addEventListener('keydown', function(e) {
			var tag = e.target && e.target.tagName ? e.target.tagName.toUpperCase() : '';
			if (tag === 'INPUT' || tag === 'TEXTAREA' || (e.target && e.target.isContentEditable)) {
				return;
			}
			if (e.key === 'Escape') {
				if (el) el.classList.remove('is-visible');
				clearTimeout(hideTimer);
				return;
			}
			if (!e.key || e.key.length !== 1) {
				return;
			}
			var now = Date.now();
			typed = (now - last > WINDOW_MS ? '' : typed) + e.key.toLowerCase();
			last = now;

			if (typed.indexOf(SEQUENCE) !== -1 || (typed.endsWith && typed.endsWith(SEQUENCE))) {
				typed = '';
				showBadge();
			}
		});
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'gpi_makers_mark_footer', 999 );
