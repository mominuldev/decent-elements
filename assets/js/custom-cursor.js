class DecentCustomCursor {
	constructor() {
		this.cursor = null;
		this.isActive = false;
		this.init();
	}

	init() {
		if (this.isMobile()) return;

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', () => {
				this.createCursor();
				this.bindEvents();
			});
		} else {
			this.createCursor();
			this.bindEvents();
		}
	}

	isMobile() {
		return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	}

	createCursor() {
		this.cursor = document.getElementById('de-custom-cursor');
		if (!this.cursor) {
			console.warn('Custom cursor element not found');
			return;
		}

		gsap.set(this.cursor, {
			xPercent: -50,
			yPercent: -50,
			scale: 0
		});

		// Only hide cursor when we have cursor-enabled elements
		if (document.querySelector('[data-cursor-enabled="true"]')) {
			document.body.style.cursor = 'none';
			document.documentElement.style.cursor = 'none';
		}
	}

	bindEvents() {
		document.addEventListener('mousemove', this.onMouseMove.bind(this));

		// Bind to elements with cursor data
		this.bindCursorElements();

		// Re-bind when new content is loaded (for dynamic content)
		if (window.elementorFrontend) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', () => {
				setTimeout(() => this.bindCursorElements(), 100);
			});
		}
	}

	bindCursorElements() {
		document.querySelectorAll('[data-cursor-enabled="true"]').forEach(element => {
			// Remove existing listeners to prevent duplicates
			element.removeEventListener('mouseenter', element._cursorEnterHandler);
			element.removeEventListener('mouseleave', element._cursorLeaveHandler);

			// Create new handlers and store references
			element._cursorEnterHandler = () => this.showCursor(element);
			element._cursorLeaveHandler = () => this.hideCursor();

			element.addEventListener('mouseenter', element._cursorEnterHandler);
			element.addEventListener('mouseleave', element._cursorLeaveHandler);
		});
	}

	onMouseMove(e) {
		if (!this.cursor) return;

		gsap.to(this.cursor, {
			x: e.clientX,
			y: e.clientY,
			duration: 0.1,
			ease: "power2.out"
		});
	}

	showCursor(element) {
		if (!this.cursor) return;

		this.isActive = true;
		const type = element.dataset.cursorType;

		console.log('Showing cursor:', type, element.dataset); // Debug log

		// Clear previous content first
		this.clearContent();

		// Show cursor
		gsap.to(this.cursor, {
			scale: 1,
			duration: 0.3,
			ease: "back.out(1.7)"
		});

		// Show specific content based on type
		switch (type) {
			case 'text':
				if (element.dataset.cursorText) {
					this.showText(element.dataset.cursorText);
				}
				break;
			case 'icon':
				if (element.dataset.cursorIcon) {
					this.showIcon(element.dataset.cursorIcon);
				}
				break;
			case 'svg':
				if (element.dataset.cursorSvg) {
					this.showSvg(element.dataset.cursorSvg);
				}
				break;
			case 'image':
				if (element.dataset.cursorImage) {
					this.showImage(element.dataset.cursorImage);
				}
				break;
		}
	}

	hideCursor() {
		if (!this.cursor) return;

		gsap.to(this.cursor, {
			scale: 0,
			duration: 0.3,
			ease: "power2.inOut",
			onComplete: () => {
				this.clearContent();
				this.isActive = false;
			}
		});
	}

	showText(text) {
		if (!text) return;

		const textEl = this.cursor.querySelector('.de-cursor-text');
		if (textEl) {
			textEl.textContent = text;
			textEl.style.display = 'block';

			// Animate text in
			gsap.fromTo(textEl,
				{ scale: 0, opacity: 0 },
				{ scale: 1, opacity: 1, duration: 0.3, ease: "back.out(1.7)" }
			);
		}
	}

	showIcon(iconClass) {
		if (!iconClass) return;

		const iconEl = this.cursor.querySelector('.de-cursor-icon');
		if (iconEl) {
			iconEl.className = `de-cursor-icon ${iconClass}`;
			iconEl.style.display = 'flex';
			iconEl.style.alignItems = 'center';
			iconEl.style.justifyContent = 'center';

			// Animate icon in
			gsap.fromTo(iconEl,
				{ scale: 0, rotation: -180 },
				{ scale: 1, rotation: 0, duration: 0.4, ease: "back.out(1.7)" }
			);
		}
	}

	showSvg(svgCode) {
		if (!svgCode) return;

		const svgEl = this.cursor.querySelector('.de-cursor-svg');
		if (svgEl) {
			svgEl.innerHTML = svgCode;
			svgEl.style.display = 'block';

			// Animate SVG in
			gsap.fromTo(svgEl,
				{ scale: 0, opacity: 0 },
				{ scale: 1, opacity: 1, duration: 0.3, ease: "back.out(1.7)" }
			);
		}
	}

	showImage(imageSrc) {
		if (!imageSrc) return;

		const imageEl = this.cursor.querySelector('.de-cursor-image');
		if (imageEl) {
			imageEl.style.display = 'block';

			// Load image with callback
			imageEl.onload = () => {
				gsap.fromTo(imageEl,
					{ scale: 0, opacity: 0 },
					{ scale: 1, opacity: 1, duration: 0.3, ease: "back.out(1.7)" }
				);
			};

			imageEl.src = imageSrc;
		}
	}

	clearContent() {
		const content = this.cursor.querySelectorAll('.de-cursor-content > *');
		content.forEach(el => {
			// Kill any ongoing animations
			gsap.killTweensOf(el);

			// Hide element
			el.style.display = 'none';

			// Clear content
			if (el.tagName === 'IMG') {
				el.src = '';
				el.onload = null;
			} else if (el.classList.contains('de-cursor-svg')) {
				el.innerHTML = '';
			} else {
				el.textContent = '';
				el.className = el.className.split(' ')[0]; // Keep only base class
			}
		});
	}
}

// Initialize with better timing
function initCustomCursor() {
	if (typeof gsap !== 'undefined' && !window.decentCustomCursor) {
		window.decentCustomCursor = new DecentCustomCursor();
	}
}

// Multiple initialization points to ensure it loads
if (typeof gsap !== 'undefined') {
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initCustomCursor);
	} else {
		initCustomCursor();
	}
} else {
	// Wait for GSAP to load
	const checkGSAP = setInterval(() => {
		if (typeof gsap !== 'undefined') {
			clearInterval(checkGSAP);
			initCustomCursor();
		}
	}, 100);

	// Stop checking after 5 seconds
	setTimeout(() => clearInterval(checkGSAP), 5000);
}

// Elementor compatibility
if (window.elementorFrontend) {
	window.elementorFrontend.hooks.addAction('frontend/element_ready/global', () => {
		if (!window.decentCustomCursor && typeof gsap !== 'undefined') {
			initCustomCursor();
		}
	});
}