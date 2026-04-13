/**
 * Slideshow Component
 * Provides automatic slideshow functionality with navigation controls
 */
class Slideshow {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error(`Slideshow container with id "${containerId}" not found`);
            return;
        }

        // Default options
        this.options = {
            autoPlay: true,
            autoPlayInterval: 5000,
            transitionDuration: 500,
            ...options
        };

        this.currentIndex = 0;
        this.autoPlayInterval = null;
        this.isTransitioning = false;

        this.init();
    }

    init() {
        this.slides = this.container.querySelectorAll('[data-slide]');
        this.dots = this.container.querySelectorAll('[data-slide-dot]');
        this.prevBtn = this.container.querySelector('[data-slide-prev]');
        this.nextBtn = this.container.querySelector('[data-slide-next]');

        if (this.slides.length === 0) {
            console.warn('No slides found in slideshow');
            return;
        }

        // Show first slide
        this.showSlide(0);

        // Attach event listeners
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prev());
        }
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.next());
        }

        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });

        // Start auto play
        if (this.options.autoPlay && this.slides.length > 1) {
            this.startAutoPlay();
            
            // Pause on hover
            this.container.addEventListener('mouseenter', () => this.stopAutoPlay());
            this.container.addEventListener('mouseleave', () => this.startAutoPlay());
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (this.container.offsetParent !== null) { // Check if element is visible
                if (e.key === 'ArrowLeft') this.prev();
                if (e.key === 'ArrowRight') this.next();
            }
        });
    }

    showSlide(index) {
        // Hide all slides
        this.slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.opacity = '0';
        });

        // Remove active class from all dots
        this.dots.forEach(dot => {
            dot.classList.remove('active');
        });

        // Show current slide
        if (this.slides[index]) {
            this.slides[index].classList.add('active');
            this.slides[index].style.opacity = '1';
            this.currentIndex = index;

            // Update active dot
            if (this.dots[index]) {
                this.dots[index].classList.add('active');
            }
        }
    }

    prev() {
        if (this.isTransitioning) return;
        
        let index = this.currentIndex - 1;
        if (index < 0) {
            index = this.slides.length - 1;
        }
        this.goToSlide(index);
    }

    next() {
        if (this.isTransitioning) return;
        
        let index = this.currentIndex + 1;
        if (index >= this.slides.length) {
            index = 0;
        }
        this.goToSlide(index);
    }

    goToSlide(index) {
        if (this.isTransitioning || index === this.currentIndex) return;
        
        this.isTransitioning = true;

        this.showSlide(index);

        setTimeout(() => {
            this.isTransitioning = false;
        }, this.options.transitionDuration);
    }

    startAutoPlay() {
        if (this.autoPlayInterval) return;
        
        this.autoPlayInterval = setInterval(() => {
            this.next();
        }, this.options.autoPlayInterval);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }

    destroy() {
        this.stopAutoPlay();
        if (this.prevBtn) {
            this.prevBtn.removeEventListener('click', () => this.prev());
        }
        if (this.nextBtn) {
            this.nextBtn.removeEventListener('click', () => this.next());
        }
    }
}

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Slideshow;
}
