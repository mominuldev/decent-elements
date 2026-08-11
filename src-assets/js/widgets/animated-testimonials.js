(function ($) {
	"use strict";

	class DecentAnimatedTestimonials {
		constructor(element) {
			this.$element = $(element);
			this.currentIndex = 0;
			this.testimonials = this.$element.find(
				".testimonial-item, .testimonial-card",
			);
			this.images = this.$element.find(".testimonial-image");
			this.totalTestimonials = this.testimonials.length;
			this.autoplay = this.$element.data("autoplay") === true;
			this.autoplaySpeed = this.$element.data("autoplay-speed") || 5000;
			this.pauseOnHover = this.$element.data("pause-on-hover") !== false;
			this.autoplayInterval = null;
			this.isAnimating = false;
			this.layoutStyle = this.$element.hasClass(
				"decent-testimonials-style-2",
			)
				? "style-2"
				: "style-1";

			this.init();
		}

		init() {
			if (this.totalTestimonials === 0) return;

			this.bindEvents();

			// Initialize based on layout style
			if (this.layoutStyle === "style-1") {
				this.setRandomRotations();
				// Initialize title and designation animations for Style 1
				this.animateTitleAndDesignation(
					$(this.testimonials[this.currentIndex]),
				);
			} else if (this.layoutStyle === "style-2") {
				this.initializeCardStacking();
				// Initialize title and designation animations for Style 2
				this.animateTitleAndDesignation(
					$(this.testimonials[this.currentIndex]),
				);
			}

			this.animateWords(0);

			if (this.autoplay) {
				this.startAutoplay();
			}

			// Remove loading state
			setTimeout(() => {
				this.$element.removeClass("loading");
			}, 100);
		}

		bindEvents() {
			// Navigation buttons
			this.$element.find(".next-btn").on("click", () => this.next());
			this.$element.find(".prev-btn").on("click", () => this.prev());

			// Pagination dots
			this.$element.find(".pagination-dot").on("click", (e) => {
				const index = parseInt($(e.target).data("index"));
				this.goToSlide(index);
			});

			// Conditional pause autoplay on hover
			if (this.autoplay && this.pauseOnHover) {
				this.$element.on("mouseenter", () => this.pauseAutoplay());
				this.$element.on("mouseleave", () => this.startAutoplay());
			}

			// Handle keyboard navigation
			this.$element.on("keydown", (e) => {
				if (e.key === "ArrowLeft") {
					this.prev();
				} else if (e.key === "ArrowRight") {
					this.next();
				}
			});

			// Make focusable for accessibility
			this.$element.attr("tabindex", "0");
		}

		setRandomRotations() {
			this.images.each((index, image) => {
				if (index !== this.currentIndex) {
					const rotation = Math.floor(Math.random() * 21) - 10; // Random rotation between -10 and 10
					$(image).css(
						"transform",
						`scale(0.95) translateZ(-100px) rotate(${rotation}deg)`,
					);
				}
			});
		}

		initializeCardStacking() {
			// Initialize card stacking for Style 2 with bottom view positioning
			this.testimonials.each((index, card) => {
				const $card = $(card);
				if (index !== this.currentIndex) {
					const rotation = Math.floor(Math.random() * 7) - 3;
					const distanceFromActive = Math.abs(
						index - this.currentIndex,
					);

					let scale, translateY, translateZ, opacity;

					if (distanceFromActive === 1) {
						scale = 0.95;
						translateY = 30;
						translateZ = -120;
						opacity = 0.5;
					} else if (distanceFromActive === 2) {
						scale = 0.92;
						translateY = 40;
						translateZ = -150;
						opacity = 0.4;
					} else {
						scale = 0.89;
						translateY = 50;
						translateZ = -180;
						opacity = 0.3;
					}

					$card.css({
						transform: `scale(${scale}) translateY(${translateY}px) translateZ(${translateZ}px) rotate(${rotation}deg)`,
						opacity: opacity,
						"z-index":
							this.totalTestimonials + 2 - distanceFromActive,
						"transform-origin": "center bottom",
					});
				}
			});
		}

		next() {
			if (this.isAnimating) return;
			this.currentIndex =
				(this.currentIndex + 1) % this.totalTestimonials;
			this.switchTestimonial();
		}

		prev() {
			if (this.isAnimating) return;
			this.currentIndex =
				(this.currentIndex - 1 + this.totalTestimonials) %
				this.totalTestimonials;
			this.switchTestimonial();
		}

		switchTestimonial() {
			if (this.isAnimating) return;
			this.isAnimating = true;

			if (this.layoutStyle === "style-1") {
				// Update images for split layout
				this.updateImages();
				// Update content with animation
				this.updateContent();
			} else {
				// Update cards for card layout
				this.updateCards();
			}

			// Reset animation flag
			setTimeout(() => {
				this.isAnimating = false;
			}, 400);
		}

		updateImages() {
			this.images.removeClass("active");

			// Set random rotations for non-active images
			this.images.each((index, image) => {
				const $image = $(image);
				if (index !== this.currentIndex) {
					const rotation = Math.floor(Math.random() * 21) - 10;
					$image.css({
						transform: `scale(0.95) translateZ(-100px) rotate(${rotation}deg)`,
						opacity: "0.7",
						"z-index": this.totalTestimonials + 2 - index,
					});
				} else {
					$image.addClass("active").css({
						transform: "scale(1) translateZ(0) rotate(0deg)",
						opacity: "1",
						"z-index": "40",
					});
				}
			});
		}

		updateContent() {
			// Fade out current content
			this.testimonials.removeClass("active");

			// Fade in new content with staggered animations
			setTimeout(() => {
				const $newTestimonial = $(this.testimonials[this.currentIndex]);
				$newTestimonial.addClass("active");

				// Animate title and designation with stagger
				this.animateTitleAndDesignation($newTestimonial);
				this.animateWords(this.currentIndex);
				this.updatePagination();
			}, 100);
		}

		animateTitleAndDesignation($testimonial) {
			const $name = $testimonial.find(".testimonial-name");
			const $designation = $testimonial.find(".testimonial-designation");

			// Reset animations
			$name.css({
				opacity: "0",
				transform: "translateY(20px)",
			});

			$designation.css({
				opacity: "0",
				transform: "translateY(15px)",
			});

			// Trigger animations with stagger
			setTimeout(() => {
				$name.css({
					opacity: "1",
					transform: "translateY(0)",
				});
			}, 50);

			setTimeout(() => {
				$designation.css({
					opacity: "1",
					transform: "translateY(0)",
				});
			}, 150);
		}

		updateCards() {
			// For card layout, switch active card with enhanced stacking effect
			this.testimonials.removeClass("active");

			// Apply enhanced stacking with bottom view positioning
			this.testimonials.each((index, card) => {
				const $card = $(card);
				if (index !== this.currentIndex) {
					const rotation = Math.floor(Math.random() * 7) - 3; // Rotation between -3 and 3
					const distanceFromActive = Math.abs(
						index - this.currentIndex,
					);

					// Progressive scaling and positioning based on distance from active
					let scale, translateY, translateZ, opacity;

					if (distanceFromActive === 1) {
						scale = 0.95;
						translateY = 30;
						translateZ = -120;
						opacity = 0.5;
					} else if (distanceFromActive === 2) {
						scale = 0.92;
						translateY = 40;
						translateZ = -150;
						opacity = 0.4;
					} else {
						scale = 0.89;
						translateY = 50;
						translateZ = -180;
						opacity = 0.3;
					}

					$card.css({
						transform: `scale(${scale}) translateY(${translateY}px) translateZ(${translateZ}px) rotate(${rotation}deg)`,
						opacity: opacity,
						"z-index":
							this.totalTestimonials + 2 - distanceFromActive,
						"transform-origin": "center bottom",
					});
				} else {
					$card.addClass("active").css({
						transform:
							"scale(1) translateY(0) translateZ(0) rotate(0deg)",
						opacity: "1",
						"z-index": "40",
						"transform-origin": "center center",
					});

					// Animate title and designation for Style 2
					this.animateTitleAndDesignation($card);
				}
			});

			this.animateWords(this.currentIndex);
			this.updatePagination();
		}

		animateWords(testimonialIndex) {
			const $testimonial = $(this.testimonials[testimonialIndex]);
			const $quote = $testimonial.find(".testimonial-quote");
			const text = $quote.text();

			if (!text) return;

			// Split text into words and wrap each in a span
			const words = text.split(" ");
			const wrappedText = words
				.map((word) => `<span class="word">${word}</span>`)
				.join(" ");

			$quote.addClass("animate-words").html(wrappedText);

			// Animate each word
			const $words = $quote.find(".word");
			$words.each((index, word) => {
				setTimeout(() => {
					$(word).addClass("visible");
				}, index * 40); // 20ms delay between each word
			});
		}

		updatePagination() {
			const $dots = this.$element.find(".pagination-dot");
			$dots.removeClass("active");
			$dots.eq(this.currentIndex).addClass("active");
		}

		goToSlide(index) {
			if (this.isAnimating || index === this.currentIndex) return;
			this.currentIndex = index;
			this.switchTestimonial();
		}

		startAutoplay() {
			if (!this.autoplay) return;

			this.pauseAutoplay(); // Clear any existing interval
			this.autoplayInterval = setInterval(() => {
				this.next();
			}, this.autoplaySpeed);
		}

		pauseAutoplay() {
			if (this.autoplayInterval) {
				clearInterval(this.autoplayInterval);
				this.autoplayInterval = null;
			}
		}

		destroy() {
			this.pauseAutoplay();
			this.$element.off();
			this.$element.find(".next-btn, .prev-btn").off();
		}
	}

	// Plugin initialization
	$.fn.decentAnimatedTestimonials = function (options) {
		return this.each(function () {
			const $this = $(this);
			let instance = $this.data("decentAnimatedTestimonials");

			if (!instance) {
				instance = new DecentAnimatedTestimonials(this);
				$this.data("decentAnimatedTestimonials", instance);
			}
		});
	};

	// Auto-initialize on document ready
	$(document).ready(function () {
		$(".de-animated-testimonials").decentAnimatedTestimonials();
	});

	// Re-initialize for dynamically added content (Elementor preview)
	$(window).on("elementor/frontend/init", function () {
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/de-animated-testimonials.default",
			function ($scope) {
				$scope
					.find(".de-animated-testimonials")
					.decentAnimatedTestimonials();
			},
		);
	});

	// Intersection Observer for performance (optional enhancement)
	if ("IntersectionObserver" in window) {
		const observer = new IntersectionObserver(
			(entries) => {
				entries.forEach((entry) => {
					const $element = $(entry.target);
					const instance = $element.data(
						"decentAnimatedTestimonials",
					);

					if (instance) {
						if (entry.isIntersecting) {
							instance.startAutoplay();
						} else {
							instance.pauseAutoplay();
						}
					}
				});
			},
			{
				threshold: 0.5,
			},
		);

		$(document).ready(function () {
			$(".de-animated-testimonials").each(function () {
				observer.observe(this);
			});
		});
	}
})(jQuery);
