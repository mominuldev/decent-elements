(function ($) {
	"use strict";

	class DecentAnimatedTestimonials {
		constructor(element) {
			this.$element = $(element);
			this.currentIndex = 0;
			this.testimonials = this.$element.find(".testimonial-item");
			this.images = this.$element.find(".testimonial-image");
			this.totalTestimonials = this.testimonials.length;
			this.autoplay = this.$element.data("autoplay") === true;
			this.autoplaySpeed = this.$element.data("autoplay-speed") || 5000;
			this.autoplayInterval = null;
			this.isAnimating = false;

			this.init();
		}

		init() {
			if (this.totalTestimonials === 0) return;

			this.bindEvents();
			this.setRandomRotations();
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

			// Pause autoplay on hover
			if (this.autoplay) {
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

			// Update images
			this.updateImages();

			// Update content with animation
			this.updateContent();

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

			// Fade in new content
			setTimeout(() => {
				$(this.testimonials[this.currentIndex]).addClass("active");
				this.animateWords(this.currentIndex);
			}, 100);
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
				}, index * 20); // 20ms delay between each word
			});
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
		$(".decent-animated-testimonials").decentAnimatedTestimonials();
	});

	// Re-initialize for dynamically added content (Elementor preview)
	$(window).on("elementor/frontend/init", function () {
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/decent-animated-testimonials.default",
			function ($scope) {
				$scope
					.find(".decent-animated-testimonials")
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
			$(".decent-animated-testimonials").each(function () {
				observer.observe(this);
			});
		});
	}
})(jQuery);
